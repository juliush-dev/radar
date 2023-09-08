<div class="h-screen flex justify-center items-center text-ellipsis p-8 gap-4">
    @auth
        <section class="h-full w-1/4 flex-nowrap whitespace-nowrap shrink-0">
            @include('left-panel')
        </section>
    @endauth
    <main class="h-full grow overflow-hidden">
        {{ $slot }}
    </main>
    @isset($rightPanel)
        <section class="h-full w-1/4 bg-slate-900/60 p-8 rounded-md shadow-2xl overflow-y-auto">
            {{ $rightPanel ?? '' }}
        </section>
    @endisset
</div>
