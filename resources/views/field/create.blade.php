<x-layouts.app active-page="Create Field"
    icon="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10">
    @php($years = $rq->years())
    <div class="relative h-full overflow-y-auto px-6 lg:px-80 md:px-60 pb-6">
        <div class="sticky top-0 z-10 flex gap-0 bg-white w-full flex-wrap shadow mb-4 pt-4">
            <button class="px-6 py-4 cursor-pointer  bg-pink-500 text-white">Field</button>
        </div>
        <div class="w-full flex flex-col bg-white p-8">
            <x-splade-form :action="route('fields.store')" method="post" class="w-full">
                <x-splade-input required name="title" label="title" class="mb-4" />
                <x-splade-input required name="code" label="code" class="mb-4" />
                <x-splade-select required name="years" :options="$years" option-value="id" option-label="title"
                    label="Years" multiple class="mb-4" />
                <x-splade-wysiwyg name="details" label="Details" class="mb-4" />

                <div class="flex justify-between my-6 gap-6">
                    <x-splade-submit class="bg-fuchsia-500 hover:bg-fuchsia-600 shadow-md" :label="__('Create')" />
                    <Link href="{{ route('fields.index') }}"
                        class=" whitespace-nowrap flex items-center justify-center w-fit px-4 rounded-none text-white bg-slate-400 shadow hover:bg-slate-500 hover:shadow-md align-middle">
                    Cancel creation
                    </Link>
                </div>
            </x-splade-form>
        </div>
    </div>
</x-layouts.app>
