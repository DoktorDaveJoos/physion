<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogEntry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowController extends Controller
{

    /**
     * Display the specified resource.
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Blog/Index', [
            'posts' => BlogEntry::all()->sortBy('published_at'),
        ]);
    }

    public function show(string $slug): Response
    {
        return Inertia::render('Blog/Show', [
            'post' => BlogEntry::findBySlug($slug),
        ]);
    }
}
