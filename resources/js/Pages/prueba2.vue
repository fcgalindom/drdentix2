<template>
  <div class="container pt-5">
    <select2 :options="products.name" :value="products.id" name="datos.id" v-on:input="prueba(products.id)" />
  </div>
</template>
<script>
import select2 from "../Layouts/Select2";

export default {
  props: ["products"],
  data(){
    return{
        datos: {id: ''}
    }
  },
  methods:{
      prueba(id){
          console.log(id);
      }
  },
  components: {
    select2,
  },
};
</script>
