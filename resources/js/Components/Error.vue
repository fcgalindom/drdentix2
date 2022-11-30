<template>
    <span class="text-danger">
       <b>*
        <slot>
        </slot>
       </b>
    </span>
</template>

<script>
  import { defineComponent } from 'vue'

  export default defineComponent({
    props: {
    }
  })
</script>
