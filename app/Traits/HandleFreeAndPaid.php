<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Bdrf;
use App\Models\Vrbr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

trait HandleFreeAndPaid
{

    public static function handleRedirect(Request $request, Bdrf|Vrbr $certificate, string $page): RedirectResponse
    {
        if ($request->user()) {
            return to_route('hub.certificates.show', [
                'order' => $certificate->order->slug,
                'page' => $page,
            ]);
        }

        return to_route('certificate.show', [
            'order' => $certificate->order->slug,
            'page' => $page,
            'signature' => $request->get('signature'),
        ]);
    }

}
