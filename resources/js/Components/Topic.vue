<script>
export default {
     props: {
        form: Object,
    },
    data() {
        return {
            activeTab: 'topic',
        }
    },
    methods: {
         newGroup () {
            this.form.$all.newGroup = '';
            console.log(this.form.$all);
            console.log(this.yearsOptions);
        },
        removeNewGroup () {
            this.form.$all.newGroup = null;
            console.log(this.form.$all);
        },
        newField () {
            this.form.$all.newFields.push({ title: '', code: '', years: []});
            this.activeTab = 'fields';
        },
        removeField (index = null) {
            if(isNaN(index)){
                this.form.$all.newFields = [];
            }else{
                this.form.$all.newFields.splice(index, 1);
            }
            this.resetActiveTab();
        },
         newSubject () {
            this.form.$all.newSubject = { title: 'New', abbreviation: '', years: [] };
            this.form.$all.subject = null;
            this.activeTab = 'subject';
        },
        removeNewSubject () {
            this.form.$all.newSubject = null;
            this.resetActiveTab();
        },
        newSkill () {
            this.form.$all.newSkills.push({ title: '', group: '', newGroup: '', years: [], fields: [] });
            this.activeTab = 'skills';
        },
        removeSkill (index = null) {
            if (isNaN(index)) {
                this.form.$all.newSkills = [];
            } else {
                this.form.$all.newSkills.splice(index, 1);
            }
            this.resetActiveTab();

        },
        resetActiveTab(){
            if(this.form.$all.newSkills.length > 0){
                this.activeTab = 'skills';
            }else if(this.form.$all.newFields.length > 0){
                this.activeTab = 'fields';
            }else if(this.form.$all.newSubject){
                this.activeTab = 'subject';
            }else{
                this.activeTab = 'topic';
            }
        },
        setActiveTab(tab){
            this.activeTab = tab;
        },
    },
    render () {
        return this.$slots.default({
            form: this.form,
            newSubject: this.newSubject,
            removeNewSubject: this.removeNewSubject,
            newField: this.newField,
            removeField: this.removeField,
            newSkill: this.newSkill,
            removeSkill: this.removeSkill,
            activeTab: this.activeTab,
            setActiveTab: this.setActiveTab,
        });
    },
};
</script>
