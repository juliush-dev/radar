<script>
export default {
    props: {
        form: Object,
    },
    data () {
        return {
            activeTab: 'clozes',
        }
    },
    methods: {
        newQASet (type, initialValue = {}) {
            this.form.$all[type].push(initialValue);
            if(type == 'clozes'){
                this.activeTab = 'clozes';
            }else if (type == 'flashCards') {
                this.activeTab = 'flash cards';
            }
        },
        removeQASet (type, index = null) {
            if (isNaN(index)) {
                this.form.$all[type] = [];
            } else {
                this.form.$all[type].splice(index, 1);
            }
            this.resetActiveTab();
        },
        resetActiveTab () {
            // if (this.form.$all.clozes.length > 0) {
            //     this.activeTab = 'clozes';
            // } else if(this.form.$all.flashCards.length > 0) {
            //     this.activeTab = 'flash cards';
            // }
        },
        setActiveTab (tab) {
            this.activeTab = tab;
        },
        async replaceTokensInText (textA) {
            // Define a regular expression pattern to match tokens surrounded by "-- --"
            const regex = /\[(.*?)\]/g;

            // Replace matched tokens with the specified HTML span element
            const preview = textA.replace(regex, (match, token) => {
                const emptySpan = `<span class="bg-violet-500 px-1 rounded">${'&nbsp;'.repeat(token.length)}</span>`;
                return emptySpan;
            });
            return preview.replace(/\n/g, '<br>');
        },
        async trackClozedWords(cloze){
            cloze.question = await this.replaceTokensInText(cloze.answer);
        },
        async wrapToken (event) {
            const inputText = event.target;
            if (event.key === '[') {
                const selectionStart = inputText.selectionStart;
                const selectionEnd = inputText.selectionEnd;
                const textValue = inputText.value;

                // Get the selected text
                const selectedText = textValue.substring(selectionStart, selectionEnd);

                // Check if the selected text is not empty and doesn't consist of only spaces
                if (selectedText.trim() !== "") {
                    if (selectedText.startsWith('[') && selectedText.endsWith(']')) {
                        // Remove the brackets
                        const updatedText = textValue.substring(0, selectionStart) + selectedText.substring(1, selectedText.length - 1) + textValue.substring(selectionEnd);
                        inputText.value = updatedText;
                        inputText.setSelectionRange(selectionStart, selectionEnd - 2); // Adjust the cursor position
                        inputText.dispatchEvent(new Event('input'));
                    } else {
                        // Wrap the selected text with square brackets
                        const updatedText = textValue.substring(0, selectionStart) + '[' + selectedText + ']' + textValue.substring(selectionEnd);
                        inputText.value = updatedText;
                        inputText.setSelectionRange(selectionStart, selectionEnd + 2); // Adjust the cursor position
                        inputText.dispatchEvent(new Event('input'));
                    }
                    event.preventDefault(); // Prevent the default '[' key action
                }
            }
        },
    },

    render () {
        return this.$slots.default({
            form: this.form,
            newQASet: this.newQASet,
            removeQASet: this.removeQASet,
            activeTab: this.activeTab,
            setActiveTab: this.setActiveTab,
            trackClozedWords: this.trackClozedWords,
            wrapToken: this.wrapToken,
        });
    },
};
</script>
