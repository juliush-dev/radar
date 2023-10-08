<x-layouts.app :active-page="$field->title"
    icon="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z">
    <main class="h-full overflow-y-auto dark:text-white text-slate-600 p-6 lg:px-80">
        <h1 class="first-letter:uppercase text-xl mb-4 dark:text-slate-100">
            {{ $field->title }}
        </h1>
        <div class="text-sm flex items-center mb-4 gap-2 flex-wrap lg:flex-nowrap">
            {{ $field->code }} /
            @if ($field->years->count() > 0)
                <p class="font-light">
                    @foreach ($field->years as $year)
                        <span class="first-letter:capitalize">{{ $year->year }}</span>
                        @if (!$loop->last)
                            <span class="mx-2">-</span>
                        @endif
                    @endforeach
                </p>
            @endif
        </div>
        <hr class="mb-8">
        <h2 class="text-2xl mb-4">
            More
        </h2>
        <div class="mb-10 font-sans dark:text-slate-300 text-slate-400">
            @if ($field->details)
                {!! $field->details !!}
            @else
                <span class="text-slate-300 dark:text-slate-400">Nothing added</span>
            @endif
        </div>
        @auth
            @canany(['update-field', 'delete-field'])
                <section class="relative w-full flex gap-4 text-white">
                    <x-layouts.navigation-link class="text-blue-400" label="edit" resource="fields" action="edit"
                        :action-args="$field" />
                    <x-layouts.navigation-link class="text-red-400" label="delete" resource="fields" action="destroy"
                        :action-args="$field" />
                </section>
            @endcanany
        @endauth
    </main>
</x-layouts.app>
