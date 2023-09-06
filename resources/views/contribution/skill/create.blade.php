<x-layouts.app>
    <x-splade-modal max-width="2xl" class="bg-transparent">
        <div class="">
            <h1 class="text-xl mb-8 first-letter:uppercase flex items.center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                </svg>

                Skill
            </h1>
            <x-splade-form action="{{ route('contribution.skill.store') }}" class="flex flex-col gap-8">
                <x-splade-input name="title" label="Which Skill?" placeholder="The student should be able to ..." />
                <div class="p-3 rounded-md border border-slate-500">
                    <x-splade-group class="mb-4" name="source" label="Where did you get this info from?" inline>
                        @foreach ($sourcesOptions as $key => $value)
                            <x-splade-radio name="source" value="{{ $key }}" label="{{ $value }}" />
                        @endforeach
                    </x-splade-group>
                    <div class="transition duration-500"
                        v-bind:class="{'blur-sm': form.source != '{{ App\Enums\Source::InternetPage->value }}'}">
                        <x-splade-input v-bind:disabled="form.source != '{{ App\Enums\Source::InternetPage->value }}'"
                            name="link" label="Please provide the link to that page" />
                    </div>
                </div>
                <x-splade-select label="Which years of the training cover the subjects about this skill?"
                    name="years_levels_covering_it" :options="$yearsLevelsOptions" multiple />
                <x-splade-select label="Which fields of the training does this skill covers?"
                    name="fields_covered_by_it" :options="$knowledgeFieldsOptions" multiple />
                <x-splade-select class="text-slate-800" label="Which knowledge group covers this skill?"
                    name="knowledge_group_covering_it" :options="$knowledgeGroupsOptions" />

                <x-splade-select class="text-slate-800" label="Decide for the visibility of this contribution"
                    name="modification_type" :options="$modificationsTypesOptions" />
                <div class="flex justify-end mt-5">
                    <x-splade-submit label="Submit it" />
                </div>
            </x-splade-form>
        </div>
    </x-splade-modal>
</x-layouts.app>
