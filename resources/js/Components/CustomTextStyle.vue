
<script>
import {
    getMarkAttributes,
    Mark,
    mergeAttributes,
} from '@tiptap/core'

export const CustomTextStyle = Mark.create({
    name: "customTextStyle",

    addOptions () {
        return {
            HTMLAttributes: {},
        }
    },

    parseHTML () {
        return [
            {
                tag: 'span',
                getAttrs: element => {
                    const hasStyles = element.hasAttribute('style')
                    const hasClass = element.hasAttribute('class')
                    const hasComment = element.hasAttribute('data-tippy-content')
                    if (!hasStyles && !hasClass && !hasComment) {
                        return false
                    }
                    return {}
                },
            },
        ]
    },

    renderHTML ({ mark, HTMLAttributes }) {
        return ['span', mergeAttributes(this.options.HTMLAttributes, HTMLAttributes), 0]
    },

    addCommands () {
        return {
            removeEmptyTextStyle: () => ({ state, commands }) => {
                const attributes = getMarkAttributes(state, this.type)
                const hasStyles = Object.entries(attributes).some(([, value]) => !!value)

                if (hasStyles) {
                    return true
                }

                return commands.unsetMark(this.name)
            },
        }
    },
})
</script>
