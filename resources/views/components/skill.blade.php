<div
    class="group break-inside-avoid w-full border border-sky-300 text-white shadow shadow-sky-400/80 dark:shadow-sky-400/50 hover:shadow-md hover:shadow-sky-400/60  flex flex-col gap-0 p-6 transition-all duration-300">
    <Link href="{{ route('skills.show', $skill) }}"
        class="text-md first-letter:uppercase w-full text-sky-500 group-hover:text-sky-700 dark:text-sky-300 dark:group-hover:text-sky-400 transition-colors duration-300">
    <h1 class="mb-2">{{ $skill->title }}</h1>
    </Link>
    <p class="font-normal text-sm mb-4 text-slate-500 dark:text-slate-300">
        <Link modal href="{{ route('groups.edit', $skill->group) }}" class="dark:text-teal-300 text-teal-500">
        {{ $skill->group->title }}
        </Link>
        @foreach ($skill->years as $year)
            @if ($loop->first)
                <span> / </span>
            @endif
            <span
                class="first-letter:capitalize whitespace-nowrap dark:text-slate-300 text-slate-500">{{ $year->year }}</span>
            @if (!$loop->last)
                <span> - </span>
            @endif
        @endforeach
        @if ($skill->fields->count() > 0)
            @foreach ($skill->fields as $skillField)
                @if ($loop->first)
                    <span> / </span>
                @endif
                <Link href="{{ route('fields.show', $skillField->field) }}"
                    class="uppercase dark:text-sky-300 text-sky-500">
                {{ $skillField->field->code }}
                </Link>
                @if (!$loop->last)
                    -
                @endif
            @endforeach
        @endif
    </p>
    @if (Route::is('skills.index'))
        @auth
            @canany(['update-skill', 'delete-skill'])
                <section class="relative w-full flex gap-4 text-white text-xs">
                    <x-layouts.navigation-link class="text-blue-400" label="edit" resource="skills" action="edit"
                        :action-args="$skill" />
                    <x-layouts.navigation-link class="text-red-400" label="delete" resource="skills" action="destroy"
                        :action-args="$skill" />
                </section>
            @endcanany
        @endauth
    @endif
</div>
