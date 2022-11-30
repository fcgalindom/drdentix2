<template>
    <section class="home-section">
        <top />
        <div class="container mb-3">
            <div class="row mt-4 mb-3">
                <div class="col-9 col-sm-8 col-md-10">
                    <button class="btn btn-link d-none d-sm-inline">
                        <i class="fas fa-circle"></i>
                    </button>
                    <h5 class="d-inline">Odontólogos</h5>
                </div>
                <div class="col-3 col-sm-4 col-md-2 text-end">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-principal rounded-pill" @click="edit(null)">
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
                        <input type="text" class="form-control" v-model="filter.name">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="">Cédula</label>
                        <input type="text" class="form-control" v-model="filter.document">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="">Ciudad</label>
                        <input type="text" class="form-control" v-model="filter.city">
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center align-items-center mb-3">
                <button type="button" class="btn btn-verde" @click="getResults()">Buscar</button>
            </div>
        </div>

        <div class="container table-responsive text-center">
            <table class="table text-gray">
                <thead class="bg-blue text-white">
                    <tr>
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Email</th>
                        <th>Ciudad</th>
                        <th>Cant. procedimientos</th>
                        <th>Editar</th>
                        <th>Estado</th>
                        <th>Horario</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(i, index) in dentists.data" :key="index">
                        <td>{{ i?.name }}</td>
                        <td>{{ i?.user?.document }}</td>
                        <td>{{ i?.user?.email }}</td>
                        <td>{{ i?.city }}</td>
                        <td>{{ i?.procedures.length }}</td>
                        <td>
                            <button data-bs-toggle="modal" data-bs-target="#store"
                                class="btn btn-transparent text-gray shadow-none" @click="edit(i)">
                                <i class="fas fa-pen fa-lg"></i>
                            </button>
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" true-value="Activo"
                                    false-value="Inactivo" :id="'customSwitch' + index" @change="destroy(i)"
                                    v-model="i.user.state" checked="" autocompleted="" />
                                <label class="form-check-label" :for="'customSwitch' + index"></label>
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-transparent text-gray" @click="myschedule(i.user)">
                                <i class="fas fa-clock fa-lg"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :users="dentists" @pagi="getResults($event)" />
        </div>
        <foot />
    </section>

    <Modal id="store" maxWidth="xl" title="Odontólogo">
        <div class="row container-fluid justify-content-evenly">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="form-group">
                    <Label required="1">Nombre</Label>
                    <Input :error="errors.name" maxlength="50" v-model="dentist.name" />
                </div>
            </div>
            <div class="d-none d-lg-block col-lg-2"></div>
            <div class="col-12 col-md-6 col-lg-5">
                <div class="form-group">
                    <Label required="1"> Ciudad </Label>
                    <Input :error="errors.city" v-model="dentist.city" />
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-5">
                <div class="form-group">
                    <Label required="1"> Cédula </Label>
                    <Input :error="errors.document" v-model="dentist.document" />
                </div>
            </div>
            <div class="d-none d-lg-block col-lg-2"></div>
            <div class="col-12 col-md-6 col-lg-5">
                <div class="form-group">
                    <Label>Correo electronico</Label>
                    <Input :error="errors.email" v-model="dentist.email" />
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-5" v-if="visible">
                <div class="form-group">
                    <Label required="1"> Contraseña</Label>
                    <Input type="password" :error="errors.password" v-model="dentist.password" />
                </div>
            </div>
            <div class="d-none d-lg-block col-lg-2" v-if="visible"></div>
            <div class="col-12 col-md-6 col-lg-5" v-if="visible">
                <div class="form-group">
                    <Label required="1"> Confirmar contraseña </Label>
                    <Input type="password" :error="errors.confPassword" v-model="dentist.confPassword" />
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-5" style="margin-left: -11px">
                    <div class="form-group">
                        <Label required="1"> Procedimientos </Label>
                        <Select2 v-model="procedure" :options="procedures" placeholder="Seleccione" class="select-bg" @select="add_procedure($event)" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-10 col-lg-5 mt-3">
            <ul class="p-0">
                <li class="d-flex justify-content-between align-items-center mb-3"
                    v-for="(i, index) in dentist.procedures" :key="index">
                    <span class="color-gris"><button class="btn btn-transparent align-icon">
                            <i class="fas fa-circle fa-sm color-blue"></i>
                        </button>
                        {{ i.text ? i.text : i.name }}</span>
                    <button type="button" class="btn bg-red btn-sm btn-size" @click="destroy_procedure(index)">
                        <span class="btn-center f-bold">Delete</span>
                    </button>
                </li>
            </ul>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-blue btn-submit" @click="store('crear', {})">
                <span class="btn-center f-bold">Guardar</span>
            </button>
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
import Modal from "@/Components/Modal.vue";
import Label from "@/Components/Label.vue";
import Input from "@/Components/Input.vue";
import Select2 from "vue3-select2-component";

export default {
    data() {
        return {
            dentists: {},
            dentist: {
                id: 0,
                name: "",
                document: "",
                city: "",
                password: "",
                confPassword: "",
                procedures: [],
            },
            procedures: [],
            procedure: { id: 0, name: "" },
            visible: false,
            filter: { name: '', document: '', city: '' },
            isLoading: false,
            errors: {}
        };
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults(page = 1) {
            axios.put(route('administrator.dentist.index') + "?page=" + page, this.filter).then((res) => {
                this.dentists = res.data.dentist;
                this.procedures = res.data.procedures;
            });
        },
        myschedule(i) {
            window.location.href = '/Administrador/MySchedule/' + i.id
        },
        edit(i) {
            this.errors = {}
            this.$openModal('store')
            if (i == null) {
                this.visible = true
                this.dentist = {
                    id: 0,
                    name: "",
                    document: "",
                    email: "",
                    city: "",
                    procedures: [],
                    id_user: ''
                };
            } else {
                this.visible = false
                this.dentist = {
                    id: i.id,
                    name: i.name,
                    document: i.user.document,
                    email: i.user.email,
                    city: i.city,
                    procedures: i.procedures,
                    id_user: i.id_user,
                };
            }
        },
        store() {
            this.isLoading = true
            axios.post(route('administrator.dentist.store'), this.dentist)
                .then((res) => {
                    if (res.data.status == 200) {
                        Swal.fire("Éxito", res.data.msg, "success");
                        this.getResults();
                        this.dentist = {
                            id: 0,
                            name: "",
                            document: "",
                            city: "",
                            password: "",
                            confPassword: "",
                            procedures: [],
                        };
                        $("#store").trigger("click");
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
            axios.post("/Administrador/destroy-Odontologo", i).then((res) => {
                Swal.fire("Éxito", res.data.msg, "success");
            });
        },
        add_procedure(i) {
            let val = this.dentist.procedures.filter((x) => x.id == i.id);
            if (val.length == 0) {
                if (i != "" && i != null && i != undefined) {
                    this.dentist.procedures.push(i);
                }
            }
        },
        destroy_procedure(index) {
            this.dentist.procedures.splice(index, 1);
        },
    },
    components: {
        top,
        foot,
        pagination,
        Modal,
        Label,
        Loading,
        Select2,
        Input
    },
};
</script>

<style lang="css">
    .select-bg .select2-selection {
        background-color: white;
    }

    .select-bg .select2 {
        width: 100% !important;
    }

    .select-bg .select2-selection__rendered {
        color: #999 !important;
    }

    .select-bg .select2-selection__placeholder {
        color: #999 !important;
    }
</style>
