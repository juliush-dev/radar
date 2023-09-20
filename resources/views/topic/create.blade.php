<x-layouts.app active-page="New Topic"
    icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
    @php($yearsOptions = $ent->asOptions('\App\Enums\Year'))
    @php($fieldsOptions = $qrt->fieldsAsOptions())
    @php($subjectsOptions = $qrt->subjectsAsOptions())
    <x-splade-form :action="route('topics.store')" class="mx-auto h-screen  p-6 lg:p-20" default="{
        newSubject: [],
        newFields: [],
    }">
        <topic v-slot="topic" :form="form" v-bind:years-options="@js($yearsOptions)"
            :fields-options="@js($fieldsOptions)" :subjects-options="@js($subjectsOptions)">
            <div class="h-full">
                <div class="flex">
                    <section class="px-6 w-full border-r border-teal-400 flex flex-col gap-6">
                        <h1 class="text-xl mb-4">New Topic</h1>
                        <x-splade-textarea name="name" label="Title" />
                        <x-splade-select name="year" label="Year">
                            <option v-for="option in topic.yearsOptions" v-bind:key="option.id"
                                v-bind:value="option.label">
                                @{{ option.label }}
                            </option>
                        </x-splade-select>
                        <x-splade-select name="subject" label="Subject" placeholder="Choose or create a new one">
                            <option v-for="option in topic.subjectsOptions" v-bind:key="option.id"
                                v-bind:value="option.id">
                                @{{ option.label }}
                            </option>
                        </x-splade-select>
                        <x-splade-select name="fields" label="Fields" placeholder="Choose or create a new one"
                            multiple>
                            <option v-for="option in topic.subjectsOptions" v-bind:key="option.id"
                                v-bind:value="option.label">
                                @{{ option.label }}
                            </option>
                        </x-splade-select>
                        <x-splade-select name="skill" label="Skill" placeholder="Choose or create a new one">
                            <option v-for="option in topic.fieldsOptions" v-bind:key="option.id"
                                v-bind:value="option.label">
                                @{{ option.label }}
                            </option>
                        </x-splade-select>
                        <div class="mt-10">
                            <x-splade-submit class="w-full">Save topic</x-splade-submit>
                        </div>
                    </section>
                    <section class="px-6 w-full border-r border-teal-400 flex flex-col gap-6">
                        <h1 class="text-xl mb-4">New Subject</h1>
                        <div class="h-full overflow-y-auto flex flex-col gap-6">
                            <div v-for="subject in form.newSubject" class="flex flex-col gap-6 ">
                                <x-splade-input v-model="subject.title" label="title" />
                                <x-splade-input v-model="subject.abbreviation" label="Abbreviation" />
                                <x-splade-select v-model="subject.years" label="Years">
                                    <option v-for="option in topic.yearsOptions" v-bind:key="option.id"
                                        v-bind:value="option.label">
                                        @{{ option.label }}
                                    </option>
                                </x-splade-select>
                            </div>
                        </div>
                        <x-splade-button v-if="form.newSubject.length == 0" type="call-to-action"
                            @click.prevent="topic.newSubject">
                            Add new Subject
                        </x-splade-button>
                        <x-splade-button v-if="form.newSubject.length > 0" type="call-to-action"
                            @click.prevent="topic.removeNewSubject">
                            Remove new Subject
                        </x-splade-button>
                    </section>
                    <section class="px-6 h-full w-full border-r border-teal-400 flex flex-col gap-6">
                        <h1 class="text-xl mb-4">New Fields</h1>
                        <div class="h-full overflow-y-auto flex flex-col gap-6">
                            <div v-for="(field, index) in form.newFields" class="flex flex-col gap-6"
                                v-bind:key="index">
                                <x-splade-input v-model="field.title" label="title" />
                                <x-splade-select v-model="field.years" label="Years">
                                    <option v-for="option in topic.yearsOptions" v-bind:key="option.id"
                                        v-bind:value="option.label">
                                        @{{ option.label }}
                                    </option>
                                </x-splade-select>
                                <x-splade-button type="call-to-action" @click.prevent="topic.removeField(index)">
                                    Remove this Field
                                </x-splade-button>
                            </div>
                        </div>
                        <x-splade-button type="call-to-action" @click.prevent="topic.newField">
                            Add new Field
                        </x-splade-button>
                    </section>
                    <section class="px-6 w-full flex flex-col gap-6">
                        <h1 class="text-xl mb-4">New Skills</h1>
                        <div class="h-full overflow-y-auto flex flex-col gap-6">

                        </div>
                        <x-splade-button type="call-to-action" @click.prevent="topic.newField">
                            Add new Skill
                        </x-splade-button>
                    </section>
                </div>
            </div>
        </topic>
    </x-splade-form>
</x-layouts.app>
