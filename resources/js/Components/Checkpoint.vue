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
        addKnowledgeCube () {
            this.form.$all.knowledgeCubes.push({ subject: '', knowledge: [] });
        },
        removeKnowledgeCube ( index = null) {
            if (isNaN(index) || index < 0 || index >= this.form.$all.knowledgeCubes.length) {
                console.error("Invalid index or index out of bounds");
                return;
            }
            var temp = this.form.$all.knowledgeCubes;
            this.form.$all.knowledgeCubes = [];
            this.$nextTick(() => {
                this.form.$all.knowledgeCubes = temp.filter((e, i) => i != index);
                temp = null;
            });
        },
    },

    render () {
        return this.$slots.default({
            form: this.form,
            addKnowledgeCube: this.addKnowledgeCube,
            removeKnowledgeCube: this.removeKnowledgeCube,
        });
    },
};
</script>
