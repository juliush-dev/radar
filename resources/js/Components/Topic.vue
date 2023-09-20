<script>
export default {
     props: {
        form: Object,
        yearsOptions: Object,
        fieldsOptions: Object,
        subjectsOptions: Object,
    },

    beforeCreate(){
        this.form.name = 'Julius';
        console.log(this.form.yearsOptions);
    },
    activated (){
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
            this.form.$all.newFields.push({ title: '', years: []});
            console.log(this.form.$all);
        },
        removeField (index) {
            this.form.$all.newFields.splice(index, 1);
            console.log(this.form.$all);
        },
         newSubject () {
            this.form.$all.newSubject.push({ title: '', abbreviation: '', years: [] });
        },
        removeNewSubject () {
            this.form.$all.newSubject.splice(0, 1);
        },
        yearLabel (yearId) {
            for (const yearIndex in this.yearsOptions) {
                if (this.yearsOptions[yearIndex].id == yearId) {
                    return this.yearsOptions[yearIndex].label;
                }
            }
            console.log(this.form.$all);
        },
    },
    render () {
        return this.$slots.default({
            form: this.form,
            newGroup: this.newGroup,
            newSubject: this.newSubject,
            removeNewGroup: this.removeNewGroup,
            newField: this.newField,
            removeField: this.removeField,
            removeNewSubject: this.removeNewSubject,
            yearLabel: this.yearLabel,
            yearsOptions: this.yearsOptions,
            fieldsOptions: this.fieldsOptions,
            subjectsOptions: this.subjectsOptions,
        });
    },
};
</script>
