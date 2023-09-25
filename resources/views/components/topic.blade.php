<x-splade-toggle data="uploadFormOpened, lmsOpened">
    <div v-bind:class="(uploadFormOpened == true ||lmsOpened == true) && 'border-none'"
        class="group bg-slate-700 text-white hover:bg-blue-600  w-full break-inside-avoid overflow-hidden flex flex-col relative topic transition-all duration-300">
        <section class="relative w-full flex gap-6 justify-center">
            <button @click.prevent="toggle('lmsOpened'); uploadFormOpened && toggle('uploadFormOpened');"
                class="flex items-center justify-center p-2 bg-slate-800 hover:bg-slate-600 rounded-t-none opacity-0 group-hover:opacity-100 transition-all duration-200">
                <svg v-show="lmsOpened" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mx-auto text-white">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span v-show="lmsOpened == false"
                    class="text-white px-2">{{ $topic->learningMaterials->count() }}</span>
            </button>
            <button @click.prevent="toggle('uploadFormOpened'); lmsOpened && toggle('lmsOpened')"
                class="flex items-center justify-center p-2 bg-slate-800 rounded-t-none opacity-0 group-hover:opacity-100 hover:bg-slate-600 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 mx-auto text-white">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        v-bind:d=" uploadFormOpened ? 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z' :'M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5'" />
                </svg>
            </button>
            @auth
                <x-splade-form :action="route('login')">
                    <button type="submit"
                        class="flex justify-center items-center gap-2 text-white text-sm p-2 bg-slate-800 hover:bg-slate-600 rounded-t-none opacity-0 group-hover:opacity-100 transition-all duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </button>
                </x-splade-form>
                <x-splade-form method="delete" :action="route('topics.destroy', $topic)">
                    <button type="submit"
                        class="flex justify-center items-center gap-2 text-white text-sm p-2 bg-red-600 hover:bg-red-800 rounded-t-none opacity-0 group-hover:opacity-100 transition-all duration-1000">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </x-splade-form>
            @endauth
        </section>
        <div class="flex flex-col w-full grow justify-center items-center p-6 transition-all duration-500">
            <div class="space-y-3 my-auto w-full">
                <div class="flex gap-2 justify-center">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-6 h-6 transition-all duration-300 {{ isset($topicAssessment) && isset($topicAssessment->assessment) && $i <= $topicAssessment->assessment ? 'fill-yellow-400 text-yellow-400 group-hover:fill-yellow-400' : '' }}">
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
                                stroke="currentColor" class="w-6 h-6  transition-all duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                            </Link>
                        @endfor
                    @endauth
                </div>
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
                <p class="font-mono break-all p-2 uppercase text-center text-2xl">
                    {{ $topic->title }}
                </p>
                @if ($topic->subject)
                    <p class="ftext-slate-500 uppercase text-center text-sm">
                        {{ $topic->subject->title }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-10">
            <x-splade-transition show="uploadFormOpened">
                <x-splade-form :action="route('topics.learning-materials.upload', $topic->id)" class="w-full text-center p-4">
                    <x-splade-file filepond preview name="newLearningMaterials[]"
                        class="mb-4 placeholder:text-center text-slate-100" help="Click the input field" multiple />
                    @auth
                        <x-splade-submit class="bg-slate-800" label="Upload" />
                    @else
                        <x-layouts.navigation-link class="w-full flex justify-center text-white bg-slate-800 py-2"
                            @click.prevent="" resource="#login-required" label="Upload" />
                    @endauth
                </x-splade-form>
            </x-splade-transition>
            <x-splade-transition show="lmsOpened">
                <div>
                    @foreach ($topic->learningMaterials as $lm)
                        @if (Illuminate\Support\Facades\Storage::disk('public')->exists($lm->alternative))
                            <x-splade-form method="get" :action="route('topics.learning-materials.download', $lm->id)" blob
                                class="flex flex-col justify-center items-center relative p-4 pb-2">
                                @if (in_array($lm->mime_type, array_column(\App\Enums\ImageMimeType::cases(), 'value')))
                                    <img src="{{ Illuminate\Support\Facades\Storage::url($lm->path) }}" alt=""
                                        srcset="" class="w-full" height="auto">
                                @endif
                                <button type="submit"
                                    class="flex gap-2 justify-center text-white text-sm bg-slate-800 hover:bg-slate-800/60 transition-all duration-200 py-1 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                    <span>{{ $lm->title }}</span>
                                </button>
                                @auth
                                    <x-splade-form :action="route('topics.learning-materials.remove', $lm->id)" class="absolute top-4 right-6">
                                        <button type="submit"
                                            class="flex gap-2 text-white text-sm p-2 bg-red-600 rounded-t-none">
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
                </div>
            </x-splade-transition>
        </div>
    </div>
</x-splade-toggle>
