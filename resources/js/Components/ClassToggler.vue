
<script>
import { Extension } from '@tiptap/core'

export const ClassToggler = Extension.create({
    name: "ClassToggler",
    addOptions () {
        return {
            types: ['customTextStyle'],
        }
    },
    // define a new attribute on mark of type as defined in options.types
    addGlobalAttributes () {
        return [
            {
                types: this.options.types,
                attributes: {
                    className: { // this attribute
                        default: null, // with this default value
                        //logic to use the value of this new attribute
                        // to set the value of a standard html attribute
                        // whose value could other not be defined directly without using
                        // this new attribute as interface
                        renderHTML: attributes => ({
                            class: attributes.className ? `${attributes.className}` : null,
                        }),
                        //logic to use the value of the html standard
                        // attribute this attribute is the setter of
                        // to set the value of this attribute
                        // based on the value of html attribute it
                        // reflects
                        parseHTML: element => element.getAttribute('class'),

                    },
                    comment: { // this attribute
                        default: null, // with this default value
                        //logic to use the value of the html standard
                        // attribute this attribute is the setter of
                        // to set the value of this attribute
                        // based on the value of html attribute it
                        // reflects
                        // logic to extract the attribute value from the html element
                        // on which it is defined
                        parseHTML: element => element.getAttribute('data-tippy-content') || null,
                        //logic to use the value of this new attribute
                        // to set the value of a standard html attribute
                        // whose value could other not be defined directly without using
                        // this new attribute as interface
                        renderHTML: attributes => ({
                            'data-tippy-content': attributes.comment,
                        }),

                    },
                },
            },
        ]
    },

    addCommands () {
        return {
            setClass: className => ({ chain }) => {
                return chain().focus()
                    .setMark('customTextStyle', { className })
                    .run()
            },
            unsetClass: () => ({ chain }) => {
                return chain().focus()
                    .setMark('customTextStyle', { className: null })
                    .removeEmptyTextStyle()
                    .run()
            },
            setComment: comment => ({ chain }) => {
                return chain().focus()
                    .setMark('customTextStyle', { comment })
                    .run()
            },
            unsetComment: () => ({ chain }) => {
                return chain().focus()
                    .setMark('customTextStyle', { comment: null })
                    .removeEmptyTextStyle()
                    .run()
            },
        }
    },
})
</script>
