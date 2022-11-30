<template>

    <!-- Start header -->
    <top />
    <!-- End header -->

    <!-- Start data in about of the table -->
    <div class="container mb-3">
        <div class="row mt-4 mb-3">
            <div class="col-9 col-sm-8 col-md-10">
                <button class="btn btn-link d-none d-sm-inline">
                    <i class="fas fa-circle"></i>
                </button>
                <h5 class="d-inline">Procedimientos</h5>
            </div>
            <div class="col-3 col-sm-4 col-md-2 text-end">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-principal rounded-pill" id="prueba" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" @click="edit(null)">
                        <i class="fas fa-plus mx-1"></i>
                        <span class="d-none d-sm-inline">Crear</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- End data in about of the table -->

    <!-- Start table -->

    <div class="container table-responsive text-center">
        <table class="table text-gray">
            <thead>
                <tr class="bg-blue text-white">
                    <th>Nombre</th>
                    <th>Duración</th>
                    <th>Editar</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(i, index) in procudures.data" :key="index">
                    <td>{{ i?.name }}</td>
                    <td>{{ i?.duration }} minutos</td>
                    <td>
                        <button class="btn btn-transparent text-gray shadow-none" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" @click="edit(i)">
                            <i class="fas fa-pen fa-lg"></i>
                        </button>
                    </td>
                    <td>
                        <div class="
                form-check form-switch
                d-flex
                align-items-center
                justify-content-center
              ">
                            <input class="form-check-input" type="checkbox" true-value="Activo" false-value="Inactivo"
                                :id="'customSwitch' + index" @change="destroy(i)" v-model="i.state" checked=""
                                autocompleted="" />
                            <label class="form-check-label" :for="'customSwitch' + index"></label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <pagination :users="procudures" @pagi="getResults($event)" />
    </div>

    <!-- End table -->

    <!-- Start footer -->
    <foot />
    <!-- End footer -->


    <!-- Start modal -->

    <Modal id="exampleModal" maxWidth="sm" :title="title" verticalCenter="1">
        <div class="row">

            <div class="container">
                <div class="col-12 mb-3">
                    <Label required="1"> Nombre </Label>
                    <Input :error="errors.name" v-model="procudure.name" placeholder="Nombre"
                        aria-label="Nombre" />
                </div>
                <div class="col-12 mb-3">
                    <Label required="1"> Duración </Label>
                    <Input :error="errors.duration" v-model="procudure.duration" placeholder="Duración"
                        aria-label="Duración" />
                </div>

                <div class="col-12 text-center">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-lg bg-azul rounded-pill h2" @click="store('crear', {})">
                            <span class="center">Crear</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Modal>

    <!-- End modal -->
</template>
<script>
import top from "@/Layouts/Administrator/Top.vue";
import foot from "@/Layouts/Administrator/Foot.vue";
import pagination from "@/Layouts/Paginator.vue";
import Modal from "@/Components/Modal.vue";
import Label from "@/Components/Label.vue";
import Input from "@/Components/Input.vue";

export default {
    data() {
        return {
            procudures: {},
            procudure: { id: 0, name: "", duration: "" },
            title: "",
            errors: {}
        };
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults(page = 1) {
            axios
                .get("/Administrador/Procedimientos-index?page=" + page)
                .then((res) => {
                    this.procudures = res.data.procedures;
                });
        },
        edit(i) {
            this.errors = {}
            if (i == null) {
                this.title = "Nuevo procedimiento";
                this.procudure = { id: 0, name: '', duration: '' };
            } else {
                this.procudure = { id: i.id, name: i.name, duration: i.duration };
                this.title = "Editar procedimiento";
            }
        },
        store() {
            axios
                .post("/Administrador/store-procedure", this.procudure)
                .then((res) => {
                    if (res.data.status == 200) {
                        Swal.fire("Éxito", res.data.msg, "success");
                        $("#exampleModal").trigger("click");
                        this.getResults();
                        this.procudure = { id: 0, name: "", duration: "" };
                    } else if (res.data.status == 500) {
                        Swal.fire("Error", res.data.msg, "error");
                    }
                }).catch(errors => {
                    this.isLoading = false
                    this.errors = errors.response.data.errors
                });;
        },
        destroy(i) {
            axios.post("/Administrador/destroy-procedure", i).then((res) => {
                Swal.fire("Éxito", res.data.msg, "success");
            });
        },
    },
    components: {
        top,
        foot,
        pagination,
        Modal,
        Label,
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

