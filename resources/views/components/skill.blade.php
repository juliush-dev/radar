<div
    class="group break-inside-avoid w-full text-white shadow-sm shadow-sky-400/50 hover:shadow-md hover:shadow-sky-400/60  flex flex-col gap-0 p-6 transition-all duration-300">
    <Link href="{{ route('skills.show', $skill) }}"
        class="text-md first-letter:uppercase w-full text-sky-300 group-hover:text-sky-400 transition-colors duration-300">
    <h1 class="mb-2">{{ $skill->title }}</h1>
    </Link>
    <p class="font-normal text-sm mb-4">
        @if (!empty($skill->group))
            <Link modal href="{{ route('groups.edit', $skill->group) }}" class="text-teal-300">
            {{ $skill->group->title }}
            </Link>
        @endif
        @if ($skill->years->count() > 0)
            @foreach ($skill->years as $year)
                @if ($loop->first)
                    <span> / </span>
                @endif
                <span class="first-letter:capitalize whitespace-nowrap text-slate-300">{{ $year->year }}</span>
                @if (!$loop->last)
                    <span> - </span>
                @endif
            @endforeach
        @endif
        @if ($skill->fields->count() > 0)
            @foreach ($skill->fields as $skillField)
                @if ($loop->first)
                    <span> / </span>
                @endif
                <Link href="{{ route('fields.show', $skillField->field) }}" class="uppercase  text-sky-300">
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
            <section class="relative w-full flex gap-4 text-white text-xs">
                <x-layouts.navigation-link class="text-blue-400" label="edit" resource="skills" action="edit"
                    :action-args="$skill" />
                <x-layouts.navigation-link class="text-red-400" label="delete" resource="skills" action="destroy"
                    :action-args="$skill" />
            </section>
        @endauth
    @endif
</div>
