{{--
    Host sind alle mit einem Netzwerk verbundenen Computer, die direkt an die Netzwerkkommunikation beteiligt sind.
--}}
<div>
    <div v-for="(cloze, index) in checkpoint.form.clozes" class="rounded border p-6 mb-8 shadow-md">
        <span v-text="index + 1"
            class="font-medium rounded-full border-4 h-8 w-8 flex items-center justify-center mb-3 border-slate-500"></span>
        <h3 v-text="cloze.title" class="mb-6 text-xl font-medium"></h3>
        <x-splade-input v-model="cloze.title" label="Title" class="mb-6" placeholder="Was ist ein Host?" />
        <x-splade-textarea required v-model="cloze.answer" label="Cloze text" class="mb-6"
            placeholder="Host sind alle mit einem [Netzwerk] verbundenen Computer, die direkt an die [Netzwerkkommunikation] beteiligt sind."
            @input="checkpoint.trackClozedWords(cloze)" @keydown="checkpoint.wrapToken" />
        <div v-html="cloze.question" class="my-6 border-l-4 border-violet-500 pl-2"></div>
        <div class="flex justify-between">
            <x-splade-checkbox v-model="cloze.is_assisted_cloze" value="1" label="Assited" />
            <x-splade-button type="call-to-action" @click.prevent="checkpoint.removeQASet('clozes', index)"
                class="w-fit ml-auto mb-4 bg-red-400 hover:bg-red-500 text-white">
                Remove this cloze
            </x-splade-button>
        </div>
    </div>
    <div class="flex flex-col gap-4 mt-10">
        <x-splade-button type="call-to-action"
            @click.prevent="checkpoint.newQASet('clozes', {title: '', answer:'', question:'', assisted: false})"
            class="w-fit bg-amber-500 hover:bg-amber-600 text-white">
            Add new cloze
        </x-splade-button>
    </div>
</div>
