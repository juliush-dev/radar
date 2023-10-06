<div
    class="overflow-hidden group break-inside-avoid w-full text-white shadow-sm shadow-indigo-400/50 hover:shadow-md hover:shadow-indigo-400/60  flex flex-col gap-0 p-6 transition-all duration-300">
    <Link href="{{ route('fields.show', $field) }}"
        class="text-md first-letter:uppercase w-full text-indigo-300 group-hover:text-indigo-400 transition-colors duration-300">
    <h1 class="mb-2">{{ $field->title }}</h1>
    </Link>
    <p class="font-normal text-sm mb-4">
        <span class="capitalize whitespace-nowrap text-slate-300">
            {{ $field->code }}
        </span>
        @if ($field->years->count() > 0)
            @foreach ($field->years as $year)
                @if ($loop->first)
                    <span class="mx-1">/</span>
                @endif
                <span class="first-letter:capitalize whitespace-nowrap text-slate-300">{{ $year->year }}</span>
                @if (!$loop->last)
                    <span class="mx-1">-</span>
                @endif
            @endforeach
        @endif
    </p>
    @if (!Route::is('fields.index'))
        <x-splade-toggle>
            <x-splade-transition show="toggled" animation="slide-left" enter="transition-opacity duration-300"
                leave="transition-opacity duration-1000" class="mb-4 font-sans text-slate-400">
                @if ($field->details)
                    {!! $field->details !!}
                @else
                    None
                @endif
            </x-splade-transition>
            <button @click="toggle" v-text="toggled ? '🙈 Less' : '🙊 Details'"
                class="w-fit px-4 mb-4 text-md  transition-all duration-300"
                v-bind:class="toggled ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-teal-500 hover:bg-teal-600' "></button>
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
