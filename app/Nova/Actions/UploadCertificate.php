<?php

namespace App\Nova\Actions;

use App\Models\Order;
use App\Notifications\AttachmentUploaded;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Throwable;

class UploadCertificate extends Action
{
    use InteractsWithQueue, Queueable;


    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models): mixed
    {
        try {
            $models->each(function (Order $order) use ($fields) {
                $path = 'production/'.$order->slug.'/'.$fields->type.'/'.$fields->attachment->getClientOriginalName();
                $success = Storage::disk('digitalocean')->put($path, $fields->attachment->get());

                throw_if(!$success, new Exception('Attachment could not be uploaded!'));

                $order->attachments()->create([
                    'path' => $path,
                    'type' => $fields->type,
                    'name' => $fields->attachment->getClientOriginalName(),
                    'published' => $fields->publish,
                ]);

                if ($fields->type == 'certificate') {
                    $order->update([
                        'status' => 'shipped',
                    ]);
                }

                $order->owner->notify(
                    new AttachmentUploaded(
                        $order,
                        $order->owner->first_name,
                        $path,
                        $fields->attachment->getClientOriginalName()
                    )
                );
            });
            return Action::message('Attachment uploaded!');
        } catch (Throwable $throwable) {
            return Action::danger($throwable->getMessage());
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Select::make('Type')->options([
                'certificate' => 'Certificate',
                'guide' => 'Guide',
            ]),
            Boolean::make('Publish'),
            File::make('Attachment'),
        ];
    }
}
