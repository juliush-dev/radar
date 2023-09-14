<x-layouts.main-content>
    <div class="flex gap-6 justify-between shadow p-6">
        <h1 class="text-xl text-teal-600 flex gap-2 items.center capitalize flex-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="{{ strlen($actionIcon) > 0 ? $actionIcon : 'M12 6v12m6-6H6' }}" />
            </svg>
            <span>{{ $label }}</span>
        </h1>
        <div class="flex gap-4 items-center">
            <Link href="/" class="pl-2 underline underline-offset-2">Back to landing page</Link>
            @if (Route::current()->getName() == 'skill.index' ||
                    Route::current()->getName() == 'skill.show' ||
                    Route::current()->getName() == 'skill.topic.show')
                <Link href="{{ route('topic.index') }}"
                    class="text-lime-600 pl-2 underline underline-offset-2 first-letter:uppercase">
                switch to topic view
                </Link>
                <span
                    class="px-3 py-1 leading-snug text-sm rounded-full rounded-tr-none rounded-br-none mr-1 bg-amber-500/40">Skills
                    view</span>
            @elseif (Route::current()->getName() == 'topic.index' || Route::current()->getName() == 'topic.show')
                <Link href="{{ route('skill.index') }}"
                    class="text-amber-600 pl-2 underline underline-offset-2 first-letter:uppercase">
                switch to skill view
                </Link>
                <span
                    class="px-3 py-1 leading-snug text-sm rounded-full rounded-tr-none rounded-br-none mr-1 bg-lime-500/40">Topic
                    view</span>
            @endif
            @isset($moreNavigation)
                {{ $moreNavigation }}
            @endisset
        </div>
    </div>
    <div class="h-full overflow-y-auto overflow-x-hidden flex flex-col gap-6 p-6 pt-0 relative">
        {{ $slot }}
    </div>
</x-layouts.main-content>
