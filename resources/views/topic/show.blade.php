<x-layouts.app>
    <div id="topic" class="flex h-full p-10 text-white overflow-hidden">
        <main
            class=" backdrop-blur relative w-[500px] h-full flex flex-col bg-gradient-to-br from-blue-400/80  to-sky-500/90 justify-center">
            <div class="flex gap-2 justify-center mb-10">
                @auth
                    @php
                        $topicAssessment = $topic
                            ->assessments()
                            ->where('user_id', auth()->user()->id)
                            ->where('topic_id', $topic->id)
                            ->first();
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <x-splade-form :action="route('topics.assess', $topic) . '?stay=1'" :default="['assessment' => $i]">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor"
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
            <p class="font-medium break-all p-2 px-8 uppercase text-center text-md">
                {{ $topic->title }}
            </p>
            @if ($topic->subject)
                <p class="ftext-slate-500 uppercase text-center text-xs">
                    {{ $topic->subject->title }}
                </p>
            @endif
            @auth
                <x-splade-form method="delete" :action="route('topics.destroy', $topic)" class="absolute bottom-0 left-0">
                    <button type="submit"
                        class="flex justify-center items-center gap-2 text-white text-sm p-2 bg-red-600 hover:bg-red-800 rounded-t-none transition-all duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </x-splade-form>
                <x-layouts.navigation-link
                    class="text-white bg-blue-500 hover:bg-blue-600 h-[38px] w-[38px] rounded-t-none transition-all duration-300 px-2 absolute top-0 right-0"
                    resource="topics" action="edit" :action-args="$topic"
                    icon="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            @endauth
        </main>
        <main class="max-h-full overflow-hidden px-6 flex flex-col w-full">
            <h2 class="text-3xl font-semibold text-slate-800 mb-2">
                {{ $topic->learningMaterials->count() }} Learning materials
            </h2>
            <x-layouts.navigation-link class="text-slate-800 mb-4 self-start underline underline-offset-2"
                resource="topics" action="index" label="Back to the gallery"
                icon="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />

            <div class="overflow-y-auto h-full w-full pb-10">
                <div class="columns-3 space-y-3 w-full">
                    @foreach ($topic->learningMaterials as $lm)
                        @if (Illuminate\Support\Facades\Storage::disk('public')->exists($lm->alternative))
                            <x-splade-form method="get" :action="route('topics.learning-materials.download', $lm->id)" blob
                                class="break-inside-avoid group flex flex-col justify-center items-center relative w-full">
                                @if (in_array($lm->mime_type, array_column(\App\Enums\ImageMimeType::cases(), 'value')))
                                    <img src="{{ Illuminate\Support\Facades\Storage::url($lm->path) }}" alt=""
                                        srcset="" class="w-full" height="auto">
                                @endif
                                <button type="submit"
                                    class="flex gap-2 justify-center text-white text-sm bg-slate-800 hover:bg-slate-800/60 transition-all duration-200 py-1 w-full px-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 my-auto">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                    <span>{{ $lm->title }}</span>
                                </button>
                                @auth
                                    <x-splade-form :action="route('topics.learning-materials.remove', $lm->id) . '?stay=1'"
                                        class="absolute top-0 right-0 opacity-5 group-hover:opacity-100 transition-opacity duration-500">
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
            </div>
            <div class="max-h-full min-h-[150px] overflow-y-auto w-full mt-6">
                <x-splade-form :action="route('topics.learning-materials.upload', $topic->id) . '?stay=1'">
                    <x-splade-file label="Click the input field to add more" filepond preview
                        name="newLearningMaterials[]" class="text-lg font-light mb-2 text-left text-slate-900"
                        multiple />
                    @auth
                        <x-splade-submit class="bg-slate-800" label="Share" />
                    @else
                        <x-layouts.navigation-link class="px-6 flex justify-center text-white bg-slate-800 py-2"
                            @click.prevent="" resource="#login-required" label="Share" />
                    @endauth
                </x-splade-form>
            </div>
        </main>
    </div>
</x-layouts.app>
