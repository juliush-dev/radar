 @php
     $previousRoute = \Facades\Spatie\Referer\Referer::get();
     if (!request()->routeIs('topics.subjects.*') && !request()->routeIs('skills.groups.*') && !request()->routeIs('skills.types.*')) {
         \Facades\Spatie\Referer\Referer::put(Request::fullURL());
     }
 @endphp
 @guest
     <x-splade-modal name="login-required"
         class="absolute  w-4/5 md:w-1/2 mx-auto text-white bg-white dark:bg-slate-900 shadow shadow-fuchsia-400"
         position="center">
         <div class="p-8 mx-auto flex flex-col items-center justify-center gap-4">
             <h1 class="text-xl font-medium text-slate-600">Login required</h1>
             <x-layouts.navigation-link class="bg-fuchsia-600 hover:bg-fuchsia-700" type="call-to-action" resource="login"
                 label="Login and continue" />
         </div>
     </x-splade-modal>
 @endguest
 <div v-show="radar.navigation"
     class="bg-inherit @if (Agent::isAndroidOs() || Agent::isEdge()) pt-2 @endif sticky top-0 z-20 flex flex-wrap lg:flex-nowrap items-center gap-0 md:gap-0 justify-between w-full  text-slate-800 dark:text-white border-b border-slate-300/50 dark:border-slate-700/50 mx-6 lg:mx-0 overflow-hidden"
     @preserveScroll('navigationContainer')>
     <div class="w-full lg:w-[890px] mx-auto text-base flex gap-6 items-center text-fuchsia-600 dark:text-fuchsia-300 transition-all duration-200  py-2 overflow-x-auto pr-12 md:pr-0"
         @preserveScroll('mainNavigation')>
         <x-layouts.navigation-link class="hover:text-fuchsia-900 dark:hover:text-fuchsia-500" resource="notes"
             action="index" label="Notes"
             icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
         <x-layouts.navigation-link class="hover:text-fuchsia-900 dark:hover:text-fuchsia-500" resource="skills"
             action="index" label="Skills"
             icon="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
         <x-layouts.navigation-link class="hover:text-fuchsia-900 dark:hover:text-fuchsia-500" resource="fields"
             action="index" label="Fields"
             icon="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
         @auth
             @can('use-dashboard')
                 <x-layouts.navigation-link class="hover:text-fuchsia-900 dark:hover:text-fuchsia-500" resource="dashboard"
                     action="index" label="Dashboard"
                     icon="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />
             @endcan
         @endauth
         <div class="md:ml-auto flex gap-6">
             <x-authentication />
             <x-splade-link modal :href="$previousRoute"
                 class="my-auto whitespace-nowrap w-fit flex gap-2 justify-end text-fuchsia-400 hover:text-fuchsia-500 transition-all duration-300">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5">
                     <path stroke-linecap="round" stroke-linejoin="round"
                         d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                 </svg>
             </x-splade-link>
             <button @click="radar.dark = !radar.dark" v-text="radar.dark ? '🙄' : '🥱'"
                 class="mt-0.5 px-0.5 whitespace-nowrap"></button>
         </div>
     </div>
 </div>
