<div
    class="group border border-sky-300 text-white shadow shadow-sky-400/80 dark:shadow-sky-400/50 hover:shadow-md hover:shadow-sky-400/60  flex flex-col gap-0 p-6 transition-all duration-300">
    <x-assessment :href="route('skills.assess', $skill)" :assessment="$userAssessment" />
    <Link href="{{ route('skills.show', $skill) }}"
        class="text-md first-letter:uppercase w-full text-sky-500 group-hover:text-sky-700 dark:text-sky-300 dark:group-hover:text-sky-400 transition-colors duration-300">
    <h1 class="mb-2">{{ $skill->title }}</h1>
    </Link>
    <div class="flex flex-col gap-2 text-sm mb-4 text-slate-500 dark:text-slate-300">
        @if ($skill->type)
            @can('update-type')
                <x-nav-link modal href="{{ route('skills.types.edit', $skill->type) }}"
                    class="dark:text-teal-500 text-teal-700 whitespace-normal">
                    {{ $skill->type->title }}
                </x-nav-link>
            @else
                <span class="dark:text-slate-400 text-slate-500 whitespace-normal">
                    {{ $skill->type->title }}
                </span>
            @endcan
        @endif
        @if ($skill->group)
            @can('update-group')
                <x-nav-link modal href="{{ route('skills.groups.edit', $skill->group) }}"
                    class="dark:text-teal-500 text-teal-700 whitespace-normal">
                    {{ $skill->group->title }}
                </x-nav-link>
            @else
                <span class="dark:text-slate-400 text-slate-500 whitespace-normal">
                    {{ $skill->group->title }}
                </span>
            @endcan
        @endif
        <div class="text-sm font-mono">
            @foreach ($skill->years as $year)
                <span
                    class="first-letter:capitalize whitespace-nowrap dark:text-slate-300 text-slate-500">{{ $year->year }}</span>
                @if (!$loop->last)
                    <span> - </span>
                @endif
            @endforeach
        </div>
        <div class="flex gap-1 items-center">
            @if ($skill->fields->count() > 0)
                @foreach ($skill->fields as $skillField)
                    <x-layouts.navigation-link open-as="modal" class="dark:text-sky-300 text-sky-500"
                        title="{{ $skillField->field->title }}" :label="$skillField->field->code" resource="fields" action="show"
                        :action-args="$skillField->field" />
                    @if (!$loop->last)
                        -
                    @endif
                @endforeach
            @endif
        </div>

    </div>
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
