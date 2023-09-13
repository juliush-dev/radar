<div class="h-screen flex justify-center items-center text-ellipsis">
    @isset($rightPanel)
        <section class="h-full w-1/4 overflow-y-hidden p-8">
            {{ $rightPanel ?? '' }}
        </section>
    @endisset

    <main class="h-full grow overflow-hidden p-8">
        {{ $slot }}
    </main>

    @auth
        <section class="h-full w-1/4 flex-nowrap whitespace-nowrap shrink-0 p-8 bg-slate-50">
            @include('left-panel')
        </section>
    @endauth

</div>
