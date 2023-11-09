{{--
    Host sind alle mit einem Netzwerk verbundenen Computer, die direkt an die Netzwerkkommunikation beteiligt sind.
--}}
<div>
    <div v-for="(card, index) in checkpoint.form.flashCards" class="rounded border p-6 mb-8 shadow-md">
        <span v-text="index + 1"
            class="font-medium rounded-full border-4 h-8 w-8 flex items-center justify-center mb-3 border-slate-500"></span>
        <h3 v-text="card.title" class="mb-6 text-xl font-medium"></h3>
        <x-splade-input v-model="card.title" label="Title" class="mb-6"
            placeholder="Manche Netwerkomponenten werden Host genannt." />
        <x-splade-textarea required v-model="card.question" label="Question" class="mb-6"
            placeholder="Was ist ein Host?" />
        <x-splade-textarea required v-model="card.answer" label="Answer"
            placeholder="Host sind alle mit einem Netzwerk verbundenen Computer, die direkt an die Netzwerkkommunition beteiligt sind."
            class="mb-6" />
        <x-splade-wysiwyg v-model="card.answer_in_place_explanation" label="In place explanation of answer"
            class="mb-4 prose jodit-wrapper overflow-hidden" placeholder="The sum of ... is calculated by adding ..." />
        <x-splade-input v-model="card.answer_explanation_redirect" label="Explanation redirect" class="mb-6"
            placeholder="https://moodle-hnbk.de/pluginfile.php/138211/mod_resource/content/1/%C3%9Cbung%20Grundbegriffe%20Datenbanken.pdf" />
        <div class="flex justify-between">
            <x-splade-button type="call-to-action" @click.prevent="checkpoint.removeQASet('flashCards', index)"
                class="w-fit ml-auto mb-4 bg-red-400 hover:bg-red-500 text-white">
                Remove this card
            </x-splade-button>
        </div>
    </div>
    <div class="flex flex-col gap-4 mt-10">
        <x-splade-button type="call-to-action"
            @click.prevent="checkpoint.newQASet('flashCards', {title: '', answer:'', question:'', answer_in_place_explanation: '', answer_explanation_redirect: ''})"
            class="w-fit bg-amber-500 hover:bg-amber-600 text-white">
            Add new card
        </x-splade-button>
    </div>
</div>
