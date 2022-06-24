<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontendGenreController extends Controller
{
    public function show(Genre $genre)
    {
        return Inertia::render('Frontend/Genres/Index', [
            'genre' => $genre,
            'movies' => $genre->movies()->paginate(12)
        ]);
    }
}
