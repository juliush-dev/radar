<script>

export default {
    methods: {
        extractDate (dateStr) {
            // Create a new Date object with the given string
            var dateObj = new Date(dateStr);

            // Extract the year, month, day, hour, and minute from the Date object
            var year = dateObj.getUTCFullYear();
            var month = dateObj.getUTCMonth() + 1; // getUTCMonth() is zero-based
            var day = dateObj.getUTCDate();
            var hour = dateObj.getUTCHours();
            var minute = dateObj.getUTCMinutes();
            var second = dateObj.getUTCSeconds();

            // Format the date as a string
            var date = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')} ${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}:${String(second).padStart(2, '0')}`;

            return date;
        },
    },

    render () {
        return this.$slots.default({
            extractDate: this.extractDate,
        });
    },
};
</script>
