<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ApiService
{
    protected string $baseUrl;
    protected string $locale;

    public function __construct()
    {
        $this->baseUrl = config('app.api_base_url', 'https://api.tujuhbulir.com/api/v1');
        $this->locale  = app()->getLocale() === 'ar' ? 'ar' : 'en';
    }

    protected function get(string $endpoint, array $params = []): array
    {
        $params['lang'] = $this->locale;
        $cacheKey = 'api_' . md5($endpoint . serialize($params));

        return Cache::remember($cacheKey, 300, function () use ($endpoint, $params) {
            try {
                $response = Http::timeout(10)->get("{$this->baseUrl}{$endpoint}", $params);
                if ($response->successful()) {
                    return $response->json() ?? [];
                }
            } catch (\Exception $e) {
                Log::error('ApiService error: ' . $e->getMessage());
            }
            return [];
        });
    }

    public function getProjects(int $page = 1, int $perPage = 10): array
    {
        return $this->get('/projects', ['page' => $page, 'per_page' => $perPage]);
    }

    public function getProject(string $id): array
    {
        return $this->get("/projects/{$id}");
    }

    public function getPrograms(int $page = 1): array
    {
        return $this->get('/programs', ['page' => $page]);
    }

    public function getProgram(string $id): array
    {
        return $this->get("/programs/{$id}");
    }

    public function getBlogs(int $page = 1): array
    {
        return $this->get('/blogs', ['page' => $page]);
    }

    public function getBlog(string $slug): array
    {
        return $this->get("/blogs/{$slug}");
    }

    public function getHomeData(): array
    {
        return $this->get('/');
    }

    public function getAboutData(): array
    {
        return $this->get('/about');
    }

    public function getFaqs(): array
    {
        return $this->get('/faqs');
    }

    public function getPartners(): array
    {
        return $this->get('/partners');
    }

    public function sendContactMessage(array $data): array
    {
        try {
            $response = Http::timeout(10)->post("{$this->baseUrl}/contact", $data);
            return $response->json() ?? [];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
