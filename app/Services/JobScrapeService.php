<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JobScrapeService
{
    protected $tokenId;
    protected $tokenSecret;
    protected $baseUrl;

    public function __construct()
    {
        $this->tokenId = config('services.modal.token_id');
        $this->tokenSecret = config('services.modal.token_secret');
        $this->baseUrl = config('services.modal.base_url', 'https://api.modal.com');
    }

    /**
     * Test API connection
     */
    public function testConnection()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->tokenId . ':' . $this->tokenSecret,
                'Content-Type' => 'application/json',
            ])->timeout(30)->get($this->baseUrl . '/v1/apps');

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'data' => $response->json(),
                'message' => $response->successful() ? 'Connected successfully' : 'Connection failed',
            ];
        } catch (\Exception $e) {
            Log::error('Modal API connection test failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Scrape job from URL
     */
    public function scrapeJob($url)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->tokenId . ':' . $this->tokenSecret,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post($this->baseUrl . '/v1/scrape', [
                'url' => $url,
                'extract' => [
                    'title',
                    'organization',
                    'description',
                    'last_date',
                    'notification_date',
                    'total_posts',
                    'important_links',
                ],
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json()['error'] ?? 'Unknown error',
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('Job scraping failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Scrape multiple jobs
     */
    public function scrapeMultipleJobs(array $urls)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->tokenId . ':' . $this->tokenSecret,
                'Content-Type' => 'application/json',
            ])->timeout(120)->post($this->baseUrl . '/v1/scrape/batch', [
                'urls' => $urls,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json()['error'] ?? 'Unknown error',
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('Batch job scraping failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
