<x-layouts.app>
    <div class="absolute bottom-0 right-0 p-8">
        <x-splade-dropdown>
            <x-slot:trigger>
                <x-splade-button>Add a new contribution</x-splade-button>
            </x-slot:trigger>
            <div
                class="whitespace-nowrap py-5 px-5 rounded-sm bg-slate-900/95 shadow-sm shadow-teal-300 flex flex-col gap-2 w-64">
                <x-nav-link slideover :href="route('skill.create')" type="call-to-action">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 my-auto ">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                    </svg>

                    <span class="underline underline-offset-4">new
                        skill</span>
                </x-nav-link>

                {{-- Teacher --}}
                <x-nav-link slideover :href="route('teacher.create')" type="call-to-action">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 my-auto ">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>

                    <span class="underline underline-offset-4">new teacher</span>
                </x-nav-link>
                {{-- End Teacher --}}
                @if ($publicApprovedTeacherPublicAvailable || $contributedTeachers->for()->count() > 0)
                    <x-nav-link slideover :href="route('subject.create')" type="call-to-action">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 my-auto ">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                        </svg>
                        <span class="underline underline-offset-4">new subject</span>
                    </x-nav-link>
                @endif
                @if (
                    ($publicApprovedSkillAvailable && $publicApprovedTeacherAvailable && $publicApprovedSubjectAvailable) ||
                        ($contributedSkills->for()->count() > 0 &&
                            $contributedTeachers->for()->count() > 0 &&
                            $contributedSubjects->for()->count() > 0))
                    <x-nav-link slideover :href="route('knowledge.create')" type="call-to-action">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 my-auto ">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                        </svg>

                        <span class="underline underline-offset-4">new Knowledge</span>
                    </x-nav-link>
                @endif
                @if ($publicApprovedKnowledgeAvailable || $contributedKnowledge->for()->count() > 0)
                    <x-nav-link slideover :href="route('learning-material.create')" type="call-to-action">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="inline w-6 h-6">
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
    <x-layouts.contributions contribution="teachers" resouce="teacher" :table="$contributedTeachers" />
</x-layouts.app>
