<x-splade-data store="session"
    default="{
        expandedQuiz: null,
        pauseCountdown: false,
        started: true,
        over: false
    }" />
<checkpoint-session v-slot="session" :content="@js(['id' => "{$session->id}"])">
    <x-splade-form method="patch" :action="route('sessions.stop', $session)" :default="['countdown' => $session->countdown, 'stopped' => false]" submit-on-change="stopped">
        <div class="h-screen w-screen flex justify-center items-center overflow-hidden text-slate-800"
            style="background: url('https://images.unsplash.com/photo-1682687980976-fec0915c6177?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')">
            <main class="p-6 lg:px-80">
                <h1 class="text-center first-letter:uppercase text-6xl font-semibold dark:text-slate-100">
                    {{ $session->checkpoint->title }}
                </h1>
                <h2 class="text-xl font-normal text-center my-3">{{ $session->checkpoint->topic->title }}</h2>
                <countdown v-slot="countdown" :form="form" :session="session" :run="true">
                    <div class="flex text-9xl font-semibold justify-center my-4">
                        <p v-text="countdown.getHour"></p><span>:</span>
                        <p v-text="countdown.getMin"></p><span>:</span>
                        <p v-text="countdown.getSec"></p>
                    </div>
                    <button
                        class="bg-red-500 rounded-md py-2 w-full px-2 text-white hover:bg-red-600 shadow-m whitespace-nowrap flex gap-1 items-center justify-center"
                        @click.prevent="countdown.stop()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z" />
                        </svg>
                        <span>Stop session</span>
                    </button>
                </countdown>
            </main>
        </div>
    </x-splade-form>
</checkpoint-session>
