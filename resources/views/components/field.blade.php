<div
    class="overflow-hidden group break-inside-avoid w-full border border-pink-300 text-white shadow shadow-pink-400/80 dark:shadow-pink-400/50 hover:shadow-md hover:shadow-pink-400/60  flex flex-col gap-0 p-6 transition-all duration-300">
    <Link href="{{ route('fields.show', $field) }}"
        class="text-md first-letter:uppercase w-full text-pink-500 group-hover:text-pink-700 dark:text-pink-300 dark:group-hover:text-pink-400 transition-colors duration-300">
    <h1 class="mb-2">{{ $field->title }}</h1>
    </Link>
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
            <section class="relative w-full flex gap-4 text-white">
                <x-layouts.navigation-link open-as="modal" class="text-blue-400" label="edit" resource="fields"
                    action="edit" :action-args="$field" />
                <x-layouts.navigation-link class="text-red-400" label="delete" resource="fields" action="destroy"
                    :action-args="$field" />
            </section>
        @endauth
    @endif
</div>
