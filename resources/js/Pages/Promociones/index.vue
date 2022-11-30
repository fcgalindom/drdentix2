<template>
  <div class="container-fluid d-flex justify-content-between my-4">
    <h5><strong>Promociones</strong></h5>
    <button
      type="button"
      class="btn btn-primary"
      data-bs-toggle="modal"
      data-bs-target="#exampleModal"
    >
      crear
    </button>
  </div>

  <div class="container-fluid table-responsive text-center">
    <table class="table text-gray">
      <thead class="bg-blue text-white">
        <tr>
          <th>Fecha de inicio</th>
          <th>Fecha final</th>
          <th>Detalle</th>
          <th>Descuento</th>
          <th>Limite de pacientes</th>
          <th>Editar</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(i, index) in promotions.data" :key="index">
          <td>{{ dConvert(i.date_start) }}</td>
          <td>{{ dConvert(i.date_end) }}</td>
          <td>{{ i.details }}</td>
          <td>{{ i.discount }}</td>
          <td>{{ i.limit_patients }}</td>

          <td>
            <button
              data-bs-toggle="modal"
              data-bs-target="#exampleModal"
              class="btn btn-transparent text-gray shadow-none"
              @click="modal_data(i)"
            >
              <i class="fas fa-pen fa-lg"></i>
            </button>
          </td>
          <td>
            <div
              class="form-check form-switch"
              v-if="i.status == 1 || i.status == 0"
            >
              <input
                class="form-check-input"
                type="checkbox"
                true-value="1"
                false-value="0"
                :id="'customSwitch' + index"
                @change="destroy(i)"
                v-model="i.status"
                checked=""
                autocompleted=""
              />
              <label
                class="form-check-label"
                :for="'customSwitch' + index"
              ></label>
            </div>
            <div v-else>Ya fue aplicada</div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- empieza la modal -->

  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="container row my-2">
          <h4 class="text-center mb-3" id="exampleModalLabel">
            <strong>Promoción</strong>
          </h4>
          <div class="col-12 mb-3">
            <div class="form-group">
              <label class="form-label">Fecha de inicio</label>
              <input
                type="date"
                class="form-control"
                v-model="promotion.date_start"
              />
            </div>
          </div>
          <div class="col-12 mb-3">
            <label class="form-label">Fecha final</label>
            <input
              type="date"
              class="form-control"
              v-model="promotion.date_end"
            />
          </div>
          <div class="col-12 mb-3">
            <label class="form-label">Detalles</label>
            <textarea
              class="form-control"
              placeholder="Escribe aquí los detalles de tu promoción, ten en cuenta que esto será lo que tus pacientes leerán"
              id="floatingTextarea"
              v-model="promotion.details"
            ></textarea>
          </div>
          <div class="col-12 mb-3">
            <label class="form-label">límite de pacientes</label>
            <input
              class="form-control"
              type="number"
              v-model="promotion.limit_patients"
            />
          </div>
          <div class="col-12 mb-3">
            <label class="form-label">Descuento</label>
            <input
              class="form-control"
              type="number"
              v-model="promotion.discount"
            />
          </div>
          <div class="col-12 d-flex justify-content-center">
            <button class="btn btn-azul rounded box-l-b" @click="store()">
              Guardar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      promotion: {
        date_start: "",
        date_end: "",
        details: "",
        limit_patients: "",
        discount: "",
      },

      promotions: {},
    };
  },

  created() {
    this.getResults();
  },

  methods: {
    store() {
      axios
        .post("/Administrador/CrearPromocion", this.promotion)
        .then((res) => {
          if (res.data.status == 200) {
            Swal.fire("Éxito", res.data.msg, "success");
          } else if (res.data.status == 422) {
            Swal.fire("Error", res.data.msg, "error");
          }
        });
      this.prompromotionotio = {
        date_start: "",
        date_end: "",
        details: "",
        limit_patients: "",
        discount: "",
      };
    },

    getResults() {
      axios.put("/Administrador/Promociones").then((res) => {
        this.promotions = res.data.promocion;
      });
    },
    modal_data(i) {
      this.promotion = i;
    },

    destroy(i) {
      this.promotion = { id: i.id };
      axios.post("/Administrador/EliminarPromocion", this.promotion);
    },
    dConvert(date) {
      let array = date.split("-");
      return array[2] + "-" + array[1] + "-" + array[0];
    },
  },
};
</script>
<style lang="css">
textarea.form-control {
  height: 10rem !important;
}
</style>
