<script>
export default {

    props: {
        initialContent: Object,
        index: Number,
        activeIndex: Number,
        cubeFacesCount: {
            type: Number,
            default: 6
        },
        userGotItRight: {
            type: Boolean,
            default: undefined
        },
        context: {
            type: String,
            default: 'preview'
        }
    },
    data() {
        return {
            content: this.initialContent,
            face: (
                () => {
                    if (this.index == 0 || (this.index - 0) % this.cubeFacesCount == 0) {
                        return 'front';
                    }
                    if (this.index == 1 || (this.index - 1) % this.cubeFacesCount == 0) {
                        return 'right';
                    }
                    if (this.index == 2 || (this.index - 2) % this.cubeFacesCount == 0) {
                        return 'back';
                    }
                    if (this.index == 3 || (this.index - 3) % this.cubeFacesCount == 0) {
                        return 'left';
                    }
                    if (this.index == 4 || (this.index - 4) % this.cubeFacesCount == 0) {
                        return 'top';
                    }
                    if (this.index == 5 || (this.index - 5) % this.cubeFacesCount == 0) {
                        return 'bottom';
                    }
                }
            )(),
            deep: Math.floor(this.index / this.cubeFacesCount),
            previousDeep: (() => {
                let previousIndex = this.index - 1;
                return Math.floor(previousIndex / this.cubeFacesCount)
            })(),
            nextDeep: (() => {
                let nextIndex = this.index + 1;
                return Math.floor( nextIndex / this.cubeFacesCount)
            })(),
            touched: false,
            answeredCorrectly: this.userGotItRight,
            answerRevealed: false
        }
    },
    methods: {
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
        async trackClozedWords () {
            this.content.question = await this.replaceTokensInText(this.content.answer);
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
        touch(){
            this.touched = true;
        },
        reveal(){
            this.answerRevealed = true;
        },
        setAnsweredCorrectly (value) {
            this.answeredCorrectly = value;
        }
    },
    computed: {
        coordonates () {
            return {
                'transform': (() => {
                    if (this.face == 'front') {
                        return 'rotateY(0deg) translateZ(191px)';
                    }
                    if (this.face == 'right') {
                        return 'rotateY(90deg) translateZ(191px)';
                    }
                    if (this.face == 'back') {
                        return 'rotateY(180deg) translateZ(191px)';
                    }
                    if (this.face == 'left') {
                        return 'rotateY(-90deg) translateZ(191px)';
                    }
                    if (this.face == 'top') {
                        return 'rotateX(90deg) translateZ(191px)';
                    }
                    if (this.face == 'bottom') {
                        return 'rotateX(-90deg) translateZ(191px)';
                    }
                })(),
            }
        },
        nextFace() {
            if (this.face == 'front') {
                return 'right';
            }
            if (this.face == 'right') {
                return 'back';
            }
            if (this.face == 'back') {
                return 'left';
            }
            if (this.face == 'left') {
                return 'top';
            }
            if (this.face == 'top') {
                return 'bottom';
            }
            if (this.face == 'bottom') {
                return 'front';
            }
        },
        style(){
            return {
                'drop-shadow-lg shadow-black/5 dark:shadow-slate-600/50':
                    this.activeIndex == this.index,

                'bg-red-400 text-white dark:bg-red-500 dark:text-slate-100':
                    this.answeredCorrectly === false,

                'bg-green-400 text-white dark:bg-green-500 dark:text-slate-100':
                    this.answeredCorrectly,

                'bg-slate-100 dark:bg-slate-800 dark:text-slate-400':
                    this.answerRevealed && this.answeredCorrectly == undefined,

                'bg-blue-400 text-white dark:bg-blue-500 dark:text-slate-100':
                    this.context == 'review' && this.answeredCorrectly == undefined && this.content.answer.length >0,

                'bg-white dark:bg-slate-700 dark:text-slate-300':
                    !(this.context == 'test') &&  (this.context == 'preview') || this.context == 'test' && !this.answerRevealed,

                'bg-white/80 dark:bg-black/80 dark:text-slate-100':
                    this.content.answer.length == 0,
            }
        },
    },

    created() {
        // console.log();
        // console.log('-----------');
        // console.log('Content:');
        // console.log(this.content);
        // console.log(`Context: ${this.context}`);
        // console.log(`Index: ${this.index}`);
        // console.log(`Deep: ${this.deep}`);
        // console.log(`NextDeep: ${this.nextDeep}`);
        // console.log(`PrevDeep: ${this.previousDeep}`);
        // console.log(`Face: ${this.face}`);
        // console.log(`nextFace: ${this.nextFace}`);
        // // console.log(`prevFace: ${this.previousFace}`);
        // console.log('-----------');
        // console.log();
        if(this.content && this.content.is_cloze){
            this.$watch('content.answer', () => {
                this.trackClozedWords();
            });
       }
    },
    mounted () {
         if(this.content.answered_correctly === false || this.content.answered_correctly === true){
            this.answeredCorrectly = this.content.answered_correctly;
         }
    },
    updated() {
        // console.log('----------------------');
        // console.log(this.index);
        // console.log(`revealed: ${this.answerRevealed}`);
        // console.log(`correctly: ${this.answeredCorrectly}`);
        // console.log('----------------------');
        // console.log();
    },
    render () {
        return this.$slots.default({
            content: this.content,
            wrapToken: this.wrapToken,
            nextFace: this.nextFace,
            index: this.index,
            coordonates: this.coordonates,
            deep: this.deep,
            nextDeep: this.nextDeep,
            previousDeep: this.previousDeep,
            answeredCorrectly: this.answeredCorrectly,
            setAnsweredCorrectly: this.setAnsweredCorrectly,
            reveal: this.reveal,
            answerRevealed: this.answerRevealed,
            style: this.style,
            context: this.context,
        });
    },
};
</script>
