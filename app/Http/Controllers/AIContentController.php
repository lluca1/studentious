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
            $text = substr(strip_tags($text), 0, 2000); // Shorten for summary
            
            // Remove special characters
            $text = preg_replace('/[^\p{L}\p{N}\s\.\,\;\:\!\?\'\"]/u', ' ', $text);
            $text = preg_replace('/\s+/', ' ', $text);
            $text = trim($text);
        } catch (\Exception $e) {
            return back()->with('ai_error', 'Could not extract text from PDF.');
        }
 
        // Hugging Face
        try {
            $response = $this->client->post('https://api-inference.huggingface.co/models/facebook/bart-large-cnn', [
                'headers' => $this->headers,
                'json' => [
                    'inputs' => $text,
                    'parameters' => [
                        'max_length' => 512, 'temperature' => 0.7
                    ]
                ],
            ]);
 
            $result = json_decode($response->getBody(), true);
            $summary = $result[0]['summary_text'] ?? null;
 
            if (empty($summary)) {
                return back()->with('ai_error', 'No summary returned from AI.');
            }
        } catch (\Exception $e) {
            return back()->with('ai_error', 'Summarization failed.');
        }
 
        // TTS Hugging Face
        try {
            $response = $this->client->post('https://api-inference.huggingface.co/models/espnet/kan-bayashi_ljspeech_vits', [
                'headers' => $this->headers,
                'json' => ['inputs' => $summary],
            ]);
 
            $body = $response->getBody()->getContents();
 
            if (str_starts_with(trim($body), '{')) {
                $json = json_decode($body, true);
                return back()->with('ai_error', 'HF Error: ' . ($json['error'] ?? 'Unknown response'));
            }
 
            $filename = 'ai_podcast_' . time() . '.mp3';
            Storage::disk('public')->put($filename, $body);
            
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
        } catch (\Exception $e) {
            return back()->with('ai_error', 'Podcast generation failed: ' . $e->getMessage());
        }
    }
}
