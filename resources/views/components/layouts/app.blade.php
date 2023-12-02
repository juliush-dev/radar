     <x-splade-data remember="radar" local-storage store="radar" default="{ dark: false, navigation: true }" />
     <div class="w-screen h-screen overflow-hidden" v-bind:class="radar.dark && 'dark'">
         <div
             class="w-full flex flex-col  min-h-full relative bg-white dark:bg-slate-800 transition-all duration-500 overflow-hidden">
             <x-nav-bar :$activePage :$previousRoute :$icon />
             <div class="overflow-hidden relative flex-1">
                 <div class="absolute top-0 bottom-0 left-0 right-0 overflow-hidden">
                     {{ $slot }}
                 </div>
             </div>
         </div>
     </div>
