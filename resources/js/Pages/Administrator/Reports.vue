<template>
    <div>
        <Chart id="catherine" :labels="[12, 19, 3, 5, 2, 3]" :dataset=" ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange']" />
    </div>
</template>
<script>
import Chart from '@/Layouts/Administrator/Charts.vue'
export default {
    data() {
        return {

        }
    },
    mounted() {
    },
    components: {
        Chart
    }
}
</script>
