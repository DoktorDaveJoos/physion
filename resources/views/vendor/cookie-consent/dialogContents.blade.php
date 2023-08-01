{{--<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-2">--}}
{{--    <div class="max-w-7xl mx-auto px-6">--}}
{{--        <div class="p-2 rounded-lg bg-yellow-100">--}}
{{--            <div class="flex items-center justify-between flex-wrap">--}}
{{--                <div class="w-0 flex-1 items-center hidden md:inline">--}}
{{--                    <p class="ml-3 text-black cookie-consent__message">--}}
{{--                        {!! trans('cookie-consent::texts.message') !!}--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--                <div class="mt-2 flex-shrink-0 w-full sm:mt-0 sm:w-auto">--}}
{{--                    <button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-yellow-800 bg-yellow-400 hover:bg-yellow-300">--}}
{{--                        {{ trans('cookie-consent::texts.agree') }}--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="js-cookie-consent cookie-consent fixed z-20 inset-x-0 bottom-0 flex flex-col justify-end gap-x-8 gap-y-4 bg-white p-6 ring-1 ring-gray-900/10 md:flex-row md:items-center lg:px-8">
    <p class="max-w-4xl text-sm leading-6 text-gray-900">
        {!! trans('cookie-consent::texts.message') !!}
    </p>
    <div class="flex flex-none items-center gap-x-5">
        <button type="button"
                class="js-cookie-consent-agree cookie-consent__agree rounded-md bg-blue-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900">
            {{ trans('cookie-consent::texts.agree') }}
        </button>
    </div>
</div>

