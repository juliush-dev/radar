<x-splade-table :for="$lms">
    @cell('title', $lm)
        @if (Illuminate\Support\Facades\Storage::disk('public')->exists($lm->alternative))
            <x-splade-form method="get" :action="route('topics.learning-materials.download', $lm->id)" blob class="flex flex-col relative w-full">
                @if (in_array($lm->mime_type, array_column(\App\Enums\ImageMimeType::cases(), 'value')))
                    <img src="{{ Illuminate\Support\Facades\Storage::url($lm->path) }}" alt="" srcset=""
                        class="w-[100px]" height="auto">
                @endif
                <button type="submit"
                    class="flex gap-2 text-white text-sm bg-stone-500 hover:bg-stone-500/60 dark:bg-indigo-500 dark:hover:bg-indigo-500/60 transition-all duration-200 py-1 w-full px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 my-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span class="first-letter:uppercase">{{ $lm->title }}</span>
                </button>
            </x-splade-form>
        @endif
    @endcell
    @cell('topic', $lm)
        <x-splade-link :href="route('topics.show', $lm->topic)" class="text-teal-500 hover:text-teal-700 transition-colors duration-300">
            {{ $lm->topic->title }}
        </x-splade-link>
    @endcell
    @cell('public', $lm)
        <x-splade-form submit-on-change :action="$lm->is_public
            ? route('topics.learning-materials.unpublish', $lm)
            : route('topics.learning-materials.publish', $lm)" method="post" :default="['is_public' => $lm->is_public]">
            <x-splade-checkbox name="is_public" value="1" class="checked:bg-fuchsia-400" />
        </x-splade-form>
    @endcell
    @cell('action', $lm)
        <x-splade-link method="delete" href="{{ route('topics.learning-materials.remove', $lm) }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor"
                class="w-4 h-4 text-red-500 hover:text-red-600 shadow
                hover:shadow-md transition-all duration-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </x-splade-link>
    @endcell
</x-splade-table>
