 <div>
     <x-splade-toggle :data="$expanded">
         <h1 class="p-2 flex gap-2 rounded-t-md border border-slate-200 bg-slate-100 shadow transition-shadow duration-300"
             v-bind:class="toggled && 'bg-slate-200'" @click="toggle">
             <div class="p-2 my-auto rounded-full border border-slate-200 bg-white">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5 text-slate-400">
                     <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                 </svg>
             </div>
             <span class="my-auto">
                 {{ $title }}
             </span>
             <button class="my-auto ml-auto">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6 transition duration-500"
                     v-bind:class="{'-rotate-180': toggled}">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                 </svg>
             </button>
         </h1>
         <x-splade-transition show="toggled" class="duration-500" animation="slide-right">
             @if (isset($controlPanel))
                 <div class="p-4 bg-slate-100 shadow-inner">
                     {{ $controlPanel }}
                 </div>
             @endif
             <div class="p-4 bg-slate-100">
                 {{ $slot }}
             </div>
         </x-splade-transition>
     </x-splade-toggle>
 </div>
