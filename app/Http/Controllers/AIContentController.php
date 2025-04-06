<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Smalot\PdfParser\Parser;
use App\Models\Curriculum;

class AIContentController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function generate(Request $request)
    {
        $request->validate([
            'pdf_path' => 'required|string',
            'curriculum_id' => 'required|integer',
        ]);

        $pdfPath = storage_path('app/public/' . $request->pdf_path);
        if (!file_exists($pdfPath)) {
            return back()->with('ai_error', 'PDF file not found.');
        }

        try {
            $parser = new Parser();
            $text = $parser->parseFile($pdfPath)->getText();
            $text = substr(strip_tags($text), 0, 4000);

            $text = preg_replace('/[^\p{L}\p{N}\s\.\,\;\:\!\?\'\"]/u', ' ', $text);
            $text = preg_replace('/\s+/', ' ', $text);
            $text = trim($text);
        } catch (\Exception $e) {
            return back()->with('ai_error', 'Could not extract text from PDF.');
        }

        // OpenAI Summarization
        try {
            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.openai.key'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => "Summarize the following content in a concise paragraph:\n" . $text
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 500,
                ],
            ]);

            $result = json_decode($response->getBody(), true);
            $summary = $result['choices'][0]['message']['content'] ?? null;

            if (empty($summary)) {
                return back()->with('ai_error', 'No summary returned from OpenAI.');
            }
        } catch (\Exception $e) {
            return back()->with('ai_error', 'Summarization failed: ' . $e->getMessage());
        }

        // OpenAI TTS using the TTS endpoint (requires Whisper or compatible TTS)
        try {
            $speechResponse = $this->client->post('https://api.openai.com/v1/audio/speech', [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.openai.key'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'tts-1',
                    'input' => $summary,
                    'voice' => 'nova', // voices: alloy, echo, fable, onyx, nova, shimmer
                ],
                'stream' => true,
            ]);

            $filename = 'ai_podcasts/ai_podcast_' . time() . '.mp3';
            Storage::disk('public')->put($filename, $speechResponse->getBody()->getContents());
        } catch (\Exception $e) {
            return back()->with('ai_error', 'Podcast generation failed: ' . $e->getMessage());
        }

        $curriculum = Curriculum::find($request->curriculum_id);
        if ($curriculum) {
            $curriculum->ai_summary = $summary;
            $curriculum->ai_audio_url = asset("storage/{$filename}");
            $curriculum->save();
        }

        return back()->with([
            'ai_summary' => $summary,
            'ai_audio_url' => asset("storage/{$filename}"),
            'ai_curriculum_id' => $request->curriculum_id,
        ]);
    }
}