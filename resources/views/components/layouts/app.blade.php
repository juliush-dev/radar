<div class="h-screen flex justify-center items-center text-ellipsis">
    @isset($rightPanel)
        <section class="h-full w-1/4 overflow-y-hidden p-8">
            {{ $rightPanel ?? '' }}
        </section>
    @endisset

    <main class="h-full grow overflow-hidden">
        {{ $slot }}
    </main>

    @auth
        <section class="h-full w-1/5 flex-nowrap whitespace-nowrap shrink-0 p-6 bg-slate-100 shadow">
            @include('left-panel')
        </section>
    @endauth

</div>
