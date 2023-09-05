<x-layouts.app>
    <div class="relative flex flex-col gap-8 h-full bg-slate-900/60 p-8 rounded-md shadow-2xl">
        <div class="flex flex-col gap-8 h-full">
            <h1 class="text-3xl">Your contributions</h1>
            <div class="absolute bottom-0 right-0 p-8">
                <x-splade-dropdown>
                    <x-slot:trigger>
                        <x-splade-button>Add a new contribution</x-splade-button>
                    </x-slot:trigger>
                    <div
                        class="whitespace-nowrap py-5 px-5 rounded-sm bg-slate-900/95 shadow-sm shadow-teal-300 flex flex-col gap-2 w-64">
                        <x-nav-link slideover :href="route('skill.create')" type="call-to-action">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                            </svg>

                            <span class="underline underline-offset-4">new
                                skill</span>
                        </x-nav-link>
                        @if ($publicApprovedSkillAvailable || $contributedSkills->count() > 0)
                            <x-nav-link :href="route('skill.create')" type="call-to-action">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                                </svg>

                                <span class="underline underline-offset-4">new Knowledge</span>
                            </x-nav-link>
                        @endif

                        @if ($publicApprovedKnowledgeAvailable || $contributedKnowledge->count() > 0)
                            <x-nav-link :href="route('skill.create')" type="call-to-action">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="inline w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                <span class="underline underline-offset-4">new subject</span>
                            </x-nav-link>
                            <x-nav-link :href="route('skill.create')" type="call-to-action">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="inline w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                <span class="underline underline-offset-4" :class="toggled ? 'font-xl'"> new learning
                                    material</span>
                            </x-nav-link>
                        @endif
                    </div>
                </x-splade-dropdown>
            </div>
            @if (
                $contributedSkills->count() == 0 &&
                    $contributedKnowledge->count() == 0 &&
                    $contributedLearningMaterials->count() == 0)
                <div class="h-full flex items.center justify-center">
                    <div
                        class="my-auto w-1/2 text-xl flex gap-5 items.center p-5 border border-slate-500/60 rounded-sm shadow shadow-teal-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-11 h-11 my-auto text-teal-200">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>

                        <p>
                            No Contributions. <span class="underline underline-offset-4">Use the action at the
                                bottom-right of the page</span> to start
                            contributing to
                            the radar </p>
                    </div>
                </div>
            @endif
            <div>
                @if ($contributedSkills->count() > 0)
                    <h2 class="text-2xl mb-5">Skills</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($contributedSkills as $skill)
                            <div
                                class="flex flex-col gap-3 rounded border border-teal-900 hover:shadow hover:shadow-teal-500 hover:bg-teal-700/5  p-3 transition duration-300">
                                <h3 class="text-md flex gap-2 text-yellow-300/50 group-hover:text-teal-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                                    </svg>

                                    <span>{{ $skill->contribution->title }}</span>
                                </h3>
                                <div class="flex flex-col gap-3 py-2 px-1 text-slate-500">
                                    <div class="flex gap-2 items.center">
                                        <div class="flex gap-2 items.center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 my-auto">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                            </svg>
                                            <label class="my-auto">Knowledge group covering it:</label>
                                        </div>
                                        <div class="flex gap-2 items.center my-auto">
                                            <span
                                                class="my-auto px-2 py-1 text-xs rounded bg-teal-900/60 text-teal-600">{{ $skill->knowledge_group_covering_it }}</span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 items.center">
                                        <div class="flex gap-2 items.center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 my-auto">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                            </svg>
                                            <label class="my-auto">Years covering it:</label>
                                        </div>
                                        <div class="flex gap-2 items.center my-auto">
                                            @php
                                                $yearLevels = explode(',', $skill->years_levels_covering_it);
                                            @endphp
                                            @foreach ($yearLevels as $yearLevel)
                                                <span
                                                    class="my-auto px-2 py-1 text-xs rounded bg-teal-900/60 text-teal-600">{{ $yearLevel }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="flex gap-2 items.center">
                                        <div class="flex gap-2 items.center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-4 h-4 my-auto">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                            </svg>
                                            <label class="my-auto">Fields covered by it:</label>
                                        </div>
                                        <div class="flex gap-2 items.center my-auto">
                                            @php
                                                $fields = explode(',', $skill->fields_covered_by_it);
                                            @endphp
                                            @foreach ($fields as $field)
                                                <span
                                                    class="my-auto px-2 py-1 text-xs rounded bg-teal-900/60 text-teal-600">{{ $field }}</span>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
