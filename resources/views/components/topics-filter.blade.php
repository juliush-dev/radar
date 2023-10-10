<x-splade-form method="get" preserve-scroll submit-on-change="reset" :default="[
    'subject' => request()->query('subject'),
    'year' => request()->query('year'),
    'assessment' => request()->query('assessment'),
]"
    class="w-full z-20 flex flex-col gap-4 text-slate-800 dark:text-slate-400 grow px-6 lg:px-10 my-4 flex-wrap">
    <x-splade-toggle class="w-full">
        <div class="w-full flex  gap-4 justify-end">
            <button @click.prevent="toggle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-violet-500 hover:text-violet-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        v-bind:d="toggled ? 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z'" />
                </svg>
            </button>
            <button title="reset filter" v-show="form.year || form.assessment || form.subject"
                @click="form.reset=true;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-violet-500 hover:text-violet-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.412 15.655L9.75 21.75l3.745-4.012M9.257 13.5H3.75l2.659-2.849m2.048-2.194L14.25 2.25 12 10.5h8.25l-4.707 5.043M8.457 8.457L3 3m5.457 5.457l7.086 7.086m0 0L21 21" />
                </svg>
            </button>
        </div>
        <x-splade-transition show="toggled" class="w-full flex flex-wrap gap-6 mb-4">
            <x-splade-select class="w-full lg:w-[400px] whitespace-nowrap" label="Where subject is" placeholder="..."
                name="subject" :options="$subjects" option-value="id" option-label="title" />
            <x-splade-select class="w-full lg:w-[400px] whitespace-nowrap" label="Where year is" placeholder="..."
                name="year" :options="$years" option-value="id" option-label="title" />
            @auth
                <div class="flex flex-col gap-1">
                    <span class="font-normal">Where assessment is</span>
                    <div class="flex flex-nowrap gap-1 my-auto">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg @click="form.assessment = form.assessment == {{ $i }} ? ({{ $i - 1 }} < 1 ? null : {{ $i - 1 }} ) : {{ $i }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 text-yellow-400 hover:fill-yellow-400"
                                v-bind:class="form.assessment && {{ $i }} <= form.assessment && 'fill-yellow-400'">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        @endfor
                    </div>
                </div>
            @endauth
            @can('use-dashboard')
                <div class="flex justify-end items-center grow gap-6">
                    <x-splade-link :href="route('dashboard.index', ['tab' => 'topics'])"
                        class="w-fit flex items-center gap-2 justify-end text-violet-400 hover:text-violet-500 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 my-auto">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />
                        </svg> Topics dashboard
                    </x-splade-link>
                    <x-splade-link :href="route('dashboard.index', ['tab' => 'learning-materials'])"
                        class="w-fit flex items-center gap-2 justify-end text-violet-400 hover:text-violet-500 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 my-auto">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 01-.657.643 48.39 48.39 0 01-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 01-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 00-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 01-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 00.657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 01-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 005.427-.63 48.05 48.05 0 00.582-4.717.532.532 0 00-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 00.658-.663 48.422 48.422 0 00-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 01-.61-.58v0z" />
                        </svg> Lms dashboard
                    </x-splade-link>
                </div>
            @endcan
            <div class="flex gap-6 w-full">
                <x-splade-submit label="Filter" class="bg-fuchsia-500 hover:bg-fuchsia-600 text-white grow" />
                <button class="bg-slate-500 hover:bg-slate-600 text-white grow px-6"
                    @click.prevent="toggle">Cancel</button>
            </div>
        </x-splade-transition>
    </x-splade-toggle>
</x-splade-form>
