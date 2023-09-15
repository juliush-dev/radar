<x-layouts.main-content>
    <div class="flex gap-6 justify-between shadow p-6 xl:px-20">
        <div class="flex gap-6 items-center">
            <h1 class="text-2xl text-teal-600 flex gap-2 items.center capitalize flex-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="{{ strlen($actionIcon) > 0 ? $actionIcon : 'M12 6v12m6-6H6' }}" />
                </svg>
                <span>{{ $label }}</span>
            </h1>
            @php
                $isViewingTopics = Route::current()->getName() == 'topic.index' || Route::current()->getName() == 'topic.show';
                $isViewingSkills = Route::current()->getName() == 'skill.index' || Route::current()->getName() == 'skill.show' || Route::current()->getName() == 'skill.topic.show';
            @endphp
            @if ($isViewingTopics || $isViewingSkills)
                <div class="border rounded-full flex flex-nowrap gap-0 items-center -mb-1">
                    <Link href="{{ route('skill.index') }}"
                        class="px-3 py-0.5 bg-teal-500 rounded-l-full text-center  text-white first-letter:uppercase {{ $isViewingTopics ? 'bg-slate-400 text-slate-50' : '' }}">
                    View skills
                    </Link>
                    <Link href="{{ route('topic.index') }}"
                        class="w-fit px-3 py-0.5 bg-teal-500 rounded-r-full text-center text-white first-letter:uppercase {{ $isViewingSkills ? 'bg-slate-400 text-slate-50' : '' }}">
                    View topics only
                    </Link>
                </div>
            @endif
        </div>
        <div class="flex gap-6 items-center">
            <Link href="/" class="pl-2 underline underline-offset-2">Back to landing page</Link>
            @isset($moreNavigation)
                {{ $moreNavigation }}
            @endisset
        </div>
    </div>
    <div class="h-full overflow-y-auto overflow-x-hidden flex flex-col gap-6 p-6 xl:px-20 pt-0 relative">
        {{ $slot }}
    </div>
</x-layouts.main-content>
