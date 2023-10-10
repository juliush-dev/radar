<x-layouts.app :active-page="'Skill / ' . $skill->title"
    icon="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5">
    <main class="h-full overflow-y-auto dark:text-white text-slate-600 p-6 lg:px-80" @preserveScroll('skill')>
        <x-assessment :href="route('skills.assess', $skill)" :assessment="$userAssessment" />
        <h1 class="first-letter:uppercase whitespace-normal text-xl mb-4 dark:text-slate-100">
            {{ $skill->title }}
        </h1>
        <div class="text-sm flex items-center mb-4 gap-2 flex-wrap">
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
            <div class="grow flex md:justify-end gap-6">
                @can('create-skill')
                    <Link href="{{ Auth::check() ? route('skills.create') : '#login-required' }}"
                        class="text-sky-400 hover:text-sky-500">
                    Create new skill
                    </Link>
                @endcan
            </div>
        </div>
        <hr class="mb-8">
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
        <h2 class="text-2xl mb-4">Topics you can learn to gain this skill</h2>
        <div class="columns-1 space-y-6 w-full mb-10">
            @foreach ($skill->topics as $topicSkill)
                <x-topic :topic="$topicSkill->topic" />
            @endforeach
        </div>
        @auth
            @canany(['update-skill', 'delete-skill'])
                <section class="relative w-full flex gap-4 text-white">
                    <x-layouts.navigation-link class="text-blue-400" label="edit" resource="skills" action="edit"
                        :action-args="$skill" />
                    <x-layouts.navigation-link class="text-red-400" label="delete" resource="skills" action="destroy"
                        :action-args="$skill" />
                </section>
            @endcanany
        @endauth
    </main>
</x-layouts.app>
