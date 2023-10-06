@php($years = $rq->years())
<div
    class="sticky top-0 z-10 flex gap-0 bg-white border border-slate-200 dark:border-white w-full flex-wrap shadow-sm mb-4 pt-4">
    <button class="px-6 py-4 cursor-pointer  bg-pink-500 text-white">Field</button>
</div>
<div class="w-full flex flex-col bg-white border border-slate-200 dark:border-white p-8">
    <x-splade-input required name="title" label="title" class="mb-4" />
    <x-splade-input required name="code" label="code" class="mb-4" />
    <x-splade-select required name="years" :options="$years" option-value="id" option-label="title" label="Years"
        multiple class="mb-4" />
    <x-splade-wysiwyg name="details" label="Details" class="mb-4" />

    <div class="flex justify-between my-6 gap-6">
        <x-splade-submit class="bg-fuchsia-500 hover:bg-fuchsia-600 shadow-md" :label="__('Create')" />
        <Link href="{{ route('fields.index') }}"
            class=" whitespace-nowrap flex items-center justify-center w-fit px-4 rounded-none text-white bg-slate-400 shadow hover:bg-slate-500 hover:shadow-md align-middle">
        Cancel creation
        </Link>
    </div>
</div>
