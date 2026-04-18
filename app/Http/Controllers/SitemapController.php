<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $baseUrl = rtrim(config('app.url'), '/');

        $staticPages = [
            ['loc' => $baseUrl . '/',          'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => $baseUrl . '/courses',   'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => $baseUrl . '/services',  'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/portfolio', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        $courses = Course::select('slug', 'updated_at')
            ->orderBy('sort_order')
            ->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        foreach ($staticPages as $page) {
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . e($page['loc']) . '</loc>' . PHP_EOL;
            $xml .= '    <changefreq>' . $page['changefreq'] . '</changefreq>' . PHP_EOL;
            $xml .= '    <priority>' . $page['priority'] . '</priority>' . PHP_EOL;
            $xml .= '  </url>' . PHP_EOL;
        }

        foreach ($courses as $course) {
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . e($baseUrl . '/courses/' . $course->slug) . '</loc>' . PHP_EOL;
            $xml .= '    <lastmod>' . $course->updated_at->toAtomString() . '</lastmod>' . PHP_EOL;
            $xml .= '    <changefreq>monthly</changefreq>' . PHP_EOL;
            $xml .= '    <priority>0.7</priority>' . PHP_EOL;
            $xml .= '  </url>' . PHP_EOL;
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}
