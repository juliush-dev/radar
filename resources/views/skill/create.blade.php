<x-layouts.app>
    <x-layouts.contributions label="Creating new skill..."
        action-icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
        <div class="h-full overflow-auto p-6">
            @php($yearsOptions = $ent->asOptions('\App\Enums\Year'))
            @php($fieldsOptions = $qrt->fieldsAsOptions())
            @php($subjectsOptions = $qrt->subjectsAsOptions())
            <x-splade-form :action="route('skills.store')" class="mx-auto w-1/2 flex flex-col gap-6" :default="[
                'newFields' => [],
                'newGroup' => null,
                'newTopics' => [],
            ]">
                <skill v-slot="skill" :form="form" :years-options="@js($yearsOptions)"
                    :fields-options="@js($fieldsOptions)" :subjects-options="@js($subjectsOptions)">
                    <x-splade-textarea name="title" label="Title" />
                    <x-splade-select name="group" label="Group" :options="$qrt->groupsAsOptions()" option-label="label"
                        option-value="id" />
                    <div v-if="form.newGroup != null">
                        <div class="flex gap-4 items-end">
                            <x-splade-textarea name="newGroup" label="New group" class="grow" />
                            <x-splade-button type="call-to-action" @click.prevent="skill.removeNewGroup">Remove this
                                group</x-splade-button>
                        </div>
                    </div>
                    <div v-if="form.newGroup == null">
                        <x-splade-button type="call-to-action" @click.prevent="skill.newGroup">New
                            Group</x-splade-button>
                    </div>
                    <x-splade-select name="years" label="Years" :options="$yearsOptions" option-label="label"
                        option-value="id" multiple />
                    <h4 class="text-lg">Skill fields</h4>
                    <x-splade-select name="fields" label="From actual fields" :options="$fieldsOptions" option-label="label"
                        option-value="id" multiple />
                    <label>New fields</label>
                    <div v-for="(field, index) in form.newFields">
                        <div class="flex gap-4 items-end">
                            <div class="rounded-md flex flex-col gap-6 p-6 bg-slate-100 shadow-sm grow">
                                <x-splade-textarea v-model="field.title" @change="console.log(field)" label="New Field"
                                    class="grow" />
                                <div class="flex flex-col gap-2">
                                    <label>Years</label>
                                    <select v-model="field.years" class="grow rounded-md" multiple>
                                        <option v-for="(option, index) in form.years" v-bind:key="index"
                                            v-bind:value="index"> @{{ skill.yearLabel(option) }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <x-splade-button type="call-to-action" @click.prevent="skill.removeNewField(index)">Remove
                                this
                                field</x-splade-button>
                        </div>
                    </div>
                    <x-splade-button type="call-to-action" @click.prevent="skill.newField">New
                        Field</x-splade-button>
                    <h2 class="text-2xl">Topics</h2>
                    <div v-for="(topic, index) in form.newTopics">
                        <div class="rounded-md flex flex-col gap-6 p-6 bg-slate-100 shadow-sm grow">
                            <h4 class="text-xl">New Topic</h4>
                            <x-splade-textarea v-model="topic.title" label="Title" class="grow" />
                            <h3 class="text-lg">Topic fields</h3>
                            <x-splade-select v-model="topic.fields" label="From actual fields" options="fields"
                                option-label="label" option-value="id" multiple />
                            <div class="flex flex-col gap-2">
                                <label>From new fields</label>
                                <select v-model="topic.fields" class="grow rounded-md" multiple>
                                    <option v-for="(option, index) in form.newFields" v-bind:key="index"
                                        v-bind:value="index">
                                        @{{ option.title }}
                                    </option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label>Years</label>
                                <select v-model="topic.years" class="grow rounded-md" multiple>
                                    <option v-for="(option, index) in form.years" v-bind:key="index"
                                        v-bind:value="index"> @{{ skill.yearLabel(option) }}
                                    </option>
                                </select>
                            </div>

                            <h3 class="text-lg">Topic subject</h3>
                            <x-splade-select v-model="topic.subject" label="From actual subjects" :options="$subjectsOptions"
                                option-label="label" option-value="id" />
                            <div
                                v-for="(newSubject, indexSubject) in Array.isArray(topic.subject) ? topic.subject : []">
                                <div class="grow flex flex-col gap-4 p-6 bg-slate-200 rounded-md">
                                    <h4 class="text-lg">New Subject</h4>
                                    <x-splade-textarea v-model="topic.subject[0].title" label="Title" class="grow" />
                                    <x-splade-input v-model="topic.subject[0].abbreviation" label="Abbreviation"
                                        class="grow" />
                                    <div class="flex flex-col gap-2">
                                        <label>Years</label>
                                        <select v-model="topic.subject[0].years" class="grow rounded-md" multiple>
                                            <option v-for="(option, indexSubject) in form.years"
                                                v-bind:key="indexSubject" v-bind:value="indexSubject">
                                                @{{ skill.yearLabel(option) }}
                                            </option>
                                        </select>
                                    </div>
                                    <x-splade-button type="call-to-action"
                                        @click.prevent="topic.subject = null; skill.removeNewSubject(index)">Remove this
                                        subject</x-splade-button>
                                </div>
                            </div>
                            <div v-if="topic.subject == null">
                                <x-splade-button type="call-to-action" @click.prevent="skill.newSubject(index);">New
                                    Subject</x-splade-button>
                            </div>
                            <div class="flex flex-col gap-2">
                                <x-splade-file name="`documents_topic_${index}`" label="Learning materials"
                                    filepond="{name: `topic_${index}`}" multiple />
                            </div>
                            <x-splade-button type="call-to-action" @click.prevent="skill.removeNewTopic(index)">Remove
                                this topic</x-splade-button>
                        </div>
                    </div>
                    <x-splade-button type="call-to-action" @click.prevent="skill.newTopic">Add new
                        Topic</x-splade-button>
                </skill>
                <div class="mt-10">
                    <x-splade-submit class="w-full">Save</x-splade-submit>
                </div>
            </x-splade-form>
        </div>
    </x-layouts.contributions>
</x-layouts.app>
