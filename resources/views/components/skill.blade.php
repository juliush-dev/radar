<div class="group rounded-md border-2 border-slate-400/40 flex flex-col gap-0 p-6 transition-all duration-300">
    <x-assessment :href="route('skills.assess', $skill)" :assessment="$userAssessment" />
    <Link href="{{ route('skills.show', $skill) }}"
        class="text-md first-letter:uppercase w-full text-sky-500 group-hover:text-sky-700 dark:text-sky-500/40 dark:hover:text-sky-400/40 transition-colors duration-300">
    <h1 class="mb-2">{{ $skill->title }}</h1>
    </Link>
    <div class="flex flex-col gap-2 text-sm mb-4">
        @if ($skill->type)
            @can('update-type')
                <x-nav-link modal href="{{ route('skills.types.edit', $skill->type) }}" class="whitespace-normal">
                    {{ $skill->type->title }}
                </x-nav-link>
            @else
                <span class="whitespace-normal">
                    {{ $skill->type->title }}
                </span>
            @endcan
        @endif
        @if ($skill->group)
            @can('update-group')
                <x-nav-link modal href="{{ route('skills.groups.edit', $skill->group) }}" class="p-0 whitespace-normal">
                    {{ $skill->group->title }}
                </x-nav-link>
            @else
                <span class="whitespace-normal">
                    {{ $skill->group->title }}
                </span>
            @endcan
        @endif
        <div class="text-sm font-mono">
            @foreach ($skill->years as $year)
                <span class="first-letter:capitalize whitespace-nowrap">{{ $year->year }}</span>
                @if (!$loop->last)
                    <span> - </span>
                @endif
            @endforeach
        </div>
        <div class="flex gap-1 items-center flex-wrap">
            @if ($skill->fields->count() > 0)
                @foreach ($skill->fields as $skillField)
                    <x-layouts.navigation-link open-as="modal" title="{{ $skillField->field->title }}" :label="$skillField->field->code"
                        resource="fields" action="show" :action-args="$skillField->field" />
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
                <section class="relative w-full flex gap-4 text-white text-xs mt-auto">
                    <x-layouts.navigation-link class="text-blue-400" resource="skills" action="edit" :action-args="$skill">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-violet-400 hover:text-violet-500 shadow
                                    hover:shadow-md transition-all duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </x-layouts.navigation-link>
                    <x-layouts.navigation-link class="text-red-400" resource="skills" action="destroy" :action-args="$skill">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-red-500 hover:text-red-600 shadow
                                hover:shadow-md transition-all duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </x-layouts.navigation-link>
                </section>
            @endcanany
        @endauth
    @endif
</div>
