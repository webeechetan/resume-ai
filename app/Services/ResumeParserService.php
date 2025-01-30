<?php

namespace App\Services;

use GuzzleHttp\Client;

class ResumeParserService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function parseResume(array $resumesText, string $jobDescription = null)
    {
        $responses = [];
        foreach ($resumesText as $resumeText) {
            // $resumeText = str_replace('b"""','',$resumeText);
            // echo $resumeText;
            // die;
            $resumeText = $this->cleanAndEncodeText($resumeText);
            // dd($resumeText);
            // Clean and ensure proper encoding
            $response = $this->client->post('chat/completions', [
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 
                        'You are a resume parser and sorter.
                        Extract structured data from text like 
                        name : string 
                        age : number	
                        location : string 
                        email : string	
                        phone_number : string	
                        highest_degree : string 
                        total_work_experience : string
                        skill_set : array	
                        key_achievements : array (within 20 words)
                        current_previous_role : array	(within 20 words)
                        years_of_experience : string	
                        expected_salary : string	
                        availability : string	
                        languages_known : array	
                        linkedin_profile : string	
                        portfolio_website : string 
                        references_referrals : array
                        in json format dont include other keys just give josn format of above keys
                        and sort json format with best match to job description job description is this : ' .$jobDescription
                        ],
                        ['role' => 'user', 'content' => $resumeText],
                    ],
                    'max_tokens' => 800,
                ],
            ]);
            $parsedResponse = json_decode($response->getBody(), true);
            $responses[] = $parsedResponse['choices'][0]['message']['content'] ?? 'Error in parsing';
        }

        return $responses;
    }

    private function cleanAndEncodeText($text)
    {

        // 1. Remove control characters (including form feeds \f)
     // Step 1: Convert the binary content to UTF-8 safely
     $text = @iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8//IGNORE", $text);

     // Step 2: Remove control characters (including form feeds)
     $text = preg_replace('/[\x00-\x1F\x7F-\x9F\xA0\f]/u', '', $text);
 
     // Step 3: Normalize spaces and line breaks
     $text = preg_replace('/[ \t]+/', ' ', $text);  // Collapse multiple spaces
     $text = preg_replace('/\n+/', "\n", $text);    // Collapse multiple line breaks
 
     // Step 4: Clean up unnecessary special symbols or artifacts
     $text = trim($text);
 
     // Fallback if text remains unreadable
     return $text ?: 'Unable to extract meaningful text from the resume.';

    }

    
}
