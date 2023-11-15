<x-splade-checkbox v-model="card.content.is_assisted_cloze" value="1" label="Assited" />
<x-splade-textarea rows="5" required v-model="card.content.answer" label="Cloze" class="my-6 first-letter:uppercase"
    placeholder="Host sind alle mit einem [Netzwerk] verbundenen Computer, die direkt an die [Netzwerkkommunikation] beteiligt sind."
    @keydown="card.wrapToken" />
<div class="mb-6">
    <label>Question <span class="text-sm font-mono">(automatically generated)</span></label>
    <div v-html="card.content.question" class="my-6"></div>
</div>
