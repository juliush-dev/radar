<script>
export default {

    props: {
        form: Object,
        session: Object,
        run: Boolean
    },
    data () {
        const countdown = this.getHoursMinutesSeconds(this.form.countdown);
        const hour = countdown.hours;
        const min =  countdown.minutes;
        const sec =  countdown.seconds;
        return {
            hour, min, sec, runningId: null,
            paused: null, toggledAnswers: 0,
            started: this.run,
            over: false,
        }
    },
    methods: {
        getHoursMinutesSeconds (seconds) {
            // Calculate the hours, minutes, and remaining seconds
            const hours = Math.floor(seconds / 3600);
            seconds %= 3600;
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;

            // Create an object to hold the results
            const timeObject = {
                hours,
                minutes,
                seconds: remainingSeconds,
            };
            return timeObject;
        },
        stop () {
            clearInterval(this.startedningId);
            this.started = false;
            this.over = true;
            this.form.stopped =  this.over =  this.session.over = true;
        },
        validate(event, max, min){
            var value = event.target.value;
            if (value > max) value = max;
            if (value < min) value = min;
            if(value != event.target.value){
                const cls = ['disable'];
                event.target.classList.add(...cls);
                setTimeout(() => {
                    event.target.classList.remove(...cls);
                }, 500);
            }
            return value;
        },
        setHour(event){
             event.target.value = this.hour = this.validate(event, 2, 0);
             this.form.countdown = this.convertToCountdown();
        },
        setMin(event){
            event.target.value = this.min = this.validate(event, 59, 1);
            this.form.countdown = this.convertToCountdown();
        },
        setSec(event){
            event.target.value = this.sec = this.validate(event, 59, 0);
            this.form.countdown = this.convertToCountdown();
        },
        convertToCountdown () {
            const totalSeconds = (this.hour * 3600) + (this.min * 60) + this.sec*1;
            return totalSeconds;
        },
        start (){
            if (!this.over) {
                this.startedningId = setInterval(() => {
                    if(!this.session.paused){
                        this.form.countdown--
                        if (this.form.countdown <= 0) {
                            this.stop();
                        }
                        const newCountdown = this.getHoursMinutesSeconds(this.form.countdown);
                        this.hour = newCountdown.hours;
                        this.min = newCountdown.minutes;
                        this.sec = newCountdown.seconds;
                    }
                }, 1000);
            }
        }
    },
    computed: {
        getHour () {
            return this.hour;
        },
        getMin () {
            return this.min;
        },
        getSec () {
            return this.sec;
        },
        running () {
            return this.started && !this.over;
        },
    },
    mounted() {
         if (this.run) {
            this.start();
        }
    },
    render () {
        return this.$slots.default({
            form: this.form,
            start: this.start,
            stop: this.stop,
            setHour: this.setHour,
            setMin: this.setMin,
            setSec: this.setSec,
            getHour: this.getHour,
            getMin: this.getMin,
            getSec: this.getSec,
            running: this.running,
            start: this.start,
            convertToCountdown: this.convertToCountdown,
        });
    },
};
</script>
