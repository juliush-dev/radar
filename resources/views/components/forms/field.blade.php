@php($years = $rq->years())
<div class="sticky right-0 overflow-x-auto top-0 z-10 flex bg-white gap-0 w-full flex-wrap shadow mb-4">
    <button class="px-6 py-4 cursor-pointer w-full md:w-fit bg-pink-500 text-white">Field</button>
    <div class="flex justify-start md:ml-auto w-full md:w-fit order-first md:order-last">
        <x-splade-submit class="bg-fuchsia-500 h-full w-full md:w-32 hover:bg-fuchsia-600 shadow-md whitespace-nowrap"
            :label="$actionLabel" />
        <Link href="{{ Referer::get() }}"
            class=" whitespace-nowrap flex items-center justify-center w-full md:w-fit px-4 rounded-none text-white bg-slate-400 shadow hover:bg-slate-500 hover:shadow-md align-middle">
        Cancel
        </Link>
    </div>
</div>
<div class="w-full flex flex-col bg-white border border-slate-200 dark:border-white p-8">
    <x-splade-input required name="title" label="title" class="mb-4" />
    <x-splade-input required name="code" label="code" class="mb-4" />
    <x-splade-select required name="years" :options="$years" option-value="id" option-label="title" label="Years"
        multiple class="mb-4" />
    <x-splade-wysiwyg name="details" label="Details" class="mb-4 prose jodit-wrapper" />
</div>
