<template>
    <Line id="my-chart-id" :options="chartOptions" :data="chartData" />
</template>

<script>
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js'
import { Line } from 'vue-chartjs'

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
)

export default {
    name: 'BarChart',
    components: { Line },
    props: {
        chartData: {
            type: Object,
            required: true
        },
    },
    data () {
        return {
            chartOptions: {
                aspectRatio: 4/1,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Set the step size to 1
                        }
                    }
                }
            }
        }
    }
}
</script>
