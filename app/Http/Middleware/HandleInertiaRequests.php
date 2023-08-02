<?php

namespace App\Http\Middleware;

use App\Models\Resource;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        // @todo find a better way to deal with this
        $resources = Resource::whereHas('roles', function ($query) {
            $query->whereHas('users', function ($query) {
                $query->where('user_has_roles.user_id', auth()->id());
            });
        })->get();

        return array_merge(parent::share($request), [
            'resources' => $resources,
        ]);
    }
}
