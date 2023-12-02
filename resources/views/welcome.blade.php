<x-layouts.app
    icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
    <div class="h-full overflow-hidden">
        <div
            class="flex h-full grow flex-col gap-8 md:pb-4 text-slate-600 dark:text-slate-100 items-center justify-center  px-6 md:px-10 lg:px-80">
            <h5 class="font-medium text-smp-4 py-6 text-center text-slate-600 dark:text-slate-400">
                Made with <a href="https://splade.dev/"
                    class="underline underline-offset-2 bg-pink-500 p-1 px-2 text-slate-100 dark:text-slate-200">
                    Laravel Splade </a>
            </h5>
            <h1
                class="uppercase text-fuchsia-900 mb-4 dark:text-fuchsia-300 text-center text-5xl lg:text-5xl font-extralight">
                ScholarBox
            </h1>

            <img src="{{ Vite::asset('resources/images/undraw_taking_notes_re_bnaf.svg') }}" alt="" width="300">
            <h2 class="text-lg lg:text-xl tracking-tight text-center mb-2">
                Manage your notes with ease!
            </h2>
        </div>
    </div>
</x-layouts.app>
