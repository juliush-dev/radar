
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
            setTimeout(() => {
                this.bottomData = data;
            }, 300);
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
