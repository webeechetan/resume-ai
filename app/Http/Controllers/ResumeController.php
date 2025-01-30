<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\PdfToText\Pdf;
use App\Services\ResumeParserService;
use Illuminate\Support\Facades\Log;

class ResumeController extends Controller
{
    public function index()
    {
        return view('resume.upload');
    }

    public function store(Request $request)
    {
        $jobDescription = $request->job_description;
        $resumesText = [];

        foreach ($request->file('resume') as $file) {
            $resume = $file->store('resumes');
            $filePath = storage_path('app/public/' . $resume);
            $pdfToTextPath = 'c:/Program Files/Git/mingw64/bin/pdftotext';
            $text = Pdf::getText($filePath, $pdfToTextPath);
            $resumesText[] = $text;
        }


        $resumeService = new ResumeParserService();
        $parsedData = $resumeService->parseResume($resumesText, $jobDescription);
        Log::info($parsedData);

        return view('resume.upload', ['data' => $parsedData]);
    }
}
