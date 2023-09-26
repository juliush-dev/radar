<x-layouts.app
    icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
    <x-slot:content-header>
        <div class="w-full px-6 text-center">
            <h5 class="font-medium ">
                Made with <a href="https://splade.dev/"
                    class="underline underline-offset-2 bg-pink-500 p-1 px-1.5 rounded-full">
                    Laravel
                    Splade</a>
            </h5>
        </div>
    </x-slot>
    <div id="hero" class="w-full h-full flex flex-col py-10 px-80 gap-20 justify-center">
        <h1 class="text-slate-700 font-extrabold text-5xl tracking-tight text-center">
            Access all the resources you need to ace your exams. All in one place</h1>
        <div>
            <h2 class="uppercase text-center text-8xl font-extralight text-slate-800 mb-4">radar</h2>
            <x-layouts.navigation-link type="call-to-action" class="text-xl mx-auto text-white" resource="topics"
                action="index" label="Access the topics gallery now"
                icon="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
        </div>
        <div class="font-semibold text-center text-xl text-slate-900 uppercase grid grid-cols-4 gap-6">
            <div
                class="p-6 bg-slate-50/50 border border-slate-300 backdrop-blur flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
                <h4 class="mb-4">Navigate</h4>
                <p class="text-sm font-normal first-letter:uppercase lowercase">
                    100+ of topics are waiting for you to explore.
                </p>
            </div>
            <div
                class="p-6 bg-orange-600/5 border border-slate-300 backdrop-blur flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                <h4 class="mb-4">Download</h4>
                <p class="text-sm font-normal first-letter:uppercase lowercase">Learning materials at finger tips,
                    just download and exploit them.</p>
            </div>
            <div
                class="p-6 bg-green-400/5 border border-slate-300 backdrop-blur flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                </svg>

                <h4 class="mb-4">Share</h4>
                <p class="text-sm font-normal first-letter:uppercase lowercase">Want to contribute? Upload more
                    learning materials to topics.</p>
            </div>
            <div
                class="p-6 bg-cyan-400/5 border border-slate-300 backdrop-blur flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                </svg>

                <h4 class="mb-4">Evaluate</h4>
                <p class="text-sm font-normal first-letter:uppercase lowercase">
                    Evaluate yourself to focus on what you haven't mastered yet.
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
