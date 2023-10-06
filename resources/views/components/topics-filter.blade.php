<x-splade-form method="get" preserve-scroll submit-on-change :default="[
    'subject' => request()->query('subject'),
    'year' => request()->query('year'),
]"
    class="flex w-full gap-6 items-center text-slate-800 grow px-6 lg:px-10  my-6 flex-wrap">
    <x-splade-select class="w-full lg:w-[400px] whitespace-nowrap" placeholder="Subject" name="subject"
        :options="$subjects" option-value="id" option-label="title" />
    <x-splade-select class="w-full lg:w-[400px] whitespace-nowrap" placeholder="Year" name="year" :options="$years"
        option-value="id" option-label="title" />
</x-splade-form>
