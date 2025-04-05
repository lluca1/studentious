<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Smalot\PdfParser\Parser;

class AIContentController extends Controller
{
    protected $client;
    protected $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_TOKEN'),
            'Content-Type' => 'application/json',
        ];
    }

    public function generate(Request $request)
    {
        // Validate the request
        $request->validate([
            'pdf_path' => 'required|string',
            'curriculum_id' => 'required|integer',
        ]);

        $pdfPath = storage_path('app/public/' . $request->pdf_path);
        if (!file_exists($pdfPath)) {
            return back()->with('ai_error', 'PDF file not found.');
        }

        // Extract text from the PDF
        try {
            $parser = new Parser();
            $text = $parser->parseFile($pdfPath)->getText();
            $text = substr(strip_tags($text), 0, 2000); // Shorten for summary
        } catch (\Exception $e) {
            return back()->with('ai_error', 'Could not extract text from PDF.');
        }

        // Generate the summary using Hugging Face's summarization model
        try {
            $response = $this->client->post('https://api-inference.huggingface.co/models/facebook/bart-large-cnn', [
                'headers' => $this->headers,
                'json' => ['inputs' => $text],
            ]);

            $result = json_decode($response->getBody(), true);
            $summary = $result[0]['summary_text'] ?? null;

            if (empty($summary)) {
                return back()->with('ai_error', 'No summary returned from AI.');
            }
        } catch (\Exception $e) {
            return back()->with('ai_error', 'Summarization failed.');
        }

        // Generate the TTS podcast using Hugging Face
        try {
            $response = $this->client->post('https://api-inference.huggingface.co/models/espnet/kan-bayashi_ljspeech_vits', [
                'headers' => $this->headers,
                'json' => ['inputs' => $summary], // You could also send full text here
            ]);

            $body = $response->getBody()->getContents();

            // Check for errors in the response
            if (str_starts_with(trim($body), '{')) {
                $json = json_decode($body, true);
                return back()->with('ai_error', 'HF Error: ' . ($json['error'] ?? 'Unknown response'));
            }

            // Save the podcast audio to storage
            $filename = 'ai_podcast_' . time() . '.mp3';
            Storage::disk('public')->put($filename, $body);

            return back()->with([
                'ai_summary' => $summary,
                'ai_audio_url' => asset("storage/{$filename}"),
                'ai_curriculum_id' => $request->curriculum_id,
            ]);
        } catch (\Exception $e) {
            return back()->with('ai_error', 'Podcast generation failed: ' . $e->getMessage());
        }
    }
}
