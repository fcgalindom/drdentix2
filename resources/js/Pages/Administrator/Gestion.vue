<template>

</template>
<script>
export default {
    props:["cita"],
    data(){
        return{
            pay: ''
        }
    },
    created(){
        console.log(this.cita);
    },
    methods: {

    }
}
</script>

<style lang="css">
span {
  font-weight: bold;
}

span,
p {
  font-size: 1rem;
  color: #9b9c9d;
}

p {
  position: relative;
  left: 0.5rem;
}

h3 {
  color: #9b9c9d;
}

.w-10r {
  width: 10rem;
}

.border-left {
  border-left: 1px solid #9b9c9d;
}

.btn-green-success {
  background-color: #7fca1f;
  border: 1px solid #7fca1f;
  color: #fff;
}

@media (max-width: 350px) {
  .v-100 > .d-flex {
    flex-direction: column;
  }

  .d-flex > .justify-content-end {
    justify-content: start !important;
  }
}

@media (max-width: 767px) {
  .border-left {
    border-left: none;
  }
  .w-10r {
    width: 6rem;
  }
  .prr-3 {
    position: relative;
    right: 1rem;
    font-size: 0.8rem;
  }
  .prl-3 {
    position: relative;
    left: 1rem;
    font-size: 0.8rem;
  }
  span,
  p {
    font-size: 0.9rem;
    color: #9b9c9d;
  }
}
</style>
