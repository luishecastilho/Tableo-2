<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class IndexController extends Controller
{
    private string $apiUrl = 'https://api.kanye.rest/';

    public function index()
    {
        return view('index');
    }

    public function quotes()
    {
        $response = Http::get($this->apiUrl.'quotes');

        if ($response->successful()) {
            $data = $response->json();

            return Arr::random($data, 5);
        }

        return [];
    }
}
