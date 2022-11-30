<template>
  <input
  :disabled="disabled"
  :type="type"
  maxlength="255"
  v-on:keyup="error.length=0"
  autocomplete="off"
  class="form-control nygsoft-input"
  v-bind:class="[error.length==0 ? ' nygsoft-input ' : ' nygsoft-input-error ']"
  :value="modelValue"
  :placeholder="placeholder"
  @input="$emit('update:modelValue', $event.target.value)"
  ref="input">
    <template v-if="error">
        <Error class="d-block mt-1"  v-for="(item,index) in error" :key="index">{{item}}</Error>
    </template>
</template>

<script>
  import { defineComponent } from 'vue'
import Error from "@/Components/Error.vue";
  export default defineComponent({
    props:{
        modelValue:{

        },
        error:{
            type:Array,
            default:[]
        },
        type:{
            type:String,
            default:"text"
        },
        disabled:{
            type:Boolean,
            default:false
        },
        placeholder: {
            type: String,
        }
    },

    emits: ['update:modelValue'],
    components:{
        Error
    },
    created(){

    },
    methods: {
      focus() {
        this.$refs.input.focus()
      }
    }
  })
</script>
<style>

.nygsoft-input{
    border: 1px solid #ced4da !important;
    border-radius: 18px;
    box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25) !important;
}
.nygsoft-input-error{
    border: 1px solid rgb(202, 36, 36) !important;
}
.nygsoft-input-error:focus{
    box-shadow: 0 0 0 0.25rem rgba(202, 36, 36, 0.25) !important;
}

</style>
