<template>
    <section class="home-section">
        <top />
        <div class="container mb-3">
            <div class="row mt-4 mb-3">
                <div class="col-9 col-sm-8 col-md-10">
                    <button class="btn btn-link d-none d-sm-inline">
                        <i class="fas fa-circle"></i>
                    </button>
                    <h5 class="d-inline">Sucursales</h5>
                </div>
                <div class="col-3 col-sm-4 col-md-2 text-end">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-principal rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" @click="store(null)">
                            <i class="fas fa-plus mx-1"></i>
                            <span class="d-none d-sm-inline">Crear</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container table-responsive text-center">
            <table class="table text-gray">
                <thead class="bg-blue text-white">
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Contacto</th>
                        <th>Ciudad</th>
                        <th>Editar</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(i, index) in branchs.data" :key="index">
                        <td>{{ i?.name }}</td>
                        <td>{{ i?.address }}</td>
                        <td>{{ i?.contact }}</td>
                        <td>{{ i?.city }}</td>
                        <td>
                            <button class="btn btn-transparent text-gray shadow-none" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" @click="store(i)">
                                <i class="fas fa-pen fa-lg"></i>
                            </button>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" true-value="Activo"
                                        false-value="Inactivo" :id="'customSwitch' + index" @change="destroy(i)"
                                        v-model="i.state" />
                                    <label class="form-check-label" :for="'customSwitch' + index"></label>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :users="branchs" @pagi="getResults($event)" />
        </div>

        <foot />
    </section>

    <Modal id="exampleModal" maxWidth="sm" :title="title">
        <div class="row">
            <div class="container">
                <div class="col-12 mb-3">
                    <Label required="1">Nombre</Label>
                    <Input v-model="branch.name" :error="errors.name" placeholder="Nombre" />
                </div>
                <div class="col-12 mb-3">
                    <Label required="1">Dirección</Label>
                    <Input placeholder="Dirección" :error="errors.address" aria-label="Dirección"
                        v-model="branch.address" />
                </div>
                <div class="col-12 mb-3">
                    <Label required="1">Contacto</Label>
                    <Input placeholder="Contacto" aria-label="Contacto" v-model="branch.contact"
                        :error="errors.contact" />
                </div>
                <div class="col-12 mb-3">
                    <Label required="1">Ciudad</Label>
                    <Input placeholder="Ciudad" aria-label="Ciudad" v-model="branch.city" :error="errors.city" />
                </div>

                <div class="col-12 text-center">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-lg bg-azul rounded-pill h2" @click="edit('crear', {})">
                            <span class="center">Crear</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Modal>

</template>
<script>
import top from "@/Layouts/Administrator/Top.vue";
import pagination from "@/Layouts/Paginator.vue";
import foot from "@/Layouts/Administrator/Foot.vue";

import Modal from '@/Components/Modal.vue'
import Label from '@/Components/Label.vue'
import Input from '@/Components/Input.vue'
import DataTable from 'datatables.net-bs5'
export default {
    data() {
        return {
            branchs: {},
            branch: { id: '', name: "", address: "", contact: "", city: "" },
            errors: {},
            title: "",
        };
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults(page = 1) {
            axios.get(route('administrator.branch.index') + "?page=" + page).then((res) => {
                this.branchs = res.data.branch;
            });
        },
        store(i) {
            this.errors = {}
            if (i == null) {
                for (const key in this.branch) this.branch[key] = ''
                this.title = "Nueva sucursal";
            } else {
                for (const key in this.branch) this.branch[key] = i[key]
                this.title = "Editar sucursal";
            }
        },
        edit() {
            axios.post(route('administrator.branch.store'), this.branch).then((res) => {
                if (res.data.status == 200) {
                    Swal.fire("Éxito", res.data.msg, "success");
                    this.getResults();
                    $("#exampleModal").trigger("click");
                    for (const key in this.branch) this.branch[key] = ''
                }
            }).catch(errors => {
                this.errors = errors.response.data.errors
            })
        },
        destroy(i) {
            axios.post(route('administrator.branch.destroy'), i).then((res) => {
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


