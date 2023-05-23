<?php

namespace Tests\Feature;

use App\Enums\Category;
use App\Models\Bdrf;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Vrbr;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use Throwable;

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

    /**
     * @dataProvider page_data_that_should_succeed
     * @throws Throwable
     */
    public function test_certificate_pages_can_be_updated(array $data): void
    {
        $order = Order::factory()
            ->for(Customer::factory()->create())
            ->for(Category::getModelInstance($data['model'])::factory(), 'certificate')
            ->create();

        $response = $this->put(
            URL::signedRoute('certificate.update.page', [
                'order' => $order->slug,
                'page' => $data['page'],
            ]),
            $data['data']
        );

        $response->assertRedirectToRoute('certificate.show.page', [
            'order' => $order->slug,
            'page' => Category::fromModel($data['model'])->getNextPageAfter($data['page']),
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

        $response = $this->put(
            URl::signedRoute('certificate.update.page', [
                'order' => $order->slug,
                'page' => 'general',
            ])
        );

        $response->assertForbidden();
    }

    public function page_data_that_should_succeed(): array
    {
        return [
            'bdrf:general' => [
                [
                    'model' => Bdrf::class,
                    'page' => 'general',
                    'data' => [
                        'name' => 'Updated Name',
                        'email' => 'test@email.de',
                        'phone' => '0123456789',
                        'reason' => 'Neubau',
                        'street_address' => 'Updated 1',
                        'zip' => '54321',
                        'city' => 'Updated City',
                        'type' => 'Einfamilienhaus',
                        'additional_type' => 'Reiheneckhaus',
                    ],
                ],
            ],
            'bdrf:details' => [
                [
                    'model' => Bdrf::class,
                    'page' => 'details',
                    'data' => [
                        'construction_year' => 2005,
                        'floor_area' => 200,
                        'housing_units' => 4,
                        'ventilation' => 'Anlage mit Wärmerückgewinnung',
                        'renewables' => 'Solarthermie',
                        'renewables_reason' => 'Warmwasser',
                        'cooling' => 'Aus Strom',
                        'cooling_count' => 1,
                        'cooling_service' => "2023-11-24T23:00:00.000Z",
                        "suggestion_check" => [
                            "windows" => true,
                            "external_wall" => true,
                            "attic" => false,
                            "cellar_ceiling" => false,
                            "led" => false,
                        ],
                    ],
                ],
            ],
            'bdrf:position' => [
                [
                    'model' => Bdrf::class,
                    'page' => 'position',
                    'data' => [
                        'side_a' => 12,
                        'side_b' => 12,
                        'orientation' => 's',
                    ],
                ],
            ],
            'vrbr:general' => [
                [
                    'model' => Vrbr::class,
                    'page' => 'general',
                    'data' => [
                        'name' => 'Updated Name',
                        'email' => 'test@email.de',
                        'phone' => '0123456789',
                        'reason' => 'Neubau',
                        'street_address' => 'Updated 1',
                        'zip' => '54321',
                        'city' => 'Updated City',
                        'type' => 'Einfamilienhaus',
                        'additional_type' => 'Reiheneckhaus',
                    ],
                ],
            ],
            'vrbr:details' => [
                [
                    'model' => Vrbr::class,
                    'page' => 'details',
                    'data' => [
                        'construction_year' => 2005,
                        'construction_year_heating' => 2005,
                        'floor_area' => 200,
                        'housing_units' => 4,
                        'ventilation' => 'Anlage mit Wärmerückgewinnung',
                        'cellar' => 'Kein Keller',
                        'renewables' => 'Solarthermie',
                        'renewables_reason' => 'Warmwasser',
                        'cooling' => 'Aus Strom',
                        'cooling_count' => 1,
                        'cooling_service' => "2023-11-24T23:00:00.000Z",
                        "suggestion_check" => [
                            "windows" => true,
                            "external_wall" => true,
                            "attic" => false,
                            "cellar_ceiling" => false,
                            "led" => false,
                        ],
                    ],
                ],
            ],
        ];
    }
}
