<x-layouts.app active-page="Edit Subject"
    icon="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10">
    <x-splade-modal>
        <div class="bg-white border dark:border-white border-slate-300 relative w-full overflow-y-auto p-8 rounded-md">
            <x-splade-form :action="route('topics.subjects.update', $subject)" method="patch" :default="[
                'title' => $subject->title,
                'abbreviation' => $subject->abbreviation,
                'years' => $subject->years->pluck('year'),
            ]" class="w-full">
                <x-splade-input required name="title" label="title" class="mb-4" />
                <x-splade-input required name="abbreviation" label="abbreviation" class="mb-4" />
                <x-splade-select name="years" :options="$years" option-value="id" option-label="title" label="Years"
                    multiple class="mb-4" />
                <button type="submit"
                    class="w-full py-2 px-4 bg-fuchsia-500 text-white hover:bg-fuchsia-600 shadow-md">
                    Save changes
                </button>
            </x-splade-form>
        </div>
    </x-splade-modal>
</x-layouts.app>
