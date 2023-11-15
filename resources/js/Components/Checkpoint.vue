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
            if (isNaN(index)) {
                this.form.$all.questionsCubes = [];
            } else {
                this.form.$all.questionsCubes.splice(index, 1);
            }
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
