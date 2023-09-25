<x-splade-form method="get" preserve-scroll :default="[
    'subject' => request()->query('subject'),
    'year' => request()->query('year'),
    'skill' => request()->query('skill'),
]" class="flex w-full gap-6 items-center">
    <x-splade-select class="w-48" placeholder="Subject" name="subject" :options="$subjects" option-value="id"
        option-label="title" />
    <x-splade-select class="w-48" placeholder="Year" name="year" :options="$years" option-value="id"
        option-label="title" />
    <x-splade-select class="w-48" placeholder="Skill" name="skill" :options="$skills" option-value="id"
        option-label="title" />
    {{-- <x-splade-select name="skill" :options="$skills" option-value="id" option-label="label" /> --}}
    <x-splade-submit class="bg-slate-700 hover:bg-slate-600 shadow-md" :label="__('Apply')" />
</x-splade-form>
