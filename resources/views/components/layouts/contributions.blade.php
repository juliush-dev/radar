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

        </div>
        <div class="flex gap-6 items-center">
            @isset($moreNavigation)
                {{ $moreNavigation }}
            @endisset
            <Link href="/" class="pl-2 underline underline-offset-2 flex gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 my-auto">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Back to landing page
            </Link>
            @auth
                <x-layouts.navigation-link resource="skills" action="index" label="Skills board"
                    icon-path="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                <x-layouts.navigation-link resource="learning-materials" action="index" label="Uploaded Learning materials"
                    icon-path="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
            @endauth
            <x-authentication />
        </div>
    </div>
    <div class="h-full overflow-y-auto overflow-x-hidden flex flex-col gap-6 p-6 pb-0 xl:px-20 pt-0 relative">
        {{ $slot }}
    </div>
</x-layouts.main-content>
