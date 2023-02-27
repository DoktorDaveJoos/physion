<?php

namespace Tests\Feature;

use App\Enums\Category;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_show_product(): void
    {
        $response = $this->get('/products/' . Category::BDRF->value );

        $response->assertStatus(200);
    }
}
