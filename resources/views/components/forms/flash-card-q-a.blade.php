<x-splade-textarea rows="5" required v-model="card.content.question" label="Question or exercise"
    class="mb-6 first-letter:uppercase" placeholder="Was ist ein Host?" />
<x-splade-textarea required v-model="card.content.answer" label="Answer"
    placeholder="Host sind alle mit einem Netzwerk verbundenen Computer, die direkt an die Netzwerkkommunition beteiligt sind."
    class="mb-6" />
<x-splade-wysiwyg v-model="card.content.answer_in_place_explanation" label="In place explanation of answer"
    class="mb-4 prose jodit-wrapper overflow-hidden" placeholder="The sum of ... is calculated by adding ..." />
<x-splade-input v-model="card.content.answer_explanation_redirect" label="Explanation redirect" class="mb-6"
    placeholder="https://moodle-hnbk.de/pluginfile.php/138211/mod_resource/content/1/%C3%9Cbung%20Grundbegriffe%20Datenbanken.pdf" />
