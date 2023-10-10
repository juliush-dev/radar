 @php
     $data = ['one' => false, 'two' => false, 'three' => false, 'four' => false, 'five' => false];
 @endphp
 <x-splade-data :default="$data">
     @auth
         <x-splade-form :action="$href" method="post" submit-on-change="assessment" :default="['assessment' => $assessment]" class="mb-2">
             <div class="flex gap-1 items-center w-fit">
                 <button @click="form.assessment = 1" title="Beginner" class="w-fit rounded-full" @mouseover="data.one = true"
                     @mouseleave="data.one = false">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4 transition-all duration-200"
                         v-bind:class="data.one ? 'text-yellow-400 fill-yellow-400' : (1 <= {{ $assessment }} ? 'text-yellow-400 fill-yellow-400' : 'text-slate-400 fill-slate-400')">
                         <circle cx="12" cy="12" r="10" />
                     </svg>
                 </button>
                 <button @click="form.assessment = 2" title="Intermediate" class="w-fit rounded-full"
                     @mouseover="data.one = data.two = true" @mouseleave="data.one = data.two = false">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4 transition-all duration-300"
                         v-bind:class="data.two ? 'text-yellow-400 fill-yellow-400' : (2 <= {{ $assessment }} ? 'text-yellow-400 fill-yellow-400' : 'text-slate-400 fill-slate-400')">
                         <circle cx="12" cy="12" r="10" />
                     </svg>
                 </button>
                 <button @click="form.assessment = 3" title="Advanced" class="w-fit rounded-full"
                     @mouseover="data.one = data.two = data.three = true"
                     @mouseleave="data.one = data.two = data.three = false">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4 transition-all duration-500"
                         v-bind:class="data.three ? 'text-yellow-400 fill-yellow-400' : (3 <= {{ $assessment }} ? 'text-yellow-400 fill-yellow-400' : 'text-slate-400 fill-slate-400')">
                         <circle cx="12" cy="12" r="10" />
                     </svg>
                 </button>
                 <button @click="form.assessment = 4" title="Expert" class="w-fit rounded-full"
                     @mouseover="data.one = data.two = data.three = data.four = true"
                     @mouseleave="data.one = data.two = data.three = data.four = false">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4 transition-all duration-700"
                         v-bind:class="data.four ? 'text-yellow-400 fill-yellow-400' : (4 <= {{ $assessment }} ? 'text-yellow-400 fill-yellow-400' : 'text-slate-400 fill-slate-400')">
                         <circle cx="12" cy="12" r="10" />
                     </svg>
                 </button>
                 <button @click="form.assessment = 5" title="Guru" class="w-fit rounded-full"
                     @mouseover="data.one = data.two = data.three = data.four = data.five = true"
                     @mouseleave="data.one = data.two = data.three = data.four = data.five = false">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4 transition-all duration-1000"
                         v-bind:class="data.five ? 'text-yellow-400 fill-yellow-400' : (5 <= {{ $assessment }} ? 'text-yellow-400 fill-yellow-400' : 'text-slate-400 fill-slate-400')">
                         <circle cx="12" cy="12" r="10" />
                     </svg>
                 </button>
                 <button v-if="form.assessment > 0" @click="form.assessment = 0" title="Reset mastery"
                     class="w-fit rounded-full">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4 text-yellow-400">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M11.412 15.655L9.75 21.75l3.745-4.012M9.257 13.5H3.75l2.659-2.849m2.048-2.194L14.25 2.25 12 10.5h8.25l-4.707 5.043M8.457 8.457L3 3m5.457 5.457l7.086 7.086m0 0L21 21" />
                     </svg>
                 </button>
             </div>
         </x-splade-form>
     @else
         <Link href="#login-required" class="flex gap-1 items-center w-fit mb-2">
         <div class="w-fit rounded-full" @mouseover="data.one = true" @mouseleave="data.one = false">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4 transition-all duration-200"
                 v-bind:class="data.one ? 'text-yellow-400 fill-yellow-400' : 'text-slate-400 fill-slate-400'">
                 <circle cx="12" cy="12" r="10" />
             </svg>
         </div>
         <div class="w-fit rounded-full" @mouseover="data.one = data.two = true"
             @mouseleave="data.one = data.two = false">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4 transition-all duration-300"
                 v-bind:class="data.two ? 'text-yellow-400 fill-yellow-400' : 'text-slate-400 fill-slate-400'">
                 <circle cx="12" cy="12" r="10" />
             </svg>
         </div>
         <div class="w-fit rounded-full" @mouseover="data.one = data.two = data.three = true"
             @mouseleave="data.one = data.two = data.three = false">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4 transition-all duration-500"
                 v-bind:class="data.three ? 'text-yellow-400 fill-yellow-400' : 'text-slate-400 fill-slate-400'">
                 <circle cx="12" cy="12" r="10" />
             </svg>
         </div>
         <div class="w-fit rounded-full" @mouseover="data.one = data.two = data.three = data.four = true"
             @mouseleave="data.one = data.two = data.three = data.four = false">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4 transition-all duration-700"
                 v-bind:class="data.four ? 'text-yellow-400 fill-yellow-400' : 'text-slate-400 fill-slate-400'">
                 <circle cx="12" cy="12" r="10" />
             </svg>
         </div>
         <div class="w-fit rounded-full" @mouseover="data.one = data.two = data.three = data.four = data.five = true"
             @mouseleave="data.one = data.two = data.three = data.four = data.five = false">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4 transition-all duration-1000"
                 v-bind:class="data.five ? 'text-yellow-400 fill-yellow-400' : 'text-slate-400 fill-slate-400'">
                 <circle cx="12" cy="12" r="10" />
             </svg>
         </div>
         </Link>
     @endauth
 </x-splade-data>
