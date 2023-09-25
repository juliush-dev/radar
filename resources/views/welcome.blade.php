<x-layouts.app
    icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
    <div id="hero" class="w-full h-full flex flex-col pt-10 px-80">
        <h1 class="text-slate-700 font-extrabold text-6xl tracking-tight text-center mb-10">
            Access all the resources you need to ace your exams. All in one place</h1>
        <h2 class="uppercase text-center text-8xl font-extralight text-slate-800 mb-4">radar</h2>
        <x-layouts.navigation-link type="call-to-action" class="text-xl mx-auto" resource="topics" action="index"
            label="Access the topics gallery now"
            icon="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
        <div class="font-semibold text-center text-xl uppercase grid grid-cols-4 gap-6 mt-28">
            <div class="p-6 bg-slate-50/5 border border-slate-300 backdrop-blur">
                <h4 class="mb-4">Navigate</h4>
                <p class="text-sm font-normal first-letter:uppercase lowercase">
                    100+ of topics are waiting for you to explore.
                </p>
            </div>
            <div class="p-6 bg-orange-600/5 border border-slate-300 backdrop-blur">
                <h4 class="mb-4">Download</h4>
                <p class="text-sm font-normal first-letter:uppercase lowercase">Learning materials at finger tips,
                    just download and exploit them.</p>
            </div>
            <div class="p-6 bg-green-400/5 border border-slate-300 backdrop-blur">
                <h4 class="mb-4">Share</h4>
                <p class="text-sm font-normal first-letter:uppercase lowercase">Want to contribute? Upload more
                    learning materials to topics.</p>
            </div>
            <div class="p-6 bg-cyan-400/5 border border-slate-300 backdrop-blur">
                <h4 class="mb-4">Evaluate</h4>
                <p class="text-sm font-normal first-letter:uppercase lowercase">
                    Evaluate yourself to focus on what you haven't master yet.
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
