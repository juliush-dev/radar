@php($years = $rq->years())
@php($fields = $rq->fields())
@php($subjects = $rq->subjects())
@php($skills = $rq->skills())
<topic v-slot="topic" :form="form">
    <div class="sticky right-0 overflow-x-auto top-0 z-10 flex bg-white gap-0 w-full flex-wrap shadow mb-4">
        <button class="px-6 py-4 cursor-pointer"
            v-bind:class=" topic.activeTab == 'topic' ? ' bg-pink-500 text-white' : 'text-slate-50 bg-slate-700'"
            @click.prevent="topic.setActiveTab('topic')">Topic</button>
        <button v-show="form.newSubject != null" class="px-6 py-4 cursor-pointer"
            v-bind:class=" topic.activeTab == 'subject' ? ' bg-pink-500 text-white' : 'text-slate-50 bg-slate-700'"
            @click.prevent="topic.setActiveTab('subject')">New Subject</button>
    </div>
    <section v-show="topic.activeTab == 'topic'"
        class="w-full flex flex-col bg-white border border-slate-200 dark:border-white p-8">
        <x-splade-input required name="title" label="Title" class="mb-6" />
        <x-splade-select required name="years" label="Years" :options="$years" option-value="id" option-label="title"
            placeholder="Choose or" class="mb-6" multiple />
        <div class="flex flex-col gap-4">
            <x-splade-select required v-if="form.newSubject == null" name="subject" label="Subject" :options="$subjects"
                option-value="id" option-label="title" placeholder="Choose or" />
            <x-splade-button v-if="form.newSubject == null" type="call-to-action" @click.prevent="topic.newSubject"
                class="w-fit ml-auto bg-amber-500 hover:bg-amber-600 text-white">
                Add new Subject
            </x-splade-button>
            <p v-if="form.newSubject != null"
                class="p-4 mb-6 border border-slate-50 bg-sky-200 flex gap-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                New subject added
            </p>
        </div>
        <x-splade-select name="fields" label="Fields" :options="$fields" option-value="id" option-label="title"
            placeholder="Choose or" multiple class="mb-4" />
        <x-splade-select name="skills" label="Skill" :options="$skills" option-value="id" option-label="title"
            placeholder="Choose or" multiple class="mb-4" />
        @if (!$hideLmsInput)
            <x-splade-file label="Learning materials" name="documents[]" filepond preview multiple />
        @endif
        <div class="flex justify-between my-6 gap-6">
            <x-splade-submit class="bg-fuchsia-500 hover:bg-fuchsia-600 shadow-md" :label="$actionLabel" />
            <Link href="{{ isset($topic) ? route('topics.show', $topic) : route('topics.index') }}"
                class=" whitespace-nowrap flex items-center justify-center w-fit px-4 rounded-none text-white bg-slate-400 shadow hover:bg-slate-500 hover:shadow-md align-middle">
            Cancel
            </Link>
        </div>
    </section>
    <section v-show="topic.activeTab == 'subject'"
        class="w-full flex flex-col bg-white border border-slate-200 dark:border-white p-8">
        <div class="flex flex-col gap-6">
            <div v-if="form.newSubject != null" class="flex flex-col gap-6 ">
                <x-splade-input required v-model="form.newSubject.title" label="title" />
                <x-splade-input required v-model="form.newSubject.abbreviation" label="Abbreviation" />
                <x-splade-select required v-model="form.newSubject.years" :options="$years" option-value="id"
                    option-label="title" label="Years" multiple />
            </div>
            <x-splade-button v-if="form.newSubject != null" type="call-to-action"
                @click.prevent="topic.removeNewSubject"
                class="w-fit ml-auto mb-4 bg-red-400 hover:bg-red-500 text-white">
                Remove this Subject
            </x-splade-button>
        </div>
    </section>
</topic>
