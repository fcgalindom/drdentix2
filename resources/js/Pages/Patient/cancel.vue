<template>
    <top />
    <div class="container mt-4 v-100">
        <div class="card mb-3" v-for="(i, index) in patients.data" :key="index">
            <div class="card-body">
                <h3 class="mb-4">{{ i.d_pacient.name }}</h3>
                <div class="d-flex flex-column flex-md-row">
                    <div class="flex-column col-12 col-md-6">
                        <div class="d-flex">
                            <span>Procedimiento:</span>
                            <p>{{ i.denpro.procedures.name }}</p>
                        </div>
                        <div class="d-flex">
                            <span>Hora:</span>
                            <p>{{ tConvert(i.hour) }}</p>
                        </div>
                        <div class="d-flex">
                            <span>Cédula:</span>
                            <p>{{ i.d_pacient.user.document }}</p>
                        </div>
                        <div class="d-flex">
                            <span>Contacto:</span>
                            <p>{{ i.d_pacient.telephone }}</p>
                        </div>
                    </div>
                    <div class="col-0 col-md-1 border-left"></div>
                    <div class="flex-column col-12 col-md-5">
                        <div class="d-flex">
                            <span>Día:</span>
                            <p>{{ dConvert(i.day) }}</p>
                        </div>
                        <div class="d-flex">
                            <span>Odontólogo:</span>
                            <p>{{ i.denpro.dentists.name }}</p>
                        </div>
                        <div class="d-flex">
                            <span>Email:</span>
                            <p>{{ i.denpro.dentists.user.email }}</p>
                        </div>
                        <div class="d-flex">
                            <span>Sucursal:</span>
                            <p>{{ i.dbraches.name }}</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <!-- <button
            type="button"
            class="btn btn-green-success rounded-pill w-10r"
            v-if="i.state == 'Activo' || i.state == 'Recordado'"
            @click="destroy(i)"
          > -->
                    <button type="button" class="btn btn-green-success rounded-pill w-10r"
                        v-if="i.state == 'Activo' || i.state == 'Recordado'" disabled>
                        Pendiente
                    </button>
                    <button disabled type="button" class="btn btn-secondary rounded-pill w-10r"
                        v-if="i.state == 'Cancelado'">
                        Cancelada
                    </button>
                    <button disabled type="button" class="btn btn-secondary rounded-pill w-10r"
                        v-if="i.state == 'No asistio'">
                        No asistió
                    </button>
                    <!-- <button disabled type="button" class="btn btn-green-success rounded-pill w-10r" v-if="i.state == 'Pagado'">Asistió</button> -->
                    <button type="button" class="btn btn-green-success rounded-pill prr-3 w-10r"
                        v-if="i.state == 'Pagado'" disabled>
                        Asistí
                    </button>
                    <button type="button" class="btn btn-red-danger rounded-pill prl-3 w-10r" v-if="i.state == 'Pagado'"
                        @click="download_pdf(i)">
                        Mi factura
                    </button>
                </div>
            </div>
        </div>
        <pagination :users="patients" @pagi="getResults($event)" />
    </div>
    <foot />
</template>


<script>
import foot from "../../Layouts/Administrator/Foot.vue";
import top from "../../Layouts/Patient/TopPatient.vue";
import pagination from "../../Layouts/Paginator.vue";
export default {
    data() {
        return {
            patients: {},
        };
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults(page = 1) {
            axios.get("/Pacientes/citasPorPacienteDado?page=" + page).then((res) => {
                this.patients = res.data.patient;
            });
        },
        download_pdf(i) {
            window.open("/Pacientes/download_pdf?key=" + i.id);
        },
        destroy(i) {
            axios.post("/Pacientes/citasPorPacienteCancelar", i).then((res) => {
                this.getResults();
                Swal.fire("Éxito", res.data.msg, "success");
            });
        },
        dConvert(date) {
            let array = date.split("-");
            return array[2] + "-" + array[1] + "-" + array[0];
        },
        tConvert(time) {
            // Check correct time format and split into components
            time = time
                .toString()
                .match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

            if (time.length > 1) {
                // If time format correct
                time = time.slice(1); // Remove full string match value
                time[5] = +time[0] < 12 ? "AM" : "PM"; // Set AM/PM
                time[0] = +time[0] % 12 || 12; // Adjust hours
            }
            return time.join(""); // return adjusted time or original string
        },
    },
    components: {
        top,
        foot,
        pagination,
    },
};
</script>
