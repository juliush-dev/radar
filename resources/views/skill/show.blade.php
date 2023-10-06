<x-layouts.app :active-page="$skill->title" icon="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z">
    <main class="h-full overflow-y-auto text-white py-6 px-80">
        <h1 class="first-letter:uppercase text-xl mb-4 text-slate-300">
            {{ $skill->title }}
        </h1>
        <div class="text-sm flex items-center mb-4 gap-2">
            @if ($skill->years->count() > 0)
                <p class="font-light">
                    @foreach ($skill->years as $year)
                        <span class="first-letter:capitalize">{{ $year->year }}</span>
                        @if (!$loop->last)
                            <span class="mx-2">-</span>
                        @endif
                    @endforeach
                </p>
            @endif
        </div>
        <hr class="mb-8">
        @if ($skill->group)
            <h2 class="text-2xl mb-4 text-slate-300">
                Group
            </h2>
            <p class="mb-8 text-lg">
                {{ $skill->group->title }}
            </p>
        @endif
        <h2 class="text-2xl mb-4 text-slate-300">
            Fields
        </h2>
        <div class="mb-10 columns-1 space-y-6 w-full">
            @foreach ($skill->fields as $skillField)
                <x-field :field="$skillField->field" />
            @endforeach
        </div>
        @auth
            <section class="relative w-full flex gap-4 text-white">
                <x-layouts.navigation-link class="text-blue-400" label="edit" resource="skills" action="edit"
                    :action-args="$skill" />
                <x-layouts.navigation-link class="text-red-400" label="delete" resource="skills" action="destroy"
                    :action-args="$skill" />
            </section>
        @endauth
    </main>
</x-layouts.app>
