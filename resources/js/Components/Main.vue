
<script>
const leftSide = document.querySelector('#left-side');
const rightSide = document.querySelector('#right-side');

export default {
    data () {
        return {
            activeSide: null,
            bottomData: null,
        }
    },
    methods: {
        toggleLeftSide () {
            if (this.activeSide == 'left') {
                this.activeSide = null
            } else {
                this.activeSide = 'left'
            }
        },

        toggleRightSide () {
            if (this.activeSide == 'right') {
                this.activeSide = null
            } else {
                this.activeSide = 'right'
            }
        },
        setBottomData ({ data }) {
            this.bottomData = null;
            this.activeSide = null;
            setTimeout(() => {
                this.bottomData = data;
            }, 300);
        },
        listDefinition () {
            const elements = document.querySelectorAll('#editor p:has(dfn)');
            const htmlArray = Array.from(elements).map(element => element.outerHTML);
            if (htmlArray.length == 0) {
                htmlArray.unshift('<h2>No definition found in this document</h2>');
            } else {
                htmlArray.unshift('<h2>Definitions found in this document</h2>');
            }
            const htmlString = htmlArray.join('');
            this.setBottomData({ data: { src: '#', content: htmlString } });
        }
    },
    computed: {
        leftSideActive () {
            return this.activeSide == 'left';
        },
        rightSideActive () {
            return this.activeSide == 'right';
        }
    },
    mounted () {
        this.$splade.on('clearBottomData', () => {
            this.bottomData = null;
        });
        this.$splade.on('listDefinitions', () => {
            this.listDefinition();
        });
    },

    render () {
        return this.$slots.default({
            toggleLeftSide: this.toggleLeftSide,
            toggleRightSide: this.toggleRightSide,
            leftSideActive: this.leftSideActive,
            rightSideActive: this.rightSideActive,
            setBottomData: this.setBottomData,
            bottomData: this.bottomData,
        });
    },
}
</script>
