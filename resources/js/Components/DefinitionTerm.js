import {
    Mark,
    markInputRule,
    markPasteRule,
    mergeAttributes,
} from "@tiptap/core";

export const hashtagInputRegex = /(?:^|\s)((?:#)((?:[^*]+))(?:#))$/;
export const hashtagPasteRegex = /(?:^|\s)((?:#)((?:[^*]+))(?:#))/g;

export const DefinitionTerm = Mark.create({
    name: "definitionTerm",

    addOptions() {
        return {
            HTMLAttributes: {},
        };
    },

    parseHTML() {
        return [
            {
                tag: "dfn",
            },
        ];
    },

    renderHTML({ HTMLAttributes }) {
        return [
            "dfn",
            mergeAttributes(this.options.HTMLAttributes, HTMLAttributes),
            0,
        ];
    },

    addCommands() {
        return {
            setDefinitionTerm:
                () =>
                ({ commands }) => {
                    return commands.setMark(this.name);
                },
            toggleDefinitionTerm:
                () =>
                ({ commands }) => {
                    return commands.toggleMark(this.name);
                },
            unsetDefinitionTerm:
                () =>
                ({ commands }) => {
                    return commands.unsetMark(this.name);
                },
        };
    },

    addKeyboardShortcuts() {
        return {
            "Mod-alt-d": () => {
                this.editor.commands.toggleDefinitionTerm();
            },
            "Mod-alt-a": () => {
                this.editor.commands.clearNodes();
                this.editor.commands.unsetDefinitionTerm();
            },
        };
    },

    addInputRules() {
        return [
            markInputRule({
                find: hashtagInputRegex,
                type: this.type,
            }),
        ];
    },

    addPasteRules() {
        return [
            markPasteRule({
                find: hashtagPasteRegex,
                type: this.type,
            }),
        ];
    },
});
