<div class="h-screen flex justify-center items-center text-ellipsis p-4 gap-3">
    @isset($rightPanel)
        <section class="h-full w-1/4 p-8 rounded-md shadow-2xl overflow-y-hidden">
            {{ $rightPanel ?? '' }}
        </section>
    @endisset

    <main class="h-full grow overflow-hidden">
        {{ $slot }}
    </main>

    @auth
        <section class="h-full w-1/4 flex-nowrap whitespace-nowrap shrink-0">
            @include('left-panel')
        </section>
    @endauth

</div>
