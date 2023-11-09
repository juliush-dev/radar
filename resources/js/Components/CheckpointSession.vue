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
            if (this.form.$all.clozes.length > 0) {
                this.activeTab = 'clozes';
            } else if(this.form.$all.flashCards.length > 0) {
                this.activeTab = 'flash cards';
            }
        },
        setActiveTab (tab) {
            this.activeTab = tab;
        },
        wrapTokensInText(textA, data) {
            const regex = /\[(.*?)\]/g;
            const textB = textA.replace(regex, (match, token) => {
                const wrappedToken = `<span class="bg-violet-500 px-1 rounded text-white">${token}</span>`;
                return wrappedToken;
            });
            return textB;
        },
    },

    render () {
        return this.$slots.default({
            form: this.form,
            newQASet: this.newQASet,
            removeQASet: this.removeQASet,
            activeTab: this.activeTab,
            setActiveTab: this.setActiveTab,
            wrapTokensInText: this.wrapTokensInText,
        });
    },
};
</script>
