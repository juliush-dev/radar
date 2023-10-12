<x-splade-table :for="$lms">
    @cell('title', $lm)
        @if (Illuminate\Support\Facades\Storage::disk('public')->exists($lm->alternative))
            <x-splade-form method="get" :action="route('topics.learning-materials.download', $lm->id)" blob class="flex flex-col relative max-w-[300px] overflow-hidden">
                @if (in_array($lm->mime_type, array_column(\App\Enums\ImageMimeType::cases(), 'value')))
                    <img src="{{ Illuminate\Support\Facades\Storage::url($lm->path) }}" alt="" srcset=""
                        class="w-[200px]" height="auto">
                @endif
                <div class="w-[200px] overflow-x-auto">
                    <button type="submit"
                        class="flex gap-2 items-center text-white text-sm bg-indigo-500 hover:bg-indigo-600 transition-all duration-200 min-w-full py-1 px-2">
                        <span class="px-1 bg-lime-400 text-slate-700">D</span>
                        <span class="first-letter:uppercase shrink text-sm">{{ $lm->title }}</span>
                    </button>
                </div>
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
