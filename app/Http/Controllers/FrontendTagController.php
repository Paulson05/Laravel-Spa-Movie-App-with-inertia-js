<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontendTagController extends Controller
{
    public function show(Tag $tag)
    {
        return Inertia::render('Frontend/Tags/Index', [
            'tag' => $tag,
            'movies' => $tag->movies()->paginate(12)
        ]);
    }
}
