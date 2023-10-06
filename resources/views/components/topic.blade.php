<div
    class="group break-inside-avoid w-full border border-violet-300 text-white shadow shadow-violet-400/80 dark:shadow-violet-400/50 hover:shadow-md hover:shadow-violet-400/60  flex flex-col gap-0 p-6 transition-all duration-300">
    <Link href="{{ route('topics.show', $topic) }}"
        class="text-lg first-letter:uppercase w-full text-violet-500 group-hover:text-violet-700 dark:text-violet-300 dark:group-hover:text-violet-400 transition-colors duration-300">
    <h1 class="mb-2">{{ $topic->title }}</h1>
    </Link>
    <p class="font-normal text-sm mb-2 text-slate-500 dark:text-slate-300">
        <Link modal href="{{ route('subjects.edit', $topic->subject) }}" class="dark:text-teal-300 text-teal-500">
        {{ $topic->subject->title }}
        </Link>/
        @foreach ($topic->years as $year)
            <span
                class="first-letter:capitalize whitespace-nowrap dark:text-slate-300 text-slate-500">{{ $year->year }}</span>
            @if (!$loop->last)
                <span class="mx-1">-</span>
            @endif
        @endforeach
        <span class="mx-1">/</span>
        <span class="dark:text-slate-300 text-slate-500">{{ $topic->learningMaterials->count() }} Lms</span>
    </p>
    <div class="flex gap-2 dark:text-white text-slate-500 mb-4 text-sm">
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
                    <button type="submit" class="peer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 transition-all {{ isset($topicAssessment) && isset($topicAssessment->assessment) && $i <= $topicAssessment->assessment ? 'fill-yellow-300 text-yellow-300 group-hover:fill-yellow-300' : 'hover:fill-yellow-300 hover:text-yellow-300' }}">
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
                    stroke="currentColor" class="w-5 h-5  transition-all duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                </svg>
                </Link>
            @endfor
        @endauth
    </div>
    @auth
        <section class="relative w-full flex gap-4 text-white text-xs">
            <x-layouts.navigation-link class="text-blue-400" label="edit" resource="topics" action="edit"
                :action-args="$topic" />
            <x-layouts.navigation-link class="text-red-400" label="delete" resource="topics" action="destroy"
                :action-args="$topic" />
        </section>
    @endauth
</div>
