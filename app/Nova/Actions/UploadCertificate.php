<?php

namespace App\Nova\Actions;

use App\Models\Order;
use App\Notifications\AttachmentUploaded;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

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
    public function handle(ActionFields $fields, Collection $models)
    {
        $order = Order::where('slug', $fields->order_slug)->first();
        if (!$order) {
            return Action::danger('Order not found!');
        }

        $path = 'production/'.$fields->order_slug.'/'.$fields->type.'/'.$fields->attachment->getClientOriginalName();
        $success = Storage::disk('digitalocean')->put($path, $fields->attachment->get());

        if (!$success) {
            return Action::danger('Attachment could not be uploaded!');
        }

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

        $order->customer->notify(
            new AttachmentUploaded($order, $order->customer->name, $path, $fields->attachment->getClientOriginalName())
        );

        return Action::message('Attachment uploaded!');
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
            Text::make('Order Slug'),
            Select::make('Type')->options([
                'certificate' => 'Certificate',
                'guide' => 'Guide',
            ]),
            Boolean::make('Publish'),
            File::make('Attachment'),
        ];
    }
}
