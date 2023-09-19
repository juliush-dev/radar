<script>
export default {
     props: {
        form: Object,
        yearsOptions: Object,
        fieldsOptions: Object,
        subjectsOptions: Object,
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
            // if(this.form.$all.fields == null){
            //     this.form.$all.fields = [];
            // }
            this.form.$all.newFields.push({ title: '', years: []});
            console.log(this.form.$all);
        },
        removeNewField (index) {
            // if (this.form.$all.fields != null && this.form.$all.fields.length > 0) {
            //     var fieldIndex = this.form.$all.fields.indexOf(index.toString());
            //     this.form.$all.fields.splice(fieldIndex, 1);
            // }
            this.form.$all.newFields.splice(index, 1);
            console.log(this.form.$all);
        },


        newTopic () {
            this.form.$all.newTopics.push({ title: '', fields: [], years: [], subject: null});
            this.form.$all[`documents_topic_${this.form.$all.newTopics.length - 1}`] = [];
            console.log(this.form.$all);
        },
        removeNewTopic (index) {
            this.form.$all.newTopics.splice(index, 1);
            delete this.form.$all[`documents_topic_${index}`];
            console.log(this.form.$all);
        },

         newSubject (topicIndex) {
            this.form.$all.newTopics[topicIndex].subject = [];
            this.form.$all.newTopics[topicIndex].subject.push({ title: '', abbreviation:'', years: [] });
            console.log(this.form.$all);
        },
        removeNewSubject (topicIndex) {
            this.form.$all.newTopics[topicIndex].subject = null;
            console.log(this.form.$all);
        },
        yearLabel (yearId) {
            for (const yearIndex in this.yearsOptions) {
                if (this.yearsOptions[yearIndex].id == yearId) {
                    return this.yearsOptions[yearIndex].label;
                }
            }
            console.log(this.form.$all);
        },

        canCreateAddNewTopic () {
            const newFields = this.form.$all.newFields;
            const atLeastOneNewFieldDefined = false;
            for (const newField in newFields) {
               atLeastOneNewFieldDefined = newField.title.trim().length > 0;
               if(atLeastOneNewFieldDefined) break;
            }

            const fields = this.form.$all.fields;
            const atLeastOneFieldSelected = fields.length > 0;
            return atLeastOneNewFieldDefined ||atLeastOneFieldSelected;
        },
    },
     computed: {
    // a computed getter
    publishedBooksMessage() {
      // `this` points to the component instance
      return this.author.books.length > 0 ? 'Yes' : 'No'
    }
  },

    render () {
        return this.$slots.default({
            newGroup: this.newGroup,
            removeNewGroup: this.removeNewGroup,
            newField: this.newField,
            removeNewField: this.removeNewField,
            canCreateAddNewTopic: this.canCreateAddNewTopic,
            newTopic: this.newTopic,
            removeNewTopic: this.removeNewTopic,
            newSubject: this.newSubject,
            removeNewSubject: this.removeNewSubject,
            yearLabel: this.yearLabel,
        });
    },
};
</script>
