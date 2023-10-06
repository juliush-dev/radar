<x-layouts.app
    icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
    <div class="h-full flex flex-col overflow-y-auto overflow-x-hidden px-6 md:px-10 lg:px-80">
        <h5 class="font-medium text-sm p-4 py-6 text-center text-slate-600 dark:text-slate-400">
            Made with <a href="https://splade.dev/"
                class="underline underline-offset-2 bg-pink-500 p-1 px-2 text-slate-100 dark:text-slate-200">
                Laravel
                Splade</a>
        </h5>
        <div id="hero"
            class="w-full grow flex flex-col mb-4 text-slate-600 dark:text-slate-100 items-center justify-center">
            <h1
                class="uppercase text-fuchsia-900 mb-4 dark:text-fuchsia-300 text-center text-3xl lg:text-5xl font-extralight">
                radar
            </h1>
            <h2 class="uppercase text-lg lg:text-2xl tracking-tight text-center mb-4">
                All the resources you need to ace your exams!
            </h2>
            <div class="mb-6 font-semibold text-center text-xl flex flex-wrap gap-6 items-center justify-center">
                <div
                    class="w-[280px] h-[180px] p-6 text-slate-950 bg-slate-50 shadow-lg shadow-fuchsia-400 backdrop-blur flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <h4 class="mb-4">Navigate</h4>
                    <p class="text-sm font-normal first-letter:uppercase">
                        100+ of topics are waiting for you to explore.
                    </p>
                </div>
                <div
                    class="w-[280px] h-[180px] p-6 text-white dark:text-slate-100 bg-pink-500 shadow-lg shadow-fuchsia-400 backdrop-blur flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <h4 class="mb-4">Download</h4>
                    <p class="text-sm font-normal first-letter:uppercase">Learning materials at finger tips,
                        just download and exploit them.</p>
                </div>
                <div
                    class="w-[280px] h-[180px] p-6 text-white dark:text-slate-100 bg-green-500 shadow-lg shadow-fuchsia-400 backdrop-blur flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>

                    <h4 class="mb-4">Share</h4>
                    <p class="text-sm font-normal first-letter:uppercase">Want to contribute? Upload more
                        learning materials to topics.</p>
                </div>
                <div
                    class="w-[280px] h-[180px] p-6 text-white dark:text-slate-100 bg-cyan-500 shadow-lg shadow-fuchsia-400 backdrop-blur flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>

                    <h4 class="mb-4">Evaluate</h4>
                    <p class="text-sm font-normal first-letter:uppercase">
                        Evaluate yourself to focus on what you haven't mastered yet.
                    </p>
                </div>
            </div>
            <x-layouts.navigation-link type="call-to-action"
                class="ml-1 w-fit text-md text-white bg-fuchsia-500 hover:bg-fuchsia-600 shadow-md shadow-slate-400"
                resource="topics" action="index" label="Access the Resources"
                icon="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
        </div>
    </div>
</x-layouts.app>
