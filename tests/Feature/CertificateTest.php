<?php

namespace Tests\Feature;

use App\Enums\Category;
use App\Models\Bdrf;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class CertificateTest extends TestCase
{

    use RefreshDatabase;

    public function test_certificate_initial_show_redirects_to_page(): void
    {
        $order = Order::factory()
            ->for(Customer::factory()->create())
            ->for(Bdrf::factory(), 'certificate')
            ->create();

        $response = $this->get(URL::signedRoute('certificate.show', $order->slug));

        $response->assertRedirectToRoute('certificate.show.page', [
            'order' => $order->slug,
            'page' => 'general',
        ]);
    }

    public function test_all_pages_for_all_certificates_can_be_rendered(): void
    {
        foreach (Category::cases() as $category) {
            $order = Order::factory()
                ->for(Customer::factory()->create())
                ->for($category->getModel()::factory(), 'certificate')
                ->create();

            foreach ($category->getAvailablePages() as $page => $details) {
                $response = $this->get(
                    URL::signedRoute('certificate.show.page', [
                        'order' => $order->slug,
                        'page' => $page,
                    ])
                );

                $response->assertOk();
            }
        }
    }

    public function test_certificate_unknown_page_cant_be_rendered(): void
    {
        $order = Order::factory()
            ->for(Customer::factory()->create())
            ->for(Bdrf::factory(), 'certificate')
            ->create();

        $response = $this->get(
            URL::signedRoute('certificate.show.page', [
                'order' => $order->slug,
                'page' => 'unknown',
            ])
        );

        $response->assertNotFound();
    }

    public function test_certificate_general_can_be_updated(): void
    {
        $order = Order::factory()
            ->for(Customer::factory()->create())
            ->for(Bdrf::factory(), 'certificate')
            ->create();

        $response = $this->put(
            URL::signedRoute('certificate.update.page', [
                'order' => $order->slug,
                'page' => 'general',
            ]),
            [
                'name' => 'Updated Name',
                'email' => 'test@test.de',
                'phone' => null,
                'reason' => 'Neubau',
                'street_address' => 'Updated 1',
                'zip' => '54321',
                'city' => 'Updated City',
                'type' => 'Einfamilienhaus',
                'additional_type' => 'Reiheneckhaus',
            ]
        );

        $response->assertRedirectToRoute('certificate.show.page', [
            'order' => $order->slug,
            'page' => 'details',
        ]);

        $this->assertDatabaseHas('bdrfs', [
            'street_address' => 'Updated 1',
            'zip' => '54321',
            'city' => 'Updated City',
            'type' => 'Einfamilienhaus',
            'additional_type' => 'Reiheneckhaus',
        ]);

        $this->assertDatabaseHas('customers', [
            'name' => 'Updated Name',
            'email' => 'test@test.de',
        ]);
    }

    public function test_certificate_general_cant_be_updated_with_invalid_data(): void
    {
        $order = Order::factory()
            ->for(Customer::factory()->create())
            ->for(Bdrf::factory(), 'certificate')
            ->create();

        $response = $this->put(
            URL::signedRoute('certificate.update.page', [
                'order' => $order->slug,
                'page' => 'general',
            ]),
            ['name' => 'Updated Name']
        );

        $response->assertStatus(302);

        $this->assertDatabaseMissing('customers', [
            'name' => 'Updated Name',
        ]);
    }


    public function test_certificate_cant_be_accessed_when_status_is_open(): void
    {
        $order = Order::factory()
            ->for(Customer::factory()->create())
            ->for(Bdrf::factory(), 'certificate')
            ->create([
                'status' => 'open',
            ]);

        $response = $this->get(URL::signedRoute('certificate.show', $order->slug));

        $response->assertRedirectToRoute('order.show', $order->slug);
    }

    public function test_certificate_cant_be_updated_when_status_is_open(): void
    {
        $order = Order::factory()
            ->for(Customer::factory()->create())
            ->for(Bdrf::factory(), 'certificate')
            ->create([
                'status' => 'open',
            ]);

        $response = $this->put(URl::signedRoute('certificate.update.page', [
            'order' => $order->slug,
            'page' => 'general',
        ]));

        $response->assertForbidden();
    }


}
