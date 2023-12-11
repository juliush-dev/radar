@php
    $relatives = $note->relatives
        ->map(function ($relative) {
            return ['id' => $relative->id, 'title' => $relative->extractTitle()];
        })
        ->all();
@endphp
<x-layouts.app>
    <x-splade-modal close-explicitly :close-button="false" class="bg-white dark:bg-slate-800 dark:text-slate-400">
        <x-splade-form action="{{ route('notes.relate', $note) }}" method="post" :default="[
            'relatives' => $relatives,
        ]">
            <ul class="flex flex-col gap-6 p-6">
                @foreach ($relativesOptions as $relative)
                    <label class="flex gap-2">
                        <input type="checkbox" v-model="form.relatives" :value="@js($relative)">
                        <span class="-mt-1">{{ $relative['title'] }}</span>
                    </label>
                @endforeach
            </ul>
            <button
                class="rounded-md fixed top-4 right-6 bg-sky-400 hover:bg-sky-500 transition-all duration-75 px-2 py-1 border-sky-400 text-white"
                type="submit" @click="modal.close">Done</button>
        </x-splade-form>
    </x-splade-modal>
</x-layouts.app>
