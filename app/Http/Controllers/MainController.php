<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use thiagoalessio\TesseractOCR\TesseractOCR;

class MainController extends Controller
{
    /**
     * Preprocess OCR text.
     */
    private function preprocessText($text)
    {
        $text = preg_replace('/[^A-Za-z0-9\s.,]/', '', $text);
        $text = strtolower($text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        return $text;
    }

    /**
     * Displays the main page with form to upload an image for OCR.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Main');
    }

    /**
     * Processes an image uploaded in the request and runs OCR on it.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ocr(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $imagePath = $request->file('image')->store('images', 'public');

            $ocr = new TesseractOCR(storage_path('app/public/' . $imagePath));
            $ocrResult = $ocr->run();

            Storage::disk('public')->delete($imagePath);

            $processedText = $this->preprocessText($ocrResult);

            return response()->json([
                'status' => 'success',
                'text' => $processedText
            ]);
        } catch (\Exception $e) {
            Storage::disk('public')->delete($imagePath);
            Log::error('OCR Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing the image.'
            ], 500);
        }
    }
}
