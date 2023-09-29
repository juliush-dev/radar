<x-layouts.app active-page="New Topic">
    @php($years = $rq->years())
    @php($fields = $rq->fields())
    @php($subjects = $rq->subjects())
    @php($skills = $rq->skills())
    @php($groups = $rq->groups())
    <x-splade-form :action="route('topics.store')" class="overflow-auto p-6 absolute top-0 left-0 right-0 bottom-0.5 pb-20"
        :default="[
            'newSubject' => null,
            'newFields' => [],
            'newSkills' => [],
            'learningMaterials' => [],
        ]">
        <topic v-slot="topic" :form="form">
            <div class="relative mx-auto w-1/2 flex flex-col h-full overflow-hidden">
                <div class="flex gap-6">
                    <x-layouts.navigation-link class="text-slate-800 mb-4 self-start underline underline-offset-2"
                        resource="topics" action="index" label="Back to the gallery"
                        icon="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </div>
                <div class="flex gap-0 border-b w-full shadow">
                    <button class="px-4 py-2 text-slate-500 cursor-pointer"
                        v-bind:class=" topic.activeTab == 'topic' && 'bg-slate-200 text-slate-900' "
                        @click.prevent="topic.setActiveTab('topic')">Topic</button>
                    <button v-show="form.newSubject != null" class="px-4 py-2 text-slate-500 cursor-pointer"
                        v-bind:class=" topic.activeTab == 'subject' && 'bg-slate-200 text-slate-900' "
                        @click.prevent="topic.setActiveTab('subject')">New Subject</button>
                    <button v-show="form.newFields.length > 0" class="px-4 py-2 text-slate-500 cursor-pointer"
                        v-bind:class=" topic.activeTab == 'fields' && 'bg-slate-200 text-slate-900' "
                        @click.prevent="topic.setActiveTab('fields')">New Fields (@{{ form.newFields.length }}) </button>
                    <button v-show="form.newSkills.length > 0" class="px-4 py-2 text-slate-500 cursor-pointer"
                        v-bind:class=" topic.activeTab == 'skills' && 'bg-slate-200 text-slate-900' "
                        @click.prevent="topic.setActiveTab('skills')">New Skills (@{{ form.newSkills.length }})</button>
                </div>
                <section v-show="topic.activeTab == 'topic'"
                    class="relative py-6 pr-6 overflow-y-auto w-full h-full flex flex-col">
                    <x-splade-textarea required name="title" label="Title" class="mb-6" />
                    <x-splade-select name="years" label="Years" :options="$years" option-value="id"
                        option-label="title" placeholder="Choose or" class="mb-6" multiple />
                    <div class="flex flex-col gap-4">
                        <x-splade-select required v-if="form.newSubject == null" name="subject" label="Subject"
                            :options="$subjects" option-value="id" option-label="title" placeholder="Choose or" />
                        <x-splade-button v-if="form.newSubject == null" type="call-to-action"
                            @click.prevent="topic.newSubject"
                            class="w-fit ml-auto bg-amber-500 hover:bg-amber-600 text-white">
                            Add new Subject
                        </x-splade-button>
                        <p v-if="form.newSubject != null"
                            class="p-4 mb-6 border border-slate-50 rounded-md bg-sky-200 flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            New subject added
                        </p>
                    </div>
                    <div class="flex flex-col gap-4">
                        <x-splade-select name="fields" label="Fields" :options="$fields" option-value="id"
                            option-label="title" placeholder="Choose or" multiple />
                        <p v-if="form.newFields.length > 0"
                            class="border border-slate-50 rounded-md bg-sky-200 p-4 flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>

                            <span>
                                (@{{ form.newFields.length }})
                                fields added
                            </span>
                        </p>
                        <x-splade-button class="w-fit ml-auto bg-amber-500 hover:bg-amber-600 text-white"
                            type="call-to-action" @click.prevent="topic.newField">
                            @{{ form.newFields.length == 0 ? 'Add a new Field' : 'Add another field' }}
                        </x-splade-button>
                    </div>
                    <div class="flex flex-col gap-2">
                        <x-splade-select name="skills" label="Skill" :options="$skills" option-value="id"
                            option-label="title" placeholder="Choose or" multiple />
                        <p v-if="form.newSkills.length > 0"
                            class="border border-slate-50 rounded-md bg-sky-200 p-4 flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            <span>
                                (@{{ form.newSkills.length }}) skills added
                            </span>
                        </p>
                        <x-splade-button class="w-fit ml-auto bg-amber-500 hover:bg-amber-600 text-white"
                            type="call-to-action" @click.prevent="topic.newSkill">
                            @{{ form.newSkills.length == 0 ? 'Add new skill' : 'Add another skill' }}
                        </x-splade-button>
                    </div>
                    <x-splade-file label="Learning materials" name="documents[]" filepond preview multiple />
                    <div class="flex justify-between my-6">
                        <x-splade-button type="call-to-action"
                            class="w-fit text-center text-white bg-cyan-500 hover:bg-cyan-600">
                            Save topic
                        </x-splade-button>
                        <Link href="{{ route('topics.index') }}"
                            class="flex items-center justify-center w-fit px-4 rounded-md text-white bg-slate-400 shadow hover:bg-slate-500 hover:shadow-md align-middle">
                        Cancel creation
                        </Link>
                    </div>
                </section>
                <section v-show="topic.activeTab == 'subject'"
                    class="relative py-6 pr-6 overflow-y-auto w-full h-full flex flex-col">
                    <div class="h-full overflow-y-auto flex flex-col gap-6">
                        <div v-if="form.newSubject != null" class="flex flex-col gap-6 ">
                            <x-splade-input v-model="form.newSubject.title" label="title" />
                            <x-splade-input v-model="form.newSubject.abbreviation" label="Abbreviation" />
                            <x-splade-select v-model="form.newSubject.years" :options="$years" option-value="id"
                                option-label="title" label="Years" multiple />
                        </div>
                        <x-splade-button v-if="form.newSubject != null" type="call-to-action"
                            @click.prevent="topic.removeNewSubject"
                            class="w-fit ml-auto mb-4 bg-pink-500 hover:bg-pink-600 text-white">
                            Remove this Subject
                        </x-splade-button>
                    </div>
                </section>
                <section v-show="topic.activeTab == 'fields'"
                    class="relative py-6 pr-6 overflow-y-auto w-full h-full flex flex-col">
                    <x-splade-button v-if="form.newFields.length > 0" type="call-to-action"
                        @click.prevent="topic.removeField"
                        class="ml-auto mb-4 w-fit mr-6 bg-pink-500 hover:bg-pink-600 text-white">
                        Remove all new fields
                    </x-splade-button>
                    <div class="relative h-full overflow-y-auto flex flex-col gap-6 pr-6">
                        <div v-for="(field, index) in form.newFields" class="flex flex-col gap-6" v-bind:key="index">
                            <x-splade-input v-model="field.title" label="title" />
                            <x-splade-input v-model="field.code" label="code" />
                            <x-splade-select v-model="field.years" :options="$years" option-value="id"
                                option-label="title" label="Years" multiple />
                            <x-splade-button class="w-fit ml-auto bg-pink-500 hover:bg-pink-600 text-white"
                                type="call-to-action" @click.prevent="topic.removeField(index)">
                                Remove this Field
                            </x-splade-button>
                        </div>
                        <x-splade-button class="w-fit mb-4 bg-amber-500 hover:bg-amber-600 text-white"
                            type="call-to-action" @click.prevent="topic.newField">
                            @{{ form.newFields.length == 0 ? 'Add new field' : 'Add another field' }}
                        </x-splade-button>
                    </div>
                </section>
                <section v-show="topic.activeTab == 'skills'"
                    class="relative py-6 pr-6 overflow-y-auto w-full h-full flex flex-col">
                    <x-splade-button v-if="form.newSkills.length > 0" type="call-to-action"
                        @click.prevent="topic.removeSkill"
                        class="w-fit ml-auto mb-4 mr-6 bg-pink-500 hover:bg-pink-600 text-white">
                        Remove all new skills
                    </x-splade-button>
                    <div class="h-full overflow-y-auto flex flex-col gap-6 pr-6">
                        <div v-for="(skill, index) in form.newSkills" class="flex flex-col gap-6" v-bind:key="index">
                            <x-splade-textarea v-model="skill.title" label="title" />
                            <x-splade-textarea v-model="skill.newGroup" label="New group" />
                            <x-splade-select v-model="skill.years" :options="$years" option-value="id"
                                option-label="title" label="Years" multiple />
                            <x-splade-select v-model="skill.fields" :options="$fields" option-value="id"
                                option-label="title" label="Fields" multiple />
                            <x-splade-button class="w-fit ml-auto bg-pink-500 hover:bg-pink-600 text-white"
                                type="call-to-action" @click.prevent="topic.removeSkill(index)">
                                Remove this skill
                            </x-splade-button>
                        </div>
                        <x-splade-button class="w-fit mb-4 bg-amber-500 hover:bg-amber-600 text-white"
                            type="call-to-action" @click.prevent="topic.newSkill">
                            @{{ form.newSkills.length == 0 ? 'Add new skill' : 'Add another skill' }}
                        </x-splade-button>
                    </div>
                </section>
            </div>
        </topic>
    </x-splade-form>
</x-layouts.app>
