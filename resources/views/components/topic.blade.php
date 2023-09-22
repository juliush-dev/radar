   <div
       class="shadow group hover:shadow-lg relative backdrop-blur-md w-[350px] bg-white text-teal-900 overflow-hidden topic min-h-[475px] gap-0 transition-all duration-100 items-center justify-center hover:border-teal-300 rounded-xl border border-teal-100">
       <div
           class="group-hover:bg-teal-400/20 bg-teal-400/5 backdrop-blur-md flex flex-col gap-10 justify-center items-center p-6 pt-8 transition-all duration-500">
           <div class="flex gap-2">
               @auth
                   @php
                       $topicAssessment = $topic
                           ->assessments()
                           ->where('user_id', auth()->user()->id)
                           ->where('topic_id', $topic->id)
                           ->first();
                   @endphp
                   @for ($i = 1; $i <= 5; $i++)
                       <x-splade-form :action="route('topics.assess', $topic)" :default="['assessment' => $i]">
                           <button type="submit">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                   stroke="currentColor"
                                   class="w-6 h-6 text-slate-500 transition-all duration-300 {{ isset($topicAssessment) && isset($topicAssessment->assessment) && $i <= $topicAssessment->assessment ? 'fill-teal-700 text-teal-700 group-hover:fill-teal-600 group-hover:text-teal-600' : '' }}">
                                   <path stroke-linecap="round" stroke-linejoin="round"
                                       d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                               </svg>
                           </button>
                       </x-splade-form>
                   @endfor
               @else
                   @for ($i = 1; $i <= 5; $i++)
                       <Link href="#login-required">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                           stroke="currentColor" class="w-6 h-6 text-slate-500  transition-all duration-300">
                           <path stroke-linecap="round" stroke-linejoin="round"
                               d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                       </svg>
                       </Link>
                   @endfor
               @endauth

           </div>
           <div class="space-y-3 my-auto">
               @if ($topic->years->count() > 0)
                   <p class="font-light text-center text-md">
                       @foreach ($topic->years as $year)
                           <span class="first-letter:capitalize">{{ $year->year }}</span>
                           @if (!$loop->last)
                               <span class="mx-2">-</span>
                           @endif
                       @endforeach
                   </p>
               @endif
               <p class="font-mono uppercase text-center text-2xl group-hover:text-teal-800">
                   {{ $topic->title }}
               </p>
               @if ($topic->subject)
                   <p class="ftext-slate-500 uppercase text-center text-sm">
                       {{ $topic->subject->title }}
                   </p>
               @endif
           </div>
       </div>
       <div
           class="bg-slate-50 group-hover:bg-slate-100 overflow-y-auto gap-4 justify-center items-center transition-all duration-700">
           <section class="p-6">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="w-6 h-6 mx-auto mb-2">
                   <path stroke-linecap="round" stroke-linejoin="round"
                       d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
               </svg>
               <h1 class="text-teal-900 text-center mb-4 text-lg">
                   ({{ $topic->learningMaterials->count() }}) Learning
                   Materials
               </h1>
               @foreach ($topic->learningMaterials as $lm)
                   @if (Illuminate\Support\Facades\Storage::disk('public')->exists($lm->alternative))
                       <x-splade-form method="get" :action="route('topics.learning-materials.download', $lm->id)" blob
                           class="flex flex-col justify-center items-center gap-2 mb-6 relative">
                           @if (in_array($lm->mime_type, array_column(\App\Enums\ImageMimeType::cases(), 'value')))
                               <img src="{{ Illuminate\Support\Facades\Storage::url($lm->path) }}" alt=""
                                   srcset="" class="w-full rounded-lg" height="auto">
                           @endif
                           <button type="submit" class="flex gap-2 hover:text-teal-400">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                   stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                   <path stroke-linecap="round" stroke-linejoin="round"
                                       d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                               </svg>
                               <span>{{ $lm->title }}</span>
                           </button>
                           @auth
                               <x-splade-form :action="route('topics.learning-materials.remove', $lm->id)" class="absolute -top-2 -right-3">
                                   <button type="submit" class="flex gap-2 text-white text-sm rounded-full p-2 bg-red-600">
                                   @endauth
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                       stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                           d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                   </svg>
                                   @auth
                                   </button>
                               </x-splade-form>
                           @endauth
                       </x-splade-form>
                   @endif
               @endforeach
           </section>
           <section class="bg-sky-400/5 group-hover:bg-sky-400/10 transition-all duration-300 p-6">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="w-6 h-6 mx-auto mb-2">
                   <path stroke-linecap="round" stroke-linejoin="round"
                       d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
               </svg>
               <h1 class="text-center mb-4 text-lg">Upload new Learning Materials</h1>
               <x-splade-form :action="route('topics.learning-materials.upload', $topic->id)" class="w-full text-center">
                   <x-splade-file filepond preview name="newLearningMaterials[]" class="mb-4 placeholder:text-center"
                       help="Click the input field" multiple />
                   @auth
                       <x-splade-submit label="Upload" />
                   @else
                       <x-layouts.navigation-link class="w-full flex justify-center" @click.prevent=""
                           type="call-to-action" resource="#login-required" label="Upload" />
                   @endauth
               </x-splade-form>
           </section>
       </div>
   </div>
