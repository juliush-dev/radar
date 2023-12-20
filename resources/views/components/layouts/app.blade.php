     <x-splade-data remember="radar" local-storage store="radar" default="{ dark: false, navigation: true }" />
     <div v-bind:class="radar.dark && 'dark'" class="h-screen w-screen flex items-center justify-center">
         <div
             class="h-full w-full flex flex-col relative bg-slate-100 dark:text-white text-slate-600  dark:bg-slate-800  transition-all duration-100 overflow-hidden">
             <x-nav-bar :$activePage :$previousRoute :$icon />
             <div class="flex-1 w-full overflow-hidden overflow-y-auto" @preserveScroll('main-layout')>
                 <div class="w-full lg:w-[920px] m-auto h-full">
                     {{ $slot }}
                     <div class="bg-inherit @if (Agent::isAndroidOs() || Agent::isEdge()) pb-36 @else pb-6 @endif"> </div>
                 </div>
             </div>
         </div>
     </div>
