<?php

namespace App\Http\Controllers;

use App\Enums\Category;

class CertificateController extends Controller
{
    public function show(Category $category, string $id)
    {
        return 200;
    }
}
