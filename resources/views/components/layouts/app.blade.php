     <x-splade-data remember="radar" local-storage store="radar" default="{ dark: false}" />
     <div id="themeSetter" v-bind:class="radar.dark && 'dark'" class="h-screen w-screen bg-black">
         <div
             class="h-full w-full flex flex-col relative bg-slate-100 dark:bg-slate-950 text-slate-600 dark:text-slate-700 dark:border-slate-400/40  transition-all duration-100 overflow-hidden">
             <x-nav-bar :$activePage :$previousRoute :$icon />
             <Main v-slot="main">
                 <div class="flex-1 relative flex justify-center w-full overflow-hidden">
                     <div id="left-side" v-bind:class="main.leftSideActive ? 'left-0' : '-left-[100%]'"
                         class="bg-slate-100/90 dark:bg-slate-950/90 absolute h-full backdrop-blur z-10 lg:z-0 lg:backdrop-blur-none lg:static lg:block w-full md:w-96 lg:w-80 shadow-lg lg:shadow-none transition-all duration-300">
                         @if (isset($leftSide))
                             {{ $leftSide }}
                         @endif
                     </div>
                     <div class="w-full lg:w-[945px] flex-shrink-0 h-full overflow-y-auto" @preserveScroll('main-layout')>
                         <div
                             class="lg:hidden transition-all duration-300 absolute -left-0.5 bottom-0  -right-0.5 flex gap-4 my-6 z-20">
                             @if (isset($leftSide))
                                 <button @click="main.toggleLeftSide"
                                     class="flex gap-2 items-center bg-blue-200 text-blue-900 dark:bg-blue-950 dark:text-blue-200/40 font-medium py-1 px-2 shadow rounded transition-all duration-300 hover:shadow-sm">
                                     <svg v-if="!main.leftSideActive" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                         <path stroke-linecap="round" stroke-linejoin="round"
                                             d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                                     </svg>
                                     <svg v-if="main.leftSideActive" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                         <path stroke-linecap="round" stroke-linejoin="round"
                                             d="M6 18 18 6M6 6l12 12" />
                                     </svg>
                                 </button>
                             @endif
                             @if (isset($rightSide))
                                 <button @click="main.toggleRightSide"
                                     class="flex ml-auto gap-2 items-center bg-blue-200 text-blue-900 dark:bg-blue-950 dark:text-blue-200/40 font-medium py-1 px-2 shadow rounded transition-all duration-300 hover:shadow-sm">
                                     <svg v-if="!main.rightSideActive" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                         <path stroke-linecap="round" stroke-linejoin="round"
                                             d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                                     </svg>
                                     <svg v-if="main.rightSideActive" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                         <path stroke-linecap="round" stroke-linejoin="round"
                                             d="M6 18 18 6M6 6l12 12" />
                                     </svg>
                                 </button>
                             @endif
                         </div>
                         {{ $slot }}
                     </div>
                     <div id="right-side" v-bind:class="main.rightSideActive ? 'right-0' : '-right-[100%]'"
                         class="bg-slate-100/90 dark:bg-slate-950/90 absolute h-full backdrop-blur z-10 lg:z-0 lg:backdrop-blur-none lg:static lg:block w-full md:w-96 lg:w-80 shadow-lg lg:shadow-none transition-all duration-300">
                         @if (isset($rightSide))
                             {{ $rightSide }}
                         @endif
                     </div>
                     <bottom-side :bottom-data="main.bottomData" />
                 </div>
             </Main>
         </div>
     </div>
