<?php

declare(strict_types=1);

namespace App\Http\Controllers\Hub\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @author Your Name <your.email@aboutyou.com>
 */
class ShowController extends Controller
{

    public function index(): RedirectResponse
    {
        return redirect()->route('hub.admin.blog');
    }

    public function blog(): Response
    {
        return Inertia::render('Hub/Admin/Blog', [
            'title' => 'Blog',
            'subtitle' => 'Blog',
        ]);
    }

}
