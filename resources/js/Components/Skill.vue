<script>
export default {
    props: {
        form: Object,
    },
    data () {
        return {
            activeTab: 'skill',
        }
    },
    methods: {
        newField () {
            this.form.$all.newFields.push({ title: '', code: '', years: [] });
            this.activeTab = 'fields';
        },
        removeField (index = null) {
            if (isNaN(index)) {
                this.form.$all.newFields = [];
            } else {
                this.form.$all.newFields.splice(index, 1);
            }
            this.resetActiveTab();
        },
        newGroup () {
            this.form.$all.newGroup = '';
            this.form.$all.group = null;
            this.activeTab = 'group';
        },
        removeNewGroup () {
            this.form.$all.newGroup = null;
            this.resetActiveTab();
        },
        resetActiveTab () {
            if (this.form.$all.newFields.length > 0) {
                this.activeTab = 'fields';
            } else if (this.form.$all.newGroup) {
                this.activeTab = 'group';
            } else {
                this.activeTab = 'skill';
            }
        },
        setActiveTab (tab) {
            this.activeTab = tab;
        },
    },
    render () {
        return this.$slots.default({
            form: this.form,
            newField: this.newField,
            removeField: this.removeField,
            activeTab: this.activeTab,
            setActiveTab: this.setActiveTab,
        });
    },
};
</script>
