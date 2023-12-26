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
     class="bg-inherit py-2 l:gpy-1 sticky top-0 z-20 flex flex-wrap lg:flex-nowrap items-center gap-0 md:gap-0 justify-between w-full  text-slate-800 dark:text-white border-b border-slate-300/50 dark:border-slate-700/50 overflow-x-auto lg:overflow-hidden"
     @preserveScroll('navigationContainer')>
     <div class="lg:w-[980px] mx-6 text-base flex justify-evenly gap-6 items-center transition-all duration-200 lg:overflow-x-auto lg:mx-auto"
         @preserveScroll('mainNavigation')>
         <x-layouts.navigation-link resource="notes" action="index" label="Notes"
             icon="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z"
             :alternativeRouteNames="[['notes.edit', 'Back to notes'], ['notes.filter', 'Show all notes']]" />
         <x-layouts.navigation-link resource="skills" action="index" label="Skills"
             icon="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"
             :alternativeRouteNames="[['skills.show', 'Back to skills']]" />
         <x-layouts.navigation-link resource="fields" action="index" label="Fields"
             icon="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"
             :alternativeRouteNames="[['fields.show', 'Back to fields']]" />
         @auth
             @can('use-dashboard')
                 <x-layouts.navigation-link resource="dashboard" action="index" label="Dashboard"
                     icon="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />
             @endcan
         @endauth
         <x-authentication />
         <button @click="radar.dark = !radar.dark" v-text="radar.dark ? '🙄' : '🥱'"
             class="mt-0.5 whitespace-nowrap"></button>
     </div>
 </div>
