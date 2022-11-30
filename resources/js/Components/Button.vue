<template>
  <button :type="type" :class="'btn-nygsoft '+  colorBgBtnClass">
    <slot>
    </slot>
  </button>
</template>

<script>
  import { defineComponent } from 'vue'

  export default defineComponent({
    props: {
      type: {
        type: String,
        default: 'button',
      },
      colorBgBtn: {
        type: String,
        default: '',
      },
    },
    computed: {
      colorBgBtnClass() {
        return {
          'success': ' success ',
          'danger': ' danger ',
        }[this.colorBgBtn]
      }
    }
  })
</script>

<style scoped>
/* Button primary*/
.btn-nygsoft {
  padding: 0.7rem 1rem;
  border: 0;
  border-radius: 20px;
  font-weight: 500;
  background: #7cb91d;
  color: #fff;
  text-decoration: none;
  cursor: pointer;
  text-align: center;
  transition: all 0.5s;
  width: auto;
}

.btn-nygsoft:hover {
  background-color: #218838;
}

.success{
background-color: #28a745;
border-color: #28a745;
}
.success:hover{
    background-color: #218838;
    border-color: #1e7e34;
}
.danger{
    background-color: #dc3545;
    border-color: #dc3545;
}
.danger:hover{
    background-color: #c82333;
    border-color: #bd2130;
}
/* .btn-nygsoft:disabled{
    background-color: #266bbb;
} */

 </style>
