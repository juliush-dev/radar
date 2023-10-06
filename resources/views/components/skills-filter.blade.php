<x-splade-form method="get" preserve-scroll submit-on-change :default="[
    'year' => request()->query('year'),
    'field' => request()->query('field'),
]"
    class="flex gap-6 text-slate-800 grow px-6 md:px-20 lg:px-32  my-10 flex-wrap">
    <x-splade-select class="w-full lg:w-[400px] whitespace-nowrap" placeholder="Year" name="year" :options="$years"
        option-value="id" option-label="title" />
    <x-splade-select class="w-full lg:w-[400px] whitespace-nowrap" placeholder="Field" name="field" :options="$fields"
        option-value="id" option-label="code" />
</x-splade-form>
