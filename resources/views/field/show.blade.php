<x-layouts.app :active-page="'Field / ' . $field->title"
    icon="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z">
    <main class="h-full pt-4 overflow-y-auto dark:text-white text-slate-600 px-6 lg:px-80" @preserveScroll('field')>
        <x-splade-modal class="p-6 border border-slate-400 h-[530px] my-auto rounded-none overflow-y-auto">
            <h1 class="first-letter:uppercase text-xl mb-4 dark:text-slate-100">
                {{ $field->title }}
            </h1>
            <div class="text-sm flex items-center mb-2 gap-2 flex-wrap">
                {{ $field->code }} /
                @if ($field->years->count() > 0)
                    <p class="font-light">
                        @foreach ($field->years as $year)
                            <span class="first-letter:capitalize">{{ $year->year }}</span>
                            @if (!$loop->last)
                                <span class="mx-2">-</span>
                            @endif
                        @endforeach
                    </p>
                @endif
                <div class="grow flex md:justify-end items-center gap-6">
                    @can('create-field')
                        <Link href="{{ Auth::check() ? route('fields.create') : '#login-required' }}"
                            class="text-sky-400 hover:text-sky-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        </Link>
                    @endcan
                    @auth
                        @canany(['update-field', 'delete-field'])
                            <x-layouts.navigation-link class="text-blue-400" resource="fields" action="edit" :action-args="$field">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-5 h-5 text-violet-400 hover:text-violet-500 shadow
                                    hover:shadow-md transition-all duration-300">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </x-layouts.navigation-link>
                            <x-layouts.navigation-link class="text-red-400" resource="fields" action="destroy"
                                :action-args="$field">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6 text-red-500 hover:text-red-600 shadow
                                hover:shadow-md transition-all duration-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </x-layouts.navigation-link>
                        @endcanany
                    @endauth
                </div>
            </div>
            <hr class="mb-8 border-slate-200 dark:border-slate-700">
            <h2 class="text-2xl mb-4">
                In-depth
            </h2>
            <div
                class="min-w-full mb-8 font-sans text-slate-500 dark:text-slate-300 prose prose-strong:dark:text-white">
                @if ($field->details)
                    {!! $field->details !!}
                @else
                    <span class="text-slate-500 dark:text-slate-300">Nothing added</span>
                @endif
            </div>
            <h2 class="text-2xl mb-4">Skills in this area of expertise</h2>
            <div class="mb-8 columns-1 space-y-6 w-full">
                @foreach ($field->skills as $skill)
                    <x-skill :skill="$skill->skill" :user-assessment="$rq->userSkillAssessment($skill->skill)" />
                @endforeach
            </div>
        </x-splade-modal>
    </main>
</x-layouts.app>
