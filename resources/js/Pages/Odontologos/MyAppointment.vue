<template>
  <top />
  <div class="container mt-4 v-100">
    <div class="d-flex mb-4">
      <div class="col-6 col-sm-2 d-flex justify-content-start">
        <button type="button" class="btn btn-transparent">
          <i class="fas fa-circle"></i>
        </button>
        <span>{{ title }}</span>
      </div>
      <div class="col-6 col-sm-10 d-flex justify-content-end">
        <button
          type="button"
          class="btn btn-history"
          @click="getResults(1, 'De hoy')"
        >
          <span>Hoy</span>
        </button>
        <button
          type="button"
          class="btn btn-history ml-3"
          @click="getResults(1, 'Historial')"
        >
          <span>Historial</span>
        </button>
      </div>
    </div>
    <div class="card mb-3" v-for="(i, index) in citas.data" :key="index">
      <div class="card-body">
        <h3 class="mb-4">{{ i.d_pacient.name }}</h3>
        <div class="d-flex flex-column flex-md-row">
          <div class="flex-column col-12 col-md-6">
            <div class="d-flex">
              <span>Procedimiento:</span>
              <p class="">{{ i.denpro.procedures.name }}</p>
            </div>
            <div class="d-flex">
              <span>Hora:</span>
              <p class="">{{ i.hour }}</p>
            </div>
            <div class="d-flex">
              <span>Cédula:</span>
              <p class="">{{ i.d_pacient.user.document }}</p>
            </div>
            <div class="d-flex">
              <span>Contacto:</span>
              <p class="">{{ i.d_pacient.telephone }}</p>
            </div>
          </div>
          <div class="col-0 col-md-1 border-left"></div>
          <div class="flex-column col-12 col-md-5">
            <div class="d-flex">
              <span>Día:</span>
              <p>{{ i.day }}</p>
            </div>
            <div class="d-flex">
              <span>Precio:</span>
              <p>${{ i.pay }}</p>
            </div>
            <div class="d-flex">
              <span>Email:</span>
              <p>{{ i.d_pacient.user.email }}</p>
            </div>
            <div class="d-flex">
              <span>Sucursal:</span>
              <p>{{ i.dbraches.name }}</p>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
          <button
            type="button"
            class="btn btn-red-danger rounded-pill prr-3 w-10r"
            data-bs-toggle="modal"
            data-bs-target="#cancel"
            v-if="i.state == 'Activo' || i.state == 'Recordado'"
            @click="cita = i"
          >
            No asistió
          </button>
          <button
            type="button"
            class="btn btn-green-success rounded-pill prl-3 w-10r"
            data-bs-toggle="modal"
            data-bs-target="#modal"
            v-if="i.state == 'Activo' || i.state == 'Recordado'"
            @click="cita = i"
          >
            Pagado
          </button>
          <button
            disabled
            type="button"
            class="btn btn-secondary rounded-pill w-10r"
            v-if="i.state == 'Cancelado'"
          >
            Cancelada
          </button>
          <button
            disabled
            type="button"
            class="btn btn-secondary rounded-pill w-10r"
            v-if="i.state == 'No asistio'"
          >
            No asistió
          </button>
          <button
            disabled
            type="button"
            class="btn btn-green-success rounded-pill w-10r"
            v-if="i.state == 'Pagado'"
          >
            Asistió
          </button>
        </div>
      </div>
    </div>
    <pagination :users="citas" @pagi="getResults($event)" />
  </div>
  <foot />

  <!-- Start modal pay -->

  <div
    class="modal fade"
    id="modal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center mb-3" id="exampleModalLabel">
            ¿Cuánto es el costo de esto procedimiento?
          </h5>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="">Precio</label>
            <input
              type="text"
              class="form-control rounded-pill"
              v-model="pay"
            />
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-end">
          <button
            type="button"
            class="btn btn-red-danger"
            @click="cerrar_modal()"
          >
            <span class="text-white">Cancelar</span>
          </button>
          <button
            type="button"
            class="btn btn-blue-primary"
            @click="store('Pagado')"
          >
            <span class="text-white">Guardar</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- End modal pay -->

  <!-- Start modal cancel -->

  <div
    class="modal fade"
    id="cancel"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Dr. Dentix</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body text-center">
            <h6>¿Estás seguro que el paciente no asisitió a la cita?</h6>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-blue-primary"
            data-bs-dismiss="modal"
            id="cancel_modal"
          >
            Cancelar
          </button>
          <button type="button" class="btn  btn-red-danger" @click="store('No asistio')">No asistió</button>
        </div>
      </div>
    </div>
  </div>

  <!-- End modal cancel -->
</template>

<script>
import top from "../../Layouts/Patient/TopPatient.vue";
import foot from "../../Layouts/Administrator/Foot";
import pagination from "../../Layouts/Paginator";
export default {
  data() {
    return {
      citas: {},
      title: "Mis citas",
      filter: { time: "" },
      cita: { id: "", state: "", precio: 0 },
      pay: '',
    };
  },
  created() {
    this.getResults();
  },
  methods: {
    getResults(page = 1, time = "Mis citas") {
      this.title = time;
      let url = "/Odontologos/index?page=" + page + "&time=" + time;
      axios.get(url).then((res) => {
        this.citas = res.data.dentists;
      });
    },
    filter_appointment(time) {
      this.filter.time = time;
      this.title = time;
      this.getResults();
    },
    store(state) {
     

      let cita = { id: this.cita.id, state: state, pay: this.pay ,patientsF:this.cita.patientsF};
      axios.post("/Odontologos/change_state", cita).then((res) => {
          if(res.data.status == 200){
              Swal.fire("Éxito", res.data.msg, "success");
              $('#cancel_modal').trigger('click')
              $('#cancel_modal').trigger('click')
              this.cita = res.data.cita
              this.getResults();
              this.pay = '';
          }else if(res.data.status == 422){
              $('#cancel').trigger('click')
              Swal.fire("Error", res.data.msg, "error");
          }
      });
    },
  },
  components: {
    top,
    foot,
    pagination,
  },
};
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
