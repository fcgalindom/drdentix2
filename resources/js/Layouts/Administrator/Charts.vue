<template>
    <div>
        <canvas :id="id" :width="width" :height="height" :dataset="dataset" :labels="labels"></canvas>
    </div>
</template>
<script>
import Chart from 'chart.js/auto';
import { defineComponent } from 'vue'
export default defineComponent({
    props: {
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 400
        },
        id: String,
        labels: {
            type: Array,
            default: []
        },
        dataset: {
            type: Array,
            default: []
        },
        label: {
            type: String,
            default: 'Graphic'
        }
    },
    data() {
        return {

        }
    },
    mounted() {
        var ctx = document.getElementById(this.id);
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                 labels:this.dataset,
                 datasets: [{
                      label: this.id,
                      data: this.labels,
                      borderWidth: 1
                   }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        myChart
    },
})
</script>
