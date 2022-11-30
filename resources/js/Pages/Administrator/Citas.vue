<template>
    <top />

    <div v-if="pantalla == 'tabla'">
        <div class="container mb-3">
            <div class="row mt-4 mb-3 align-items-center">
                <div class="col-3 col-sm-6 col-md-9">
                    <button class="btn btn-link d-none d-sm-inline">
                        <i class="fas fa-circle"></i>
                    </button>
                    <h5 class="d-inline">Citas</h5>
                </div>
                <div class="col-9 col-sm-6 col-md-3 text-end d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-verde btn-pending" disabled>
                        {{ totales.total_citas }}
                    </button>
                    <button type="button" class="btn btn-verde" style="height: 2rem" disabled>
                        {{ total_ingresos() }}
                    </button>
                    <button type="button" class="btn btn-transparent" @click="excel">
                        <i class="far fa-file-excel fa-2x text-success"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row mb-3">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="">Paciente</label>
                        <input type="text" class="form-control" v-model="filtros.paciente" @keypress="disabled_date" />
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="">Estado </label>
                        <select name="" id="" class="form-select" v-model="filtros.estado">
                            <option value="">Todos</option>
                            <option value="Activo">Activo</option>
                            <option value="Cancelado">Cancelado</option>
                            <option value="No asistio">No asistió</option>
                            <option value="Recordado">Recordado</option>
                            <option value="Pagado">Pagado</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for=""> Odontólogo </label>
                        <select name="" id="" class="form-select" v-model="filtros.dentist_id">
                            <option value="">Selecciona</option>
                            <option v-for="(i, index) in dentist" :key="index" :value="i.id" v-text="i.name"></option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Día inicio</label>
                        <input type="date" class="form-control" v-model="filtros.dia_inicio" @change="disabled_date" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Día fin</label>
                        <input type="date" class="form-control" v-model="filtros.dia_fin" @change="disabled_date" />
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex mb-3" v-bind:class="[date.disabled ? 'text-light-gray' : 'text-gray']">
                <div class="d-flex col-6 justify-content-end align-items-center">
                    <button class="btn btn-verde" @click="getResults" style="height: 2rem">
                        Buscar
                    </button>
                </div>
                <div class="d-flex flex-column col-6 align-items-end">
                    <strong class="mx-3">{{ date.name_day }}</strong>
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-transparent" @click="change_date('sub')"
                            :disabled="date.disabled" v-bind:class="[date.disabled ? 'text-light-gray' : 'text-gray']">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h4>{{ date.day }}</h4>
                        <button class="btn btn-transparent" @click="change_date('add')" :disabled="date.disabled"
                            v-bind:class="[date.disabled ? 'text-light-gray' : 'text-gray']">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <strong>{{ date.month }} {{ date.year }}</strong>
                </div>
            </div>
        </div>

        <div class="container-fluid table-responsive text-center fs-09rem">
            <table class="table">
                <thead class="bg-blue text-white">
                    <tr>
                        <th>Paciente</th>
                        <th>Documento</th>
                        <th>Teléfono</th>
                        <th>Odontólogo</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Gestionar</th>
                        <th>Re agendar</th>
                        <th>Facturas</th>
                        <th>WhatsApp</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(i, index) in citas.data" :key="index" v-bind:class="[
                        i.state == 'Pagado'
                            ? 'for-payment'
                            : i.state == 'Cancelado' || i.state == 'No asistio'
                                ? 'for-canceled'
                                : '',
                    ]">
                        <td v-text="i.d_pacient.name"></td>
                        <td v-text="i.d_pacient.user.document"></td>
                        <td v-text="i.d_pacient.telephone"></td>
                        <td v-text="i.denpro.dentists.name"></td>
                        <td v-text="i.day + ' ' + i.hour"></td>
                        <td>
                            {{
                                    i.type_state == 1 && i.state == "Activo"
                                        ? "Recordado por whatsapp"
                                        : i.type_state == 2 && i.state == "Activo" ? "Recordado por teléfono" : i.state
                            }}
                        </td>
                        <td>
                            <button class="btn btn-transparent text-gray shadow-none" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" @click="gestionar(i)">
                                <i class="fas fa-tasks fa-lg"></i>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-transparent text-gray"
                                @click="redirection_to_appoinment(i)"
                                v-if="i.state == 'Activo' || i.state == 'Recordado'">
                                <i class="fas fa-tools fa-lg"></i>
                            </button>
                            <button type="button" class="btn btn-transparent text-gray" v-if="i.state == 'Pagado'"
                                disabled>
                                <i class="fas fa-minus-circle fa-lg"></i>
                            </button>
                            <button type="button" class="btn btn-transparent text-gray"
                                v-if="i.state == 'Cancelado' || i.state == 'No asistio'" @click="destroy_appoinment(i)">
                                <i class="fas fa-trash fa-lg"></i>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-transparent text-gray"
                                @click="see_invoces(i.patientsF)">
                                <i class="fas fa-file-invoice-dollar fa-lg"></i>
                            </button>
                        </td>
                        <td>
                            <button type="button" @click="whatsapp(i)" class="btn btn-transparent text-gray"
                                :disabled="i.state != 'Activo' && i.state != 'Recordado'">
                                <i class="fab fa-whatsapp fa-lg"></i>
                            </button>
                            <!-- <button type="button" @click="cellphone(i)" class="btn btn-transparent text-gray"
                                :disabled="i.state != 'Activo' && i.state != 'Recordado'">
                                <i class="fa-solid fa-phone"></i>
                            </button> -->
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :users="citas" @pagi="getResults($event)" />
        </div>
    </div>
    <div v-else>
        <div class="container">
            <div class="d-flex mb-4">
                <div class="col-6 col-sm-2 d-flex justify-content-start">
                    <button type="button" class="btn btn-transparent">
                        <i class="fas fa-circle"></i>
                    </button>
                    <span>Gestionar cita</span>
                </div>
                <div class="col-6 col-sm-10 d-flex justify-content-end">
                    <button type="button" class="btn btn-history ml-3" @click="pantalla = 'tabla'">
                        <span>Regresar</span>
                    </button>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="mb-4">{{ cita.d_pacient?.name }}</h3>
                    <div class="d-flex flex-column flex-md-row">
                        <div class="flex-column col-12 col-md-6">
                            <div class="d-flex">
                                <span>Procedimiento:</span>
                                <p class="">{{ cita.denpro.procedures.name }}</p>
                            </div>
                            <div class="d-flex">
                                <span>Hora:</span>
                                <p class="">{{ cita.hour }}</p>
                            </div>
                            <div class="d-flex">
                                <span>Cédula:</span>
                                <p class="">{{ cita.d_pacient.user.document }}</p>
                            </div>
                            <div class="d-flex">
                                <span>Contacto:</span>
                                <p class="">{{ cita.d_pacient.telephone }}</p>
                            </div>
                        </div>
                        <div class="col-0 col-md-1 border-left"></div>
                        <div class="flex-column col-12 col-md-5">
                            <div class="d-flex">
                                <span>Día:</span>
                                <p>{{ cita.day }}</p>
                            </div>
                            <div class="d-flex">
                                <span>Precio:</span>
                                <p>${{ cita.pay }}</p>
                            </div>
                            <div class="d-flex">
                                <span>Email:</span>
                                <p>{{ cita.d_pacient.user.email }}</p>
                            </div>
                            <div class="d-flex">
                                <span>Sucursal:</span>
                                <p>{{ cita.dbraches.name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around mt-4">
                        <button type="button" class="btn btn-rojo rounded-pill prr-3 w-10r" data-bs-toggle="modal"
                            data-bs-target="#cancel" v-if="cita.state == 'Activo' || cita.state == 'Recordado'"
                            @click="gestion_asistir(1)">
                            No asistió
                        </button>
                        <button type="button" class="btn btn-verde rounded-pill prl-3 w-10r" data-bs-toggle="modal"
                            data-bs-target="#modal" v-if="cita.state == 'Activo' || cita.state == 'Recordado'">
                            Pagado
                        </button>
                        <button disabled type="button" class="btn btn-secondary rounded-pill w-10r"
                            v-if="cita.state == 'Cancelado'">
                            Cancelada
                        </button>
                        <button disabled type="button" class="btn btn-secondary rounded-pill w-10r"
                            v-if="cita.state == 'No asistio'">
                            No asistió
                        </button>
                        <button type="button" class="btn btn-verde rounded-pill prl-3 w-10r"
                            v-if="cita.state == 'Activo' || cita.state == 'Recordado'" data-bs-toggle="modal"
                            data-bs-target="#cancel" @click="gestion_asistir(2)">
                            Asistió
                        </button>
                        <button disabled type="button" class="btn btn-verde rounded-pill prl-3 w-10r"
                            v-if="cita.state == 'Pagado'">
                            Asistió
                        </button>
                        <button type="button" class="btn btn-red-danger rounded-pill prl-3 w-10r"
                            v-if="cita.state == 'Pagado'" @click="download_pdf(cita)">
                            Factura
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <foot />
    <!-- Start modal pay -->

    <Modal id="modal" title="¿Cuánto es el costo de esto procedimiento?" verticalCenter="1">
        <div class="div">
            <div class="row mb-2" v-for="(item, position) in pago" :key="position">
                <div class="col-5">
                    <label class="form-label" for="">Procedimientos</label>
                    <select class="form-select rounded-pill" v-model="item.procedure">
                        <option value="">Selecciona</option>
                        <option v-for="(i, index) in procedures" :key="index" :value="i.id" v-text="i.name">
                        </option>
                    </select>
                </div>
                <div class="col-1"></div>
                <div class="col-5">
                    <label class="form-label" for="">Precios</label>
                    <input class="form-control rounded-pill" type="text" v-model="item.price" />
                </div>

                <div class="col-1">
                    <button class="basure-plus mb-2" @click="pago.push({ procedure: '', price: 0 })"
                        v-bind:class="[position > 0 ? 'd-none' : '']">
                        <i class="fa-solid fa-circle-plus ft"></i>
                    </button>
                    <button class="basure mb-2" :disabled="pago.length == 1"
                        v-bind:class="[position > 0 ? 'top-2r' : '']">
                        <i class="fa-solid fa-circle-minus ft" @click="pago.splice(position, 1)"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn btn-red-danger me-2" @click="cerrar_modal()">
                <span class="text-white">Cancelar</span>
            </button>
            <button type="button" class="btn btn-blue-primary" @click="store('Pagado')">
                <span class="text-white">Guardar</span>
            </button>
        </div>
    </Modal>


    <!-- End modal pay -->

    <!-- Start modal cancel -->
    <Modal id="cancel" title="Dr. Dentix">
        <div class="text-center">
            <h5>{{ gestion.msg }}</h5>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn me-2"
                :class="[colorConfirm == 1 ? 'btn-blue-primary' : 'btn btn-red-danger']" data-bs-dismiss="modal"
                id="cancel_modal">
                Cancelar
            </button>
            <button type="button" class="btn" :class="[colorConfirm == 1 ? 'btn-red-danger' : 'btn-blue-primary']"
                @click="store(gestion.state)">
                {{ gestion.boton }}
            </button>
        </div>
    </Modal>

    <!-- End modal cancel -->
</template>
<script>
import top from "@/Layouts/Administrator/Top.vue";
import foot from "@/Layouts/Administrator/Foot.vue";
import pagination from "@/Layouts/Paginator.vue";
import Modal from "@/Components/Modal.vue";
import gestion from "./Gestion.vue";
import Select2 from 'vue3-select2-component';

export default {
    props: ["id", "dentist"],
    data() {
        return {
            pending: 0,
            cita: {},
            citas: {},
            date: { disabled: false },
            filtros: {
                paciente: "",
                dia_inicio: "",
                dia_fin: "",
                estado: "",
                dentist_id: "",
                avance: 0,
            },
            pantalla: "tabla",
            pay: "",
            id_change: false,
            totales: { total_citas: 0, total_ingresos: 0 },
            gestion: { msg: "", boton: "", state: "" },
            colorConfirm: 1,
            procedures: [],
            precios: [],
            pago: [{ procedure: '', price: 0 }],
        };
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults(page = 1) {
            if (this.id != "" && this.id_change == false) {
                this.filtros.paciente = this.id;
                this.id_change = true;
            }
            axios.put("/Administrador/citasdiarias?page=" + page, this.filtros)
                .then((res) => {
                    this.citas = res.data.citas;
                    this.date = res.data.date;
                    this.totales.total_ingresos = res.data.totales.total_ingresos;
                    this.totales.total_citas = res.data.totales.total_citas;
                    this.disabled_date();
                    this.pending = 0;
                    this.citas?.data.forEach((row) => {
                        if (row.state == "Activo" || row.state == "Recordado") {
                            this.pending++;
                        }
                    });
                    this.procedures = res.data.procedures
                });
        },
        gestionar(i) {
            this.cita = i;
            this.pantalla = "gestion";
        },
        total_ingresos() {
            const formatter = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
                minimumFractionDigits: 0,
            });

            return formatter.format(this.totales.total_ingresos);
        },
        total_procedure() {
            let value = 0
            this.procedures.forEach(item => {
                value += item.price
            })
            return value
        },
        store(state) {

            let cita = {
                id: this.cita.id,
                state: state,
                pay: this.pay,
                patientsF: this.cita.patientsF,
                pagos: this.pago
            };
            axios.post("/Administrador/change_state", cita).then((res) => {
                if (res.data.status == 200) {
                    Swal.fire("Éxito", res.data.msg, "success");
                    $("#cancel_modal").trigger("click");
                    this.getResults();
                    $("#modal").trigger("click");
                    this.cita = res.data.cita;
                    this.pay = "";
                    if (state == "Pagado" || state == "Asistio")
                        window.location.href =
                            "/Administrador/citaAdminxPaciente/" + res.data.cita.d_pacient.id;
                } else if (res.data.status == 422) {
                    $("#cancel").trigger("click");
                    Swal.fire("Error", res.data.msg, "error");
                    console.log(res)
                }
            });
        },
        whatsapp(i) {
            axios.post("/Administrador/whatsapp_manual", i).then((res) => {
                let url =
                    "https://api.whatsapp.com/send?phone=" +
                    res.data.request.d_pacient.telephone +
                    "&text=" +
                    res.data.msg;
                var win = window.open(url, "_blank");
                win.focus();
                this.getResults();
            });
        },
        cellphone(i) {
            axios.post(route('adminsitrator.citas.cellphone'), i).then((res) => {
                if (res.data.status == 200) Swal.fire('Éxito', res.data.msg, 'success')
                else if (res.data.status == 500) Swal.fire('Error', res.data.msg, 'error')
                this.getResults();
            });
        },
        excel() {
            axios
                .put("/Administrador/citasdiarias?excel=download", this.filtros)
                .then((res) => {
                    let blob = new Blob([res.data]);
                    let link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Informe-citas.xls";
                    link.click();
                });
        },
        change_date(type) {
            if (type == "add") this.filtros.avance++;
            else if (type == "sub") this.filtros.avance--;
            this.getResults();
        },
        disabled_date() {
            if (
                !this.isEmpty(this.filtros.dia_inicio) ||
                !this.isEmpty(this.filtros.dia_fin) ||
                !this.isEmpty(this.filtros.paciente)
            )
                this.date.disabled = true;
            else this.date.disabled = false;
        },
        isEmpty(value) {
            if (value === undefined || value === null || value === "" || value === "")
                return true;
            else return false;
        },
        redirection_to_appoinment(i) {
            window.location.href = "/Administrador/citasAdministrador/" + i.id;
        },
        download_pdf(i) {
            window.open("/Pacientes/download_pdf?key=" + i.id);
        },
        gestion_asistir(type) {
            if (type == 1) {
                this.gestion.msg =
                    "¿Estás seguro que el paciente NO asisitió a la cita?";
                this.gestion.boton = "No asistió";
                this.gestion.state = "No asistio";
                this.colorConfirm = 1
            } else {
                this.gestion.msg =
                    "¿Estás seguro que el paciente SI asisitió a la cita?";
                this.gestion.boton = "Asistió";
                this.gestion.state = "Asistio";
                this.colorConfirm = 2
            }
        },
        destroy_appoinment(i) {
            let colorConfirm = ['#fe0000', '#7fca1f']
            Swal.fire({
                title: "¡Advertencia!",
                text: "¿Estás seguro de eliminar esta cita?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: colorConfirm[0],
                cancelButtonColor: colorConfirm[1],
                cancelButtonText: "Cancelar",
                confirmButtonText: "Si, eliminar cita",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post("/Administrador/delete-citas", i).then((res) => {
                        if (res.data.status == 200) {
                            this.getResults();
                            Swal.fire("Aprobado", res.data.msg, "success");
                        } else if (res.data.status == 422) {
                            Swal.fire("error", res.data.msg, "error");
                        }
                    });
                }
            });
        },
        see_invoces(patient_id) {
            window.location.href = '/Pacientes/citasPaciente/' + patient_id
        },
    },
    computed: {
        length(i) {
            return i.length;
        },
    },
    components: {
        top,
        foot,
        pagination,
        gestion,
        Modal,
        Select2
    },
};
</script>
<style lang="css">
.text-light-gray {
    color: lightgray !important;
}

a>p {
    color: #fff;
}

.for-payment td {
    background-color: #e1fea4;
}

.for-canceled td {
    background-color: #fadcdc;
}

.top-2r {
    position: relative;
    top: 2.3rem;
}
</style>
