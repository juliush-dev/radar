<x-layouts.app :active-page="'Checkpoint Preview / ' . $checkpoint->title"
    icon="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5">
    <div class="h-full overflow-y-auto dark:text-white text-slate-600" @preserveScroll('checkpoint')>
        <main class="p-6 lg:px-80">
            <x-splade-form :action="route('checkpoints.initiate', $checkpoint)" default="{countdown: 60}"
                class="flex whitespace-nowrap absolute bottom-0 z-20 dark:text-slate-500">
                <countdown v-slot="countdown" :form="form">
                    <input type="number" min="0" max="2" v-bind:value="countdown.getHour"
                        @input="countdown.setHour" placeholder="0"
                        class="w-12 px-0 pl-1 py-0 border-0 bg-slate-100 active:ring-0 focus:ring-0 transition-all duration-75"
                        v-bind:disabled="countdown.running"><span class="bg-slate-100 px-0.5">h</span>
                    <input type="number" min="1" max="59" v-bind:value="countdown.getMin"
                        @input="countdown.setMin" placeholder="00"
                        class="w-12 px-0 pl-1 py-0 border-0 bg-slate-200 active:ring-0 focus:ring-0 transition-all duration-75"
                        v-bind:disabled="countdown.running"><span class="bg-slate-200 px-0.5">m</span>
                    <input type="number" min="0" max="59" v-bind:value="countdown.getSec"
                        @input="countdown.setSec" placeholder="00"
                        class="w-12 px-0 pl-1 py-0 border-0 bg-slate-300 active:ring-0 focus:ring-0 transition-all duration-75"
                        v-bind:disabled="countdown.running"><span class="bg-slate-300 px-0.5">s</span>
                    <div class="flex flex-nowrap">
                        @if (Auth::check())
                            <x-splade-submit
                                class="bg-fuchsia-500 py-2 md:w-fit hover:bg-fuchsia-600 shadow-m whitespace-nowrap flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                </svg>
                                Take a test
                            </x-splade-submit>
                        @else
                            <x-nav-link href="#login-required"
                                class="bg-fuchsia-500 py-2 md:w-fit hover:bg-fuchsia-600 shadow-m whitespace-nowrap flex gap-1 items-center text-white px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                </svg>
                                Take a test
                            </x-nav-link>
                        @endif
                    </div>
                </countdown>
            </x-splade-form>
            <div class="flex mb-4 items-center flex-wrap">
                <h1 class="first-letter:uppercase text-xl dark:text-slate-100">
                    {{ $checkpoint->title }}
                </h1>
            </div>
            <x-nav-link href="{{ route('topics.show', $checkpoint->topic) }}"
                class="first-letter:uppercase text-violet-500 group-hover:text-violet-700 dark:text-violet-300 dark:group-hover:text-violet-400 hover:text-violet-500 transition-colors duration-300 mb-4">
                {{ $checkpoint->topic->title }}
            </x-nav-link>
            <div class="text-sm flex grow md:justify-end gap-6 items-center w-full">
                @can('use-dashboard')
                    <x-splade-link :href="route('dashboard.index', ['tab' => 'checkpoints'])"
                        class="w-fit flex items-center gap-2 justify-end text-violet-500 hover:text-violet-600 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                        </svg>
                    </x-splade-link>
                    @if (!$checkpoint->is_update)
                        <x-splade-form submit-on-change :action="$checkpoint->is_public
                            ? route('checkpoints.unpublish', $checkpoint)
                            : route('checkpoints.publish', $checkpoint)" method="post" :default="['is_public' => $checkpoint->is_public]"
                            class="text-violet-400 hover:text-violet-500">
                            <x-splade-checkbox inline label="Public" name="is_public" value="1"
                                class="checked:bg-fuchsia-400" />
                        </x-splade-form>
                    @endif
                @endcan
                @can('update-checkpoint', $checkpoint)
                    <x-splade-link href="{{ route('checkpoints.edit', $checkpoint) }}" class="text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 text-violet-400 hover:text-violet-500 transition-all duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </x-splade-link>
                @endcan
                @can('create-checkpoint')
                    <Link href="{{ Auth::check() ? route('checkpoints.create', $checkpoint->topic) : '#login-required' }}"
                        class="whitespace-nowrap text-fuchsia-400 hover:text-fuchsia-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    </Link>
                @endcan
                @can('delete-checkpoint', $checkpoint)
                    <x-splade-link method="delete" href="{{ route('checkpoints.destroy', $checkpoint) }}"
                        confirm="Deletion requested" confirm-text="This checkpoint will be permanently deleted?"
                        confirm-button="Yes, delete it!" cancel-button="No, keep it!" class="text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 text-red-400 hover:text-red-500
                            transition-all duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </x-splade-link>
                @endcan
                <x-volatile-sign :model="$checkpoint" />
            </div>
            <hr class="mt-2 mb-8">
            @can('see-checkpoint-update-path', $checkpoint)
                @if ($checkpoint->is_update)
                    <section class="mb-8 border border-pink-800 p-4">
                        <h2 class="text-2xl mb-4">
                            Will replace
                        </h2>
                        <x-splade-link :href="route('checkpoints.preview', $checkpoint->potentialReplacementOf)"
                            class="text-teal-600 hover:text-teal-700 dark:text-teal-400 transition-colors duration-300">
                            {{ $checkpoint->potentialReplacementOf->title }}
                        </x-splade-link>
                    </section>
                @endif
                @if ($checkpoint->potentialReplacement)
                    <section class="mb-8 border border-pink-800 p-4">
                        <h2 class="text-2xl mb-4">
                            Will be replaced by
                        </h2>
                        <x-splade-link :href="route('checkpoints.preview', $checkpoint->potentialReplacement)"
                            class=" text-teal-600 hover:text-teal-700 dark:text-teal-400 transition-colors duration-300">
                            {{ $checkpoint->potentialReplacement->title }}
                        </x-splade-link>
                    </section>
                @endif
            @endcan
            <div class="mb-8">
                <h2 class="text-2xl mb-4 dark:text-slate-100">
                    My last sessions
                </h2>
                @if (Auth::check())
                    <x-layouts.knowledge-cubes :requireBigPadding="false">
                        @forelse ($rq->checkpointsSessions(['author' => auth()->user()->id, 'checkpoint' => $checkpoint->id]) as $session)
                            <div
                                class="flex flex-col gap-6 w-fit whitespace-nowrap p-4 rounded-md shadow bg-white dark:bg-slate-700 dark:text-slate-100 first-letter:uppercase transition-colors duration-300">
                                <x-nav-link href="{{ route('sessions.review', $session) }}"
                                    class="text-violet-500 hover:text-violet-500 dark:text-violet-400 dark:hover:text-violet-300">
                                    {{ $session->created_at }}
                                </x-nav-link>
                                <div class="text-sm flex flex-col gap-2 justify-between">
                                    <p>Duration: {{ $session->countdown - $session->end_countdown }}s</p>
                                    <p>Touched {{ $session->userResults()->count() }} /
                                        {{ $total = $session->checkpoint->knowledgeAnswerSets->count() }}</p>
                                    <p>Untouched: {{ $session->untouchedKnowledge(true) }} </p>
                                    <p>Wrong: {{ $session->wrongResults(true) }}</p>
                                    <p>Correct: {{ $correct = $session->correctResults(true) }} </p>
                                    <p class="text-lg font-medium">Note: {{ floor(($correct / $total) * 100) }}% </p>
                                </div>
                                <div class="flex items-center justify-end">
                                    <x-splade-link method="delete" href="{{ route('sessions.destroy', $session) }}"
                                        confirm="Deletion requested"
                                        confirm-text="This session will be permanently deleted?"
                                        confirm-button="Yes, delete it!" cancel-button="No, keep it!"
                                        class="text-red-500 hover:text-red-600 text-sm">
                                        delete
                                    </x-splade-link>
                                </div>
                            </div>
                        @empty
                            <p class="w-full">No Session. Start a new one.</p>
                        @endforelse
                    </x-layouts.knowledge-cubes>
                @else
                    <div class="w-full flex flex-wrap gap-4">
                        <x-nav-link href="#login-required"
                            class="w-fit whitespace-nowrap p-4 rounded-md shadow bg-white first-letter:uppercase text-violet-500 hover:text-violet-600 transition-colors duration-300">
                            My last sessions
                        </x-nav-link>
                    </div>
                @endif
            </div>
            <div class="flex items-center mb-8">
                <h2 class="text-2xl dark:text-slate-100">
                    Cubes of knowledge
                </h2>
                {{-- <Link href="{{ Auth::check() ? route('checkpoints.create', $checkpoint->topic) : '#login-required' }}"
                class="whitespace-nowrap text-fuchsia-400 hover:text-fuchsia-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            </Link> --}}
            </div>
        </main>
        <x-layouts.knowledge-cubes>
            @foreach ($checkpoint->knowledgeCubes as $knowledgeCube)
                <x-checkpoint.knowledge-cube :$knowledgeCube :reviewKnowledge="null" />
            @endforeach
        </x-layouts.knowledge-cubes>
    </div>
</x-layouts.app>
