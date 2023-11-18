<script>
export default {
    emits: ['newKnowledge'],
    props: {
        initialValue: Object,
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
        },
        cube: Object,
    },
    data () {
        return {
            knowledge: this.initialValue,
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
                return Math.floor(nextIndex / this.cubeFacesCount)
            })(),
            touched: false,
            bridgeCrossedSuccessfully: this.userGotItRight,
            knowledgeRevealed: false
        }
    },
    methods: {
        replaceTokensInText (textA, hideBridgeToken = true) {
            // Define a regular expression pattern to match tokens surrounded by "-- --"
            var regex = /\[(.*?)\]/g;
            // Replace matched tokens with the specified HTML span element
            var preview = textA.replace(regex, (match, token) => {
                const emptySpan = `<span class="bg-violet-500 text-white px-1 rounded">${hideBridgeToken ? '&nbsp;'.repeat(token.length) : token}</span>`;
                return emptySpan;
            });
            regex = /\*(.*?)\*/g;
            // Replace matched tokens with the specified HTML span element
            preview = preview.replace(regex, (match, token) => {
                const emptySpan = `<span class="bg-yellow-400/30 text-black dark:text-slate-300 px-1 rounded dark:bg-slate-800">${token}</span>`;
                return emptySpan;
            });
            return preview.replace(/\n/g, '<br>');
        },
        wrapToken (event) {
            const inputText = event.target;
            var wrapperStart = "[";
            var wrapperEnd = "]";
            if (event.key === '[' || event.key === '*') {
                if (event.key === '*') {
                    wrapperStart = wrapperEnd = "*";
                }
                const selectionStart = inputText.selectionStart;
                const selectionEnd = inputText.selectionEnd;
                const textValue = inputText.value;

                // Get the selected text
                const selectedText = textValue.substring(selectionStart, selectionEnd);

                // Check if the selected text is not empty and doesn't consist of only spaces
                if (selectedText.trim() !== "") {
                    if (selectedText.startsWith('[') && selectedText.endsWith(']') || selectedText.startsWith('*') && selectedText.endsWith('*')) {
                        // Remove the brackets
                        const updatedText = textValue.substring(0, selectionStart) + selectedText.substring(1, selectedText.length - 1) + textValue.substring(selectionEnd);
                        inputText.value = updatedText;
                        inputText.setSelectionRange(selectionStart, selectionEnd - 2); // Adjust the cursor position
                        inputText.dispatchEvent(new Event('input'));
                    } else {
                        // Wrap the selected text with square brackets

                        const updatedText = textValue.substring(0, selectionStart) + wrapperStart + selectedText + wrapperEnd + textValue.substring(selectionEnd);
                        inputText.value = updatedText;
                        inputText.setSelectionRange(selectionStart, selectionEnd + 2); // Adjust the cursor position
                        inputText.dispatchEvent(new Event('input'));
                    }
                    event.preventDefault(); // Prevent the default '[' key action
                }
            }
        },
        touch () {
            this.touched = true;
        },
        reveal () {
            this.knowledgeRevealed = true;
        },
        setBridgeCrossedSuccessfully (value) {
            this.bridgeCrossedSuccessfully = value;
        },
        focus (ev) {
            alert(ev.target);
        }
    },
    computed: {
        coordonates () {
            const size = this.cube?.onPhone ? 160 : 250;
            return {
                'transform': (() => {
                    if (this.face == 'front') {
                        return `rotateY(0deg) translateZ(${size}px)`;
                    }
                    if (this.face == 'right') {
                        return `rotateY(90deg) translateZ(${size}px)`;
                    }
                    if (this.face == 'back') {
                        return `rotateY(180deg) translateZ(${size}px)`;
                    }
                    if (this.face == 'left') {
                        return `rotateY(-90deg) translateZ(${size}px)`;
                    }
                    if (this.face == 'top') {
                        return `rotateX(90deg) translateZ(${size}px)`;
                    }
                    if (this.face == 'bottom') {
                        return `rotateX(-90deg) translateZ(${size}px)`;
                    }
                })(),
            }
        },
        nextFace () {
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
        style () {
            return {
                'drop-shadow-lg shadow-black/5 dark:shadow-slate-600/50':
                    this.activeIndex == this.index,

                'bg-red-400 text-white dark:bg-red-500 dark:text-slate-100':
                    this.bridgeCrossedSuccessfully === false,

                'bg-green-400 text-white dark:bg-green-500 dark:text-slate-100':
                    this.bridgeCrossedSuccessfully,

                'bg-slate-100 dark:bg-slate-800 dark:text-slate-400':
                    this.knowledgeRevealed && this.bridgeCrossedSuccessfully == undefined,

                'bg-blue-400 text-white dark:bg-blue-500 dark:text-slate-100':
                    this.context == 'review' && this.bridgeCrossedSuccessfully == undefined && this.knowledge.information.length > 0,

                'bg-white dark:bg-slate-700 dark:text-slate-300':
                    !(this.context == 'test') && (this.context == 'preview') || this.context == 'test' && !this.knowledgeRevealed,

                'bg-white/80 dark:bg-slate-700/80 dark:text-slate-100':
                    this.knowledge.information.length == 0,
            }
        },
        bridge () {
            const bridge = this.replaceTokensInText(this.knowledge.information);
            return bridge;
        }

    },

    mounted () {
        if (this.knowledge.bridge_crossed === false || this.knowledge.bridge_crossed === true) {
            this.bridgeCrossedSuccessfully = this.knowledge.bridge_crossed;
        }
        if (this.cube) {
            this.cube.addLayer({ 'face': this.face, 'deep': this.deep });
        }
        if (this.knowledge.information.length == 0) {
            // the targeted element should be in the dom for this to work
            // if it is hidden, this will not work
            const textareaElement = this.$el.parentElement.querySelector('textarea');
            if (textareaElement) {
                textareaElement.focus();
                textareaElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    },

    render () {
        return this.$slots.default({
            knowledge: this.knowledge,
            wrapToken: this.wrapToken,
            nextFace: this.nextFace,
            index: this.index,
            coordonates: this.coordonates,
            deep: this.deep,
            nextDeep: this.nextDeep,
            previousDeep: this.previousDeep,
            bridgeCrossedSuccessfully: this.bridgeCrossedSuccessfully,
            setBridgeCrossedSuccessfully: this.setBridgeCrossedSuccessfully,
            reveal: this.reveal,
            knowledgeRevealed: this.knowledgeRevealed,
            style: this.style,
            context: this.context,
            cube: this.cube,
            replaceTokensInText: this.replaceTokensInText,
            bridge: this.bridge,
            focus: this.focus,
        });
    },
};
</script>
