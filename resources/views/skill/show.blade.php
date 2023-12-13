<x-layouts.app :active-page="'Skill / ' . $skill->title"
    icon="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5">
    <main class="pt-6">
        <x-assessment :href="route('skills.assess', $skill)" :assessment="$userAssessment" />
        <h1 class="first-letter:uppercase whitespace-normal text-xl mb-4 dark:text-slate-100">
            {{ $skill->title }}
        </h1>
        <div class="text-sm flex items-center mb-2 gap-2 flex-wrap">
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
            <div class="grow flex md:justify-end items-center gap-6">
                @can('create-skill')
                    <Link href="{{ Auth::check() ? route('skills.create') : '#login-required' }}"
                        class="text-sky-400 hover:text-sky-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    </Link>
                @endcan
                @auth
                    @canany(['update-skill', 'delete-skill'])
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
                    @endcanany
                @endauth
            </div>
        </div>
        <hr class="mb-8 border-slate-200 dark:border-slate-700">
        @if ($skill->type)
            <h2 class="text-2xl mb-4 dark:text-slate-100">
                Type
            </h2>
            <p class="mb-8 text-md">
                @can('update-type')
                    <x-nav-link modal href="{{ route('skills.types.edit', $skill->type) }}"
                        class="dark:text-teal-300 text-teal-500 whitespace-normal">
                        {{ $skill->type->title }}
                    </x-nav-link>
                @else
                    <span class="dark:text-slate-300 text-slate-600 whitespace-normal">
                        {{ $skill->type->title }}
                    </span>
                @endcan
            </p>
        @endif
        @if ($skill->group)
            <h2 class="text-2xl mb-4 dark:text-slate-100">
                Group
            </h2>
            <p class="mb-8 text-md">
                @can('update-group')
                    <x-nav-link modal href="{{ route('skills.groups.edit', $skill->group) }}"
                        class="dark:text-teal-300 text-teal-500 whitespace-normal">
                        {{ $skill->group->title }}
                    </x-nav-link>
                @else
                    <span class="dark:text-slate-300 text-slate-600 whitespace-normal">
                        {{ $skill->group->title }}
                    </span>
                @endcan
            </p>
        @endif
        <h2 class="text-2xl mb-4 dark:text-slate-100">
            Fields
        </h2>
        <div class="mb-8 columns-1 space-y-6 w-full">
            @foreach ($skill->fields as $skillField)
                <x-field :field="$skillField->field" />
            @endforeach
        </div>
        <div class="@if (Agent::isAndroidOs() || Agent::isEdge()) mb-36 @endif"></div>
    </main>
</x-layouts.app>
