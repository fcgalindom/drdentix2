<template>
  <div>
    <navegador />
    <div class="container mt-3">
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
          <div class="d-flex justify-content-center">
            <img :src="imagenes[0]" class="mb-3 logo-card" alt="..." />
          </div>
          <div class="card">
            <div class="card-body">
              <!-- <h5 class="card-title">Card title</h5> -->
              <div class="mb-3">
                <h6 class="h6-t">Montos de financiación:</h6>
                <p class="card-text">Desde $1.000.000 hasta $30.000.000</p>
                <hr />
              </div>
              <div class="mb-3">
                <h6 class="h6-t">Plazos:</h6>
                <p class="card-text">Desde 6 a 36 meses</p>
                <hr />
              </div>
              <div class="mb-3">
                <h6 class="h6-t">Tasa de interés:</h6>
                <p class="card-text">
                  1.93% MV equivalente a 25.83% vigente al 2022
                </p>
                <hr />
              </div>
              <div class="mb-3">
                <h6 class="h6-t">Documentos:</h6>
                <p class="card-text">
                  Solo debes presentarte con tu cedula en original y tu numero
                  de telefono
                </p>
                <hr />
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="d-flex justify-content-center">
            <img
              :src="imagenes[1]"
              class="logo-card-1"
              alt="..."
            />
          </div>
          <div class="card">
            <div class="card-body">
              <!-- <h5 class="card-title">Card title</h5> -->
              <div class="mb-3">
                <h6 class="h6-t">Montos de financiación:</h6>
                <p class="card-text">Desde $1.000.000 hasta $30.000.000</p>
                <hr />
              </div>
              <div class="mb-3">
                <h6 class="h6-t">Plazos:</h6>
                <p class="card-text">Desde 6 a 36 meses</p>
                <hr />
              </div>
              <div class="mb-3">
                <h6 class="h6-t">Tasa de interés:</h6>
                <p class="card-text">
                  1.93% MV equivalente a 25.83% vigente al 2022
                </p>
                <hr />
              </div>
              <div class="mb-3">
                <h6 class="h6-t">Documentos:</h6>
                <p class="card-text">
                  Solo debes presentarte con tu cedula en original y tu numero
                  de telefono
                </p>
                <hr />
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="d-flex justify-content-center">
            <img :src="imagenes[2]" class="logo-card-2" alt="..." />
          </div>
          <div class="card">
            <div class="card-body">
              <!-- <h5 class="card-title">Card title</h5> -->
              <div class="mb-3">
                <h6 class="h6-t">Montos de financiación:</h6>
                <p class="card-text">Desde $1.000.000 hasta $30.000.000</p>
                <hr />
              </div>
              <div class="mb-3">
                <h6 class="h6-t">Plazos:</h6>
                <p class="card-text">Desde 6 a 36 meses</p>
                <hr />
              </div>
              <div class="mb-3">
                <h6 class="h6-t">Tasa de interés:</h6>
                <p class="card-text">
                  1.93% MV equivalente a 25.83% vigente al 2022
                </p>
                <hr />
              </div>
              <div class="mb-3">
                <h6 class="h6-t">Documentos:</h6>
                <p class="card-text">
                  Solo debes presentarte con tu cedula en original y tu numero
                  de telefono
                </p>
                <hr />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <foot />
  </div>
</template>

<script>
import navegador from "./components/Navegacion.vue";
import foot from "../../Layouts/Administrator/Foot.vue";
export default {
    props:["imagenes"],
  data() {
    return {
      images: ["img/listo.png", "img/listo.png", "img/listo.png"],
    };
  },
  created() {
    //   this.$alerta()
  },
  components: {
    navegador,
    foot,
  },
};
</script>
