<x-layouts.app active-page="Fields"
    icon="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z">
    <div class="h-full overflow-y-auto pb-8">
        <x-fields-filter :years="$rq->years()" />
        <div class="space-y-4 columns-1 lg:columns-3 w-full mb-4 gap-4 px-6 lg:px-10">
            @foreach ($fields as $field)
                <x-field :field="$field" />
            @endforeach
            @if ($filterIsSet && $fields->count() == 0)
                <p class="text-xl mb-4 dark:text-white">No field matches the filter</p>
            @endif
        </div>
        @can('create-field')
            <div class="px-6 lg:px-10 ">
                <Link href="{{ Auth::check() ? route('fields.create') : '#login-required' }}"
                    class="text-sky-400 hover:text-sky-500">
                Create new field
                </Link>
            </div>
        @endcan
    </div>
</x-layouts.app>
