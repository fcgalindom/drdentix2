<template>
  <a :href="href" :download="download" :class="'btn-nygsoft'">
    <slot>
    </slot>
  </a>
</template>

<script>
  import { defineComponent } from 'vue'

  export default defineComponent({
    props: {
      href: {
        type: String,
        default: '#',
      },
      download: {
        type: String,
        default: 'Archivo',
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
  height: 2.7rem;
  /* display: block; */
  border: 0;
  border-radius: 20px;
  font-weight: 500;
  background: #003389;
  color: #fff;
  text-decoration: none;
  cursor: pointer;
  text-align: center;
  transition: all 0.5s;
  width: auto;
}

.btn-nygsoft:hover {
  background-color: #266bbb;
}

.success{
background: #4ec1879a;
}
.success:hover{
background: #1258359a;
}
.danger{
background: #a23d3d;
}
.danger:hover{
background: #701616;
}
/* .btn-nygsoft:disabled{
    background-color: #266bbb;
} */

 </style>
