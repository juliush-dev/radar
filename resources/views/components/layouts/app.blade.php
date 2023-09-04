<div class="h-screen flex justify-center items-center text-ellipsis p-8 gap-10 flex-wrap">
    @auth
        <section class="h-full w-1/4">
            @include('left-panel')
        </section>
    @endauth
    <main class="h-full grow">
        {{ $slot }}
    </main>
    @isset($rightPanel)
        <section class="h-full w-1/4">
            {{ $rightPanel ?? '' }}
        </section>
    @endisset
</div>
