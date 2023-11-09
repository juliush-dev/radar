<x-splade-data store="session"
    default="{
        expandedQuiz: null,
        pauseCountdown: false,
        started: true,
        over: false
    }" />
<x-layouts.app :active-page="'Test/ ' . $session->checkpoint->title"
    icon="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5">
    <main class="h-full overflow-y-auto dark:text-white text-slate-600 p-6 lg:px-80" @preserveScroll('checkpoint')>
        <x-splade-form method="patch" :action="route('sessions.stop', $session)" :default="['countdown' => $session->countdown, 'stopped' => false]" submit-on-change="stopped"
            class="flex whitespace-nowrap absolute bottom-0 z-20 dark:text-slate-800 bg-gradient-to-r from-yellow-300 to-yellow-400">
            <countdown v-slot="countdown" :form="form" :session="session" :run="true">
                <input type="number" v-bind:value="countdown.getHour" @input="countdown.setHour" placeholder="0"
                    class="w-12 px-0 pl-1 py-0 border-0 bg-transparent active:ring-0 focus:ring-0 transition-all duration-75"
                    v-bind:disabled="countdown.running"><span class="px-0.5">h</span>
                <input type="number" v-bind:value="countdown.getMin" @input="countdown.setMin" placeholder="00"
                    class="w-12 px-0 pl-1 py-0 border-0 bg-transparent active:ring-0 focus:ring-0 transition-all duration-75"
                    v-bind:disabled="countdown.running"><span class="px-0.5">m</span>
                <input type="number" v-bind:value="countdown.getSec" @input="countdown.setSec" placeholder="00"
                    class="w-12 px-0 pl-1 py-0 border-0 bg-transparent active:ring-0 focus:ring-0 transition-all duration-75"
                    v-bind:disabled="countdown.running"><span class="px-0.5">s</span>
                <div class="flex flex-nowrap">
                    <button
                        class="bg-red-500 py-2 md:w-fit px-2 text-white hover:bg-red-600 shadow-m whitespace-nowrap flex gap-1 items-center"
                        @click.prevent="countdown.stop()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z" />
                        </svg>
                        Stop
                    </button>
                </div>
            </countdown>
        </x-splade-form>
        <div class="flex mb-4 items-center flex-wrap">
            <h1 class="first-letter:uppercase text-xl dark:text-slate-100">
                {{ $session->checkpoint->title }}
            </h1>
            @can('use-dashboard')
                <div class="flex justify-end items-center grow gap-6">
                    @if (!$session->checkpoint->is_update)
                        <x-splade-form submit-on-change :action="$session->checkpoint->is_public
                            ? route('checkpoints.unpublish', $session->checkpoint)
                            : route('checkpoints.publish', $session->checkpoint)" method="post" :default="['is_public' => $session->checkpoint->is_public]"
                            class="text-violet-400 hover:text-violet-500">
                            <x-splade-checkbox inline label="Public" name="is_public" value="1"
                                class="checked:bg-fuchsia-400" />
                        </x-splade-form>
                    @endif
                    <x-splade-link :href="route('dashboard.index', ['tab' => 'checkpoints'])"
                        class="w-fit flex items-center gap-2 justify-end text-violet-500 hover:text-violet-600 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                        </svg>
                    </x-splade-link>
                </div>
            @endcan
        </div>
        <div class="text-sm flex items-center mb-4 gap-2 flex-wrap">
            <x-nav-link href="{{ route('topics.show', $session->checkpoint->topic) }}"
                class="first-letter:uppercase text-violet-500 group-hover:text-violet-700 dark:text-violet-300 dark:group-hover:text-violet-400 hover:text-violet-500 transition-colors duration-300">
                {{ $session->checkpoint->topic->title }}
            </x-nav-link>
            <div class="flex md:justify-end grow gap-6 items-center">
                @can('create-checkpoint')
                    <Link
                        href="{{ Auth::check() ? route('checkpoints.create', $session->checkpoint->topic) : '#login-required' }}"
                        class="whitespace-nowrap text-fuchsia-400 hover:text-fuchsia-500">
                    Add new checkpoint
                    </Link>
                @endcan
                @if ($session->checkpoint->is_update || $session->checkpoint->potentialReplacement)
                    <span
                        class="px-2 bg-pink-600 w-fit font-mono text-sm text-white dark:text-slate-200  my-auto grow-0">Volatile
                        @if ($session->checkpoint->is_update)
                            <span
                                class="px-2 bg-amber-300 font-mono text-slate-700 text-sm shadow shadow-amber-400">Update</span>
                        @endif
                    </span>
                @endif
            </div>
        </div>
        <hr class="mb-8">
        <h2 class="text-2xl mb-4 dark:text-slate-100">
            Quizzes
        </h2>
        <checkpoint-session v-slot="checkpointSession">
            @foreach ($session->checkpoint->questionAnswerSets as $quiz)
                <x-splade-toggle>
                    <x-splade-data default="{answer: null, answerRevealed: false, userFoundAnswer: false}">
                        <div class="overflow-hidden shadow-md rounded border mb-10 p-8 bg-gradient-to-r transition-colors"
                            v-bind:class="{'from-red-400 to-red-500 text-white': session.started && data.answerRevealed && !data.userFoundAnswer ,  'from-slate-100 to-slate-300 text-slate-700': !session.started || !data.answerRevealed,  'from-green-400 to-green-500 text-white': session.started && data.userFoundAnswer}">
                            <p class="text-xl mb-2">{{ $quiz->title }}</p>
                            <hr class="mb-4 border-white">
                            <div>
                                <p class="text-lg font-medium mb-2">
                                    @if ($quiz->is_cloze)
                                        {!! $quiz->question !!}
                                    @else
                                        {{ $quiz->question }}
                                    @endif
                                </p>
                            </div>
                            <hr class="mb-4 border-white">
                            <div class="w-full overflow-hidden">
                                <x-splade-transition show="toggled" animation="slide-left" class="mt-4">
                                    @if ($quiz->is_cloze)
                                        {{-- <p class="text-lg mb-2" v-html="data.answer">
                                        </p> --}}
                                        <div class="text-lg mb-2"
                                            v-html="`{{ \App\View\Components\Checkpoint::wrapTokensInText($quiz->answer) }}`">
                                        </div>
                                    @else
                                        <p class="text-lg mb-2">
                                            {{ $quiz->answer }}
                                        </p>
                                    @endif
                                    {!! $quiz->answer_in_place_explanation !!}
                                </x-splade-transition>
                            </div>
                            <div class="flex gap-4 mt-4 flex-nowrap">
                                <div v-show="session.started && !session.over && toggled && !data.userFoundAnswer">
                                    <x-splade-form stay :action="route('sessions.results.correct', [$session, $quiz])">
                                        <button type="submit" class="transition-opacity duration-300"
                                            @click="data.userFoundAnswer = true; session.pauseCountdown = false; session.expandedQuiz = null;">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </x-splade-form>
                                </div>
                                <div v-show="session.started && !session.over && toggled && data.userFoundAnswer">
                                    <x-splade-form stay :action="route('sessions.results.wrong', [$session, $quiz])">
                                        <button type="submit" class="transition-opacity duration-300"
                                            @click="data.userFoundAnswer = false; session.pauseCountdown = false; session.expandedQuiz = null;">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </x-splade-form>
                                </div>
                                <x-splade-form stay :action="route('sessions.results.wrong', [$session, $quiz])">
                                    <button type="submit"
                                        v-show="!session.started || session.expandedQuiz == null || session.expandedQuiz == '{{ $quiz->id }}'"
                                        class="transition-opacity duration-300"
                                        @click="
                                        setToggle(!toggled);
                                        if(!session.over){
                                            session.pauseCountdown = !toggled;
                                            session.expandedQuiz = !toggled ? '{{ $quiz->id }}' : null;
                                            if(!toggled && !data.answerRevealed){
                                                data.answerRevealed = true;
                                            }
                                        }
                                        {{-- @if ($quiz->is_cloze) data.answer =  checkpointSession.wrapTokensInText('{{ $quiz->answer }}') @endif --}}"
                                        v-text="toggled
                                        ? 'Hide' : 'Show answer'">
                                    </button>
                                </x-splade-form>
                            </div>
                        </div>
                    </x-splade-data>
                </x-splade-toggle>
            @endforeach
        </checkpoint-session>
    </main>
</x-layouts.app>
