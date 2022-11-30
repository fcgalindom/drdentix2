<template>
    <label class="form-label">
        <slot>
        </slot>
        <span v-if="required==1" class="text-danger"> (*)</span>
    </label>
</template>

<script>
  import { defineComponent } from 'vue'

  export default defineComponent({
    props: {
        required: {
            type: Boolean,
            default: 0
        }
    }
  })
</script>
