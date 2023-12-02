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
     class="z-30 flex flex-wrap lg:flex-nowrap items-center gap-0 md:gap-0 justify-between w-full  text-slate-800 dark:text-white border-b border-slate-300/50 dark:border-slate-700/50"
     @preserveScroll('navigationContainer')>
     <div class="flex gap-2 items-center pt-4 px-4 lg:pt-0 lg:py-2 lg:px-10 md:pb-0 pl-[20px] md:pl-[21px]">
         <span
             class="justify-center p-1 bg-green-400 dark:bg-yellow-400 rounded-full text-slate-50 dark:text-slate-900 flex items.center capitalize flex-nowrap">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-5 h-5">
                 <path stroke-linecap="round" stroke-linejoin="round"
                     d="{{ strlen($icon) > 0 ? $icon : 'M12 6v12m6-6H6' }}" />
             </svg>
         </span>
         <h1
             class="text-xl font-medium text-green-400 dark:text-yellow-400 whitespace-nowrap w-full lg:w-52 overflow-hidden text-ellipsis">
             {{ empty($activePage) ? 'Welcome' : $activePage }}
         </h1>
     </div>
     <div class="text-base flex gap-6 items-center text-fuchsia-600 dark:text-fuchsia-300 w-fit transition-all duration-200  py-2 pr-7 xs:pl-[23.2px] pl-[22px]  lg:px-10 lg:pl-0 overflow-x-auto"
         @preserveScroll('mainNavigation')>
         @if (!Route::is('welcome'))
             <x-layouts.navigation-link class="hover:text-fuchsia-700 dark:hover:text-fuchsia-600" resource="welcome"
                 label="Landing page"
                 icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
         @endif
         @if (!Route::is('topics.index'))
             <x-layouts.navigation-link class="hover:text-fuchsia-700 dark:hover:text-fuchsia-600" resource="topics"
                 action="index" label="Topics"
                 icon="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
         @endif
         @if (!Route::is('skills.index'))
             <x-layouts.navigation-link class="hover:text-fuchsia-700 dark:hover:text-fuchsia-600" resource="skills"
                 action="index" label="Skills"
                 icon="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
         @endif

         @if (!Route::is('fields.index'))
             <x-layouts.navigation-link class="hover:text-fuchsia-700 dark:hover:text-fuchsia-600" resource="fields"
                 action="index" label="Fields"
                 icon="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
         @endif
         @auth
             @if (!Route::is('dashboard.index'))
                 @can('use-dashboard')
                     <x-layouts.navigation-link class="hover:text-fuchsia-700 dark:hover:text-fuchsia-600" resource="dashboard"
                         action="index" label="Dashboard"
                         icon="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />
                 @endcan
             @endif
         @endauth
         <x-authentication />
         <x-splade-link modal :href="$previousRoute"
             class="my-auto whitespace-nowrap w-fit flex gap-2 justify-end text-fuchsia-400 hover:text-fuchsia-500 transition-all duration-300">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-5 h-5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
             </svg>
         </x-splade-link>
         <button @click="radar.dark = !radar.dark" v-text="radar.dark ? '🙄' : '🥱'"
             class="mt-0.5 px-0.5 whitespace-nowrap"></button>
     </div>
 </div>
