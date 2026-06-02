<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MovieService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('omdb.api_key');
        $this->baseUrl = config('omdb.base_url');
    }

    public function search($query, $page = 1)
    {
        try {
            $response = Http::get($this->baseUrl, [ // [FIX] pakai Http facade & https
                'apikey' => $this->apiKey,
                's'      => $query,
                'page'   => $page,
                'type'   => 'movie',
            ]);

            $data = $response->json();

            if ($data['Response'] === 'True') {
                return [
                    'movies' => $data['Search'],
                    'total'  => (int) $data['totalResults'],
                    'error'  => null,
                ];
            }

            return [
                'movies' => [],
                'total'  => 0,
                'error'  => $data['Error'],
            ];
        } catch (\Exception $e) {
            Log::error('OMDB error: ' . $e->getMessage());
            return false;
        }
    }

    public function detail($imdbId)
    {
        try {
            $response = Http::get($this->baseUrl, [
                'apikey' => $this->apiKey,
                'i'      => $imdbId,
                'plot'   => 'full',
            ]);

            $data = $response->json();

            Log::info('OMDB detail response: ', $data);

            if (isset($data['Response']) && $data['Response'] === 'True') {
                return $data;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('OMDB detail error: ' . $e->getMessage());
            return false;
        }
    }
}