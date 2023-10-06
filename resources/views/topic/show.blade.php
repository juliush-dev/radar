<x-layouts.app :active-page="$topic->title"
    icon="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25">
    <main class="h-full overflow-y-auto text-white py-6 px-80">
        <h1 class="first-letter:uppercase text-xl mb-4 text-slate-300">
            {{ $topic->title }}
        </h1>
        <div class="text-sm flex items-center mb-4 gap-2">
            <Link modal href="{{ route('subjects.edit', $topic->subject) }}" class="text-teal-300">
            {{ $topic->subject->title }}
            </Link>/
            @if ($topic->years->count() > 0)
                <p class="font-light">
                    @foreach ($topic->years as $year)
                        <span class="first-letter:capitalize">{{ $year->year }}</span>
                        @if (!$loop->last)
                            <span class="mx-2">-</span>
                        @endif
                    @endforeach
                </p>
            @endif
            <div class="ml-auto flex gap-2 items-center">
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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 transition-all duration-300 {{ isset($topicAssessment) && isset($topicAssessment->assessment) && $i <= $topicAssessment->assessment ? 'fill-yellow-400 text-yellow-400' : 'hover:fill-yellow-400 hover:text-yellow-400' }}">
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
        </div>

        <hr class="mb-8">
        <h2 class="text-2xl mb-4">
            {{ $topic->learningMaterials->count() }} Learning materials
        </h2>
        <div class="columns-3 space-y-3 w-full mb-8">
            @foreach ($topic->learningMaterials as $lm)
                @if (Illuminate\Support\Facades\Storage::disk('public')->exists($lm->alternative))
                    <x-splade-form method="get" :action="route('topics.learning-materials.download', $lm->id)" blob
                        class="break-inside-avoid group flex flex-col justify-center items-center relative w-full">
                        @if (in_array($lm->mime_type, array_column(\App\Enums\ImageMimeType::cases(), 'value')))
                            <img src="{{ Illuminate\Support\Facades\Storage::url($lm->path) }}" alt=""
                                srcset="" class="w-full" height="auto">
                        @endif
                        <button type="submit"
                            class="flex gap-2 justify-center text-white text-sm bg-fuchsia-500 hover:bg-fuchsia-500/60 transition-all duration-200 py-1 w-full px-2">
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
                                <button type="submit" class="flex gap-2 text-white text-sm p-2 bg-red-600 rounded-t-none">
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
        <x-splade-form :action="route('topics.learning-materials.upload', $topic->id) . '?stay=1'" class="mb-10">
            <x-splade-file label="Click the input field to add more" filepond preview name="newLearningMaterials[]"
                class="text-lg font-light mb-2 text-left" multiple />
            @auth
                <x-splade-submit class="bg-fuchsia-500" label="Share" />
            @else
                <x-layouts.navigation-link class="px-6 flex justify-center text-white bg-fuchsia-500" @click.prevent=""
                    resource="#login-required" label="Share" />
            @endauth
        </x-splade-form>
        <h2 class="text-2xl mb-8">Skills</h2>
        <div class="mb-5 columns-1 space-y-6 w-full">
            @foreach ($topic->skills as $topicSkill)
                <x-skill :skill="$topicSkill->skill" />
            @endforeach
        </div>
        @auth
            <section class="relative w-full flex gap-4 text-white">
                <x-layouts.navigation-link class="text-blue-400" label="edit" resource="topics" action="edit"
                    :action-args="$topic" />
                <x-layouts.navigation-link class="text-red-400" label="delete" resource="topics" action="destroy"
                    :action-args="$topic" />
            </section>
        @endauth
    </main>
</x-layouts.app>
