<template>
    <section class="home-section">
        <top />

        <div class="container mb-3">
            <div class="row mt-4 mb-3">
                <div class="col-9 col-sm-8 col-md-10">
                    <button class="btn btn-link d-none d-sm-inline">
                        <i class="fas fa-circle"></i>
                    </button>
                    <h5 class="d-inline">Pacientes</h5>
                </div>
                <div class="col-3 col-sm-4 col-md-2 text-end">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-principal rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" @click="edit(null)">
                            <i class="fas fa-plus mx-1"></i>
                            <span class="d-none d-sm-inline">Crear</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row mb-3">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" v-model="filter.name" />
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="">Cédula</label>
                        <input type="text" class="form-control" v-model="filter.document" />
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="">Ciudad</label>
                        <input type="text" class="form-control" v-model="filter.city" />
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center align-items-center mb-3">
                <button type="button" class="btn btn-verde" @click="getResults()">
                    Buscar
                </button>
            </div>
        </div>

        <div class="container-fluid table-responsive text-center" style="font-size: 0.9rem">
            <table class="table">
                <thead class="bg-blue text-white">
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Email</th>
                        <th>Ciudad</th>
                        <th>Teléfono</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <th>Estado</th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(i, index) in patients.data" :key="index">
                        <td>{{ i?.name }}</td>
                        <td>{{ i?.user?.document }}</td>
                        <td>{{ i?.user?.email }}</td>
                        <td>{{ i?.city }}</td>
                        <td>{{ i?.telephone }}</td>
                        <td>
                            <button class="btn btn-transparent text-gray shadow-none" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" @click="edit(i)">
                                <i class="fas fa-pen fa-lg"></i>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-transparent text-gray shadow-none"
                                @click="val_destroy(i)">
                                <i class="fas fa-trash fa-lg"></i>
                            </button>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center position-relative start-50">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" true-value="Activo"
                                        false-value="Inactivo" :id="'customSwitch' + index" @change="destroy(i)"
                                        v-model="i.user.state" />
                                    <label class="form-check-label" :for="'customSwitch' + index"></label>
                                </div>
                            </div>
                        </td>

                        <td style="width: 5%;">
                            <button class="btn btn-transparent text-gray shadow-none" @click="payments(i)"
                                v-if="i.appoinmets_count > 0">
                                <i class="fas fa-eye fa-lg"></i>
                            </button>
                            <strong v-else>No hay facturas disponibles</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :users="patients" @pagi="getResults($event)" />
        </div>

        <foot />
    </section>
    <Modal id="exampleModal" title="Paciente" maxWidth="sm">
        <div class="row">
            <!-- <div class="text-center mb-3">
                <h5 class="modal-title" id="exampleModalLabel">{{ title }}</h5>
            </div> -->

            <div class="container">
                <div class="col-12 mb-3">
                    <Label required="1">Nombre</Label>
                    <Input v-model="patient.name" :error="errors.name" placeholder="Nombre" />
                </div>
                <div class="col-12 mb-3">
                    <Label required="1">Documento</Label>
                    <Input v-model="patient.document" :error="errors.document" placeholder="Documento" />
                </div>
                <div class="col-12 mb-3">
                    <Label required="1">Teléfono</Label>
                    <Input :error="errors.telephone" v-model="patient.telephone" placeholder="Teléfono" />
                </div>
                <div class="col-12 mb-3">
                    <Label>Fecha de nacimiento</Label>
                    <Input v-model="patient.birth" type="date" :error="errors.birth" />
                </div>
                <div class="col-12 mb-3">
                    <Label>Ciudad</Label>
                    <Input :error="errors.city" v-model="patient.city" placeholder="Ciudad" />
                </div>
                <div class="col-12 mb-3">
                    <Label>Email (opcional)</Label>
                    <Input v-model="patient.email" placeholder="Email" />
                </div>

                <div class="col-12 text-center">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-lg bg-azul rounded-pill h2" @click="store('crear', {})">
                            <span class="center">Guardar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Modal>

    <loading v-model:active="isLoading" :is-full-page="fullPage" />
</template>

<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import top from "@/Layouts/Administrator/Top.vue";
import foot from "@/Layouts/Administrator/Foot.vue";
import pagination from "@/Layouts/Paginator.vue";
import Label from '@/Components/Label.vue'
import Input from '@/Components/Input.vue'
import Modal from '@/Components/Modal.vue'
export default {
    data() {
        return {
            patients: {},
            filter: { name: "", document: "", city: "" },
            patient: {
                id: 0,
                name: "",
                document: "",
                email: "",
                city: "",
                telephone: "",
                birth: "",
            },
            title: "",
            isLoading: false,
            errors: {}
        };
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults(page = 1) {
            this.isLoading = true
            axios
                .put(route('administrator.patient.index') + "?page=" + page, this.filter)
                .then((res) => {
                    this.patients = res.data.patients;
                    this.isLoading = false
                });
        },
        Appoinment() {
            window.location.href = "Administrador/citasAdministrador";
        },

        edit(i) {
            this.errors = {}
            if (i == null) {
                this.patient = {
                    id: 0,
                    name: "",
                    document: "",
                    email: "",
                    city: "",
                    telephone: "",
                    id_user: ''
                };
                this.title = "Nuevo paciente";
            } else {
                this.patient = {
                    id: i.id,
                    name: i.name,
                    document: i.user.document,
                    email: i.user.email,
                    city: i.city,
                    telephone: i.telephone,
                    birth: i.user.birth,
                    id_user: i.id_user

                };
                this.title = "Editar paciente";
            }
        },
        payments(i) {
            window.location.href = "/Pacientes/citasPaciente/" + i.id;
        },
        store() {
            this.isLoading = true
            axios.post(route('administrator.patient.store'), this.patient).then((res) => {
                if (res.data.status == 200) {
                    $("#exampleModal").trigger("click");
                    Swal.fire("Éxito", res.data.msg, "success").then(() => {
                        if (res.data.prefix == '+57') {
                            // alert('entro')
                            window.location.href = '/Administrador/citaAdminxPaciente/' + res.data.patient.id;
                        }
                    });
                    this.getResults();
                    this.patient = {
                        id: 0,
                        name: "",
                        document: "",
                        email: "",
                        city: "",
                        telephone: "",
                    };
                } else if (res.data.status == 422) {
                    Swal.fire("Error", res.data.msg, "error");
                }
                this.isLoading = false
            }).catch(errors => {
                this.isLoading = false
                this.errors = errors.response.data.errors
            });
        },
        destroy(i) {
            axios.post("/Administrador/Paciente-destroy", i).then((res) => {
                Swal.fire("Éxito", res.data.msg, "success");
            });
        },
        val_destroy(i) {
            Swal.fire({
                title: "¡Advertencia!",
                text: "¿Estás seguro que quieres eliminar este paciente?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#7fca1f",
                cancelButtonColor: "#fe0000",
                confirmButtonText: "CANCELAR",
                cancelButtonText: "ELIMINAR",
            }).then((result) => {
                if (!result.isConfirmed) {
                    i.user.state = 'Eliminado'
                    axios.post('/Administrador/Paciente-destroy', i).then(() => {
                        Swal.fire('Éxito', 'Paciente eliminado con éxito', 'success');
                        this.getResults()
                    })
                }
            });
        },
    },
    components: {
        top,
        foot,
        pagination,
        Label,
        Modal,
        Loading,
        Input
    },
};
</script>
<style lang="css">
.form-check-input:checked {
    background-color: #01c001;
    border-color: #01c001;
}
</style>
