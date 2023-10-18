<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class DestroyAttachment
{

    use asAction;

    public function handle(
        Attachment $attachment
    ): void {
        Storage::delete($attachment->path);

        $attachment->delete();
    }


}
