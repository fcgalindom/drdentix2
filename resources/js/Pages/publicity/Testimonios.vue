<template>
    <div>
        <navegador />
            <div class="container py-5">

      <div class="fixed-bottom d-flex justify-content-end">
        <button class="position-butom align-items-center">
          <i class="fa-solid fa-phone-volume"></i>
          <i class="fa-brands fa-whatsapp"></i>
        </button>
      </div>

        <h2 class="our circle-2 text-center">
            <button class="circle">

              <i class="fa-solid fa-circle"></i>
            </button>
            ANTES Y DESPUÉS
        </h2>

        <main class="py-5">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 g-4">
                <div class="col" v-for="(i,index) in images" :key="index">
                  <div class="card card-bor">
                    <img :src="i" class="card-img-top img-den" alt="...">
                    <div class="card-body">
                      <h5 class="card-title text-center our ">
                        <strong>
                            Lorem ipsum
                        </strong>
                      </h5>
                      <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                      <p class="our h6">
                        Nombres y apellidos
                      </p>
                    </div>
                  </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <hr>
            </div>
        </main>
    </div>
    <foot />
    </div>
</template>

<script>
import navegador from "./components/Navegacion.vue";
import foot from "../../Layouts/Administrator/Foot.vue";
export default {
    props:["image"],
    data(){
        return{
            images: [this.image, this.image, this.image]
        }
    },
    components:{
        navegador,
        foot,
    }
}
</script>
