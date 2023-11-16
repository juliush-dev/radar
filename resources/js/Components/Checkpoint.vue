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
        addQuestionsCube () {
            this.form.$all.questionsCubes.push({ subject: '', questions: [] });
        },
        removeQuestionsCube ( index = null) {
            if (isNaN(index) || index < 0 || index >= this.form.$all.questionsCubes.length) {
                console.error("Invalid index or index out of bounds");
                return;
            }
            var temp = this.form.$all.questionsCubes;
            this.form.$all.questionsCubes = [];
            this.$nextTick(() => {
                this.form.$all.questionsCubes = temp.filter((e, i) => i != index);
                temp = null;
            });
        },
    },

    render () {
        return this.$slots.default({
            form: this.form,
            addQuestionsCube: this.addQuestionsCube,
            removeQuestionsCube: this.removeQuestionsCube,
        });
    },
};
</script>
