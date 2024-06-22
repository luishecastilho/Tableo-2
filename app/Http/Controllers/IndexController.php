<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class IndexController extends Controller
{
    private string $apiUrl = 'https://api.kanye.rest/';

    public function index()
    {
        return view('index');
    }

    public function quotes()
    {

    }
}
