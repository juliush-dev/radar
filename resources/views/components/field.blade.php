<div
    class="overflow-hidden relative group rounded-md border-2 border-pink-300 text-white shadow shadow-pink-400/80 dark:shadow-pink-400/50 hover:shadow-md hover:shadow-pink-400/60  flex flex-col gap-0 p-6 transition-all duration-300">
    <x-nav-link href="{{ route('fields.show', $field) }}"
        class="whitespace-break-spaces text-md first-letter:uppercase w-full text-pink-500 group-hover:text-pink-700 dark:text-pink-300 dark:group-hover:text-pink-400 transition-colors duration-300">
        <h1 class="mb-2">{{ $field->title }}</h1>
    </x-nav-link>
    <div class="font-normal text-sm mb-4 text-slate-500 dark:text-slate-300 flex items-center gap-3 flex-wrap">
        <span class="capitalize whitespace-nowrap dark:text-slate-300 text-slate-500">
            {{ $field->code }}
        </span>
        <div class="flex items-center gap-0 text-slate-400">
            @foreach ($field->years as $year)
                <span
                    class="first-letter:capitalize whitespace-nowrap dark:text-slate-300 text-slate-500">{{ $year->year }}</span>
                @if (!$loop->last)
                    <span class="mx-1">-</span>
                @endif
            @endforeach
        </div>
    </div>
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
                <section class="w-full flex gap-4 text-white mt-auto">
                    <x-layouts.navigation-link class="text-blue-400 hover:text-blue-600" resource="fields" action="edit"
                        :action-args="$field">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-violet-400 hover:text-violet-500 shadow
                                    hover:shadow-md transition-all duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </x-layouts.navigation-link>
                    <x-layouts.navigation-link class="text-red-400 hover:text-red-600" resource="fields" action="destroy"
                        :action-args="$field">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-red-500 hover:text-red-600 shadow
                                hover:shadow-md transition-all duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </x-layouts.navigation-link>
                    <x-layouts.navigation-link open-as="modal" class="text-blue-400 hover:text-blue-600 ml-auto"
                        title="Open as modal" resource="fields" action="show" :action-args="$field"
                        icon="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                </section>
            @endcanany
        @endauth
    @endif
</div>
