<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    private array $countries = [
        'in' => 'India',
        'uk' => 'United Kingdom',
        'us' => 'United States',
        'ca' => 'Canada',
        'au' => 'Australia',
    ];

    private function view(string $template, string $country)
    {
        return view($template, [
            'country' => $country,
            'countryName' => $this->countries[$country] ?? ucfirst($country),
        ]);
    }

    public function home(Request $request, string $country)
    {
        return $this->view('pages.home', $country);
    }

    public function about(Request $request, string $country)
    {
        return $this->view('pages.about', $country);
    }

    public function courses(Request $request, string $country)
    {
        return $this->view('pages.courses', $country);
    }

    public function cocurricular(Request $request, string $country)
    {
        return $this->view('pages.cocurricular', $country);
    }

    public function results(Request $request, string $country)
    {
        return $this->view('pages.results', $country);
    }

    public function gallery(Request $request, string $country)
    {
        return $this->view('pages.gallery', $country);
    }

    public function testimonials(Request $request, string $country)
    {
        return $this->view('pages.testimonials', $country);
    }

    public function blog(Request $request, string $country)
    {
        return $this->view('pages.blog', $country);
    }

    public function courseDetail(Request $request, string $country)
    {
        return $this->view('pages.course-detail', $country);
    }

    public function contact(Request $request, string $country)
    {
        return $this->view('pages.contact', $country);
    }
}
