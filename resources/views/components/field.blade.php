<div
    class="overflow-hidden relative group border border-pink-300 text-white shadow shadow-pink-400/80 dark:shadow-pink-400/50 hover:shadow-md hover:shadow-pink-400/60  flex flex-col gap-0 p-6 transition-all duration-300">
    <x-nav-link href="{{ route('fields.show', $field) }}"
        class="whitespace-break-spaces text-md first-letter:uppercase w-full text-pink-500 group-hover:text-pink-700 dark:text-pink-300 dark:group-hover:text-pink-400 transition-colors duration-300">
        <h1 class="mb-2">{{ $field->title }}</h1>
    </x-nav-link>
    <p class="font-normal text-sm mb-4 text-slate-500 dark:text-slate-300">
        <span class="capitalize whitespace-nowrap dark:text-slate-300 text-slate-500">
            {{ $field->code }}
        </span>
        @foreach ($field->years as $year)
            @if ($loop->first)
                <span class="mx-1">/</span>
            @endif
            <span
                class="first-letter:capitalize whitespace-nowrap dark:text-slate-300 text-slate-500">{{ $year->year }}</span>
            @if (!$loop->last)
                <span class="mx-1">-</span>
            @endif
        @endforeach
    </p>
    @if (!Route::is('fields.index') && $field->details)
        <x-splade-toggle>
            <x-splade-transition show="toggled" animation="slide-left" enter="transition-opacity duration-300"
                leave="transition-opacity duration-1000" class="mb-4 font-sans dark:text-slate-300 text-slate-500">
                {!! $field->details !!}
            </x-splade-transition>
            <button @click="toggle" v-text="toggled ? 'Less' : 'More...'"
                class="w-fit px-4 mb-4 text-md  transition-all duration-300"
                v-bind:class="toggled ? 'bg-violet-500 hover:bg-violet-600' : 'bg-teal-500 hover:bg-teal-600' "></button>
        </x-splade-toggle>
    @endif
    @if (Route::is('fields.index'))
        @auth
            @canany(['update-field', 'delete-field'])
                <section class="w-full flex gap-4 text-white">
                    <x-layouts.navigation-link class="text-blue-400 hover:text-blue-600" label="edit" resource="fields"
                        action="edit" :action-args="$field" />
                    <x-layouts.navigation-link class="text-red-400 hover:text-red-600" label="delete" resource="fields"
                        action="destroy" :action-args="$field" />
                    <x-layouts.navigation-link open-as="modal" class="text-blue-400 hover:text-blue-600 ml-auto"
                        title="Open as modal" resource="fields" action="show" :action-args="$field"
                        icon="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                </section>
            @endcanany
        @endauth
    @endif
</div>
