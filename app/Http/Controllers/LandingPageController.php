<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
{
    // Ambil 3 event terbaru + cari harga tiket termurah dari relasi 'tikets'
    $events = Event::withMin('tikets', 'harga') 
        ->latest()
        ->limit(3)
        ->get();

    return view('welcome', compact('events'));
}
}