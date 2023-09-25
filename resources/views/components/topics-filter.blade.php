<x-splade-form method="get" preserve-scroll submit-on-change :default="[
    'subject' => request()->query('subject'),
    'year' => request()->query('year'),
    'skill' => request()->query('skill'),
]"
    class="flex w-full gap-6 items-center text-slate-800 grow">
    <x-splade-select class="w-[400px] whitespace-nowrap" placeholder="Subject" name="subject" :options="$subjects"
        option-value="id" option-label="title" />
    <x-splade-select class="w-[400px] whitespace-nowrap" placeholder="Year" name="year" :options="$years"
        option-value="id" option-label="title" />
    <x-splade-select class="w-[400px] whitespace-nowrap" placeholder="Skill" name="skill" :options="$skills"
        option-value="id" option-label="title" />
    {{-- <x-splade-select name="skill" :options="$skills" option-value="id" option-label="label" /> --}}
    {{-- <x-splade-submit class="bg-pink-600 hover:bg-pink-700 shadow-md text-md" :label="__('Apply')" /> --}}
</x-splade-form>
