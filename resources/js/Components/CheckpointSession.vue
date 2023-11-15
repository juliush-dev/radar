<script>
export default {
    props: {
        content: Object,
    },
    data() {
        return {
            paused: false,
            started: false,
            over: false,
        }
    },
    methods: {
        pause(){
            this.paused = true;
        },
        resume(){
            this.paused = false;
        }
    },

    mounted() {
        // console.log(this.content);
    },

    render () {
        return this.$slots.default({
            pause: this.pause,
            resume: this.resume,
            started: this.started,
            paused: this.paused,
            over: this.over,
            content: this.content,
        });
    },
};
</script>
