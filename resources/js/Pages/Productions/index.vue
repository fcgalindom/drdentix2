<template>
    <Top />
    <div class="container-fluid mb-3">
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

    <div class="container-fluid table-responsive text-center">
        <table class="table text-gray">
            <thead class="bg-blue text-white">
                <tr>
                    <th>N*</th>
                    <th>Medicumentos (principio activo) /DISPOSITIVO MEDICO / INSUMO(DESCRIPCION)</th>
                    <th>CONCENTRACION / MARCA DEL DISPOSITIVO</th>
                    <th>CANTIDAD</th>
                    <th>FORMA FARMACEUTICA</th>
                    <th>PRESENTACION COMERCIAL</th>
                    <th>UNIDAD DE MEDIDA</th>
                    <th>LOTE/SERIE</th>
                    <th>REGISTRO SANITARIO INVIMA</th>
                    <th>FECHA DE VENCIMIENTO</th>
                    <th>SEFAMOFORO</th>
                    <th>FECHA DE INGRESO</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(i, index) in prducts.data" :key="index" >
                    <td>{{ i?.id }}</td>
                    <td>{{ i?.active_principle }}</td>
                    <td>{{ i?.concentration }}</td>
                    <td>{{ i?.amount }}</td>
                    <td>{{ i?.pharmaceutical_form }}</td>
                    <td>{{ i?.commercial_presentation }}</td>
                    <td>{{ i?.medication_unit }}</td>
                    <td>{{ i?.batch }}</td>
                    <td>{{ i?.health_register_Invima }}</td>
                    <td>{{ i?.expiration_date }}</td>
                    <td style="background-color:red; color: black" v-if="i?.semaphore == 'rojo'">{{ i?.semaphore }}</td>
                    <td style="background-color:yellow; color: black" v-if="i?.semaphore == 'amarillo'">{{ i?.semaphore
                    }}
                    </td>
                    <td style="background-color:green; color: black" v-if="i?.semaphore == 'verde'">{{ i?.semaphore }}
                    </td>
                    <td>{{ i?.date_of_admission }}</td>
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
        <!-- <pagination :users="branchs" @pagi="getResults($event)" /> -->
    </div>



    <!-- empieza la modal -->
    <Modal id="exampleModal" maxWidth="xl" :title="title">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <Label required="1">Principio activo</Label>
                    <Input v-model="prduct.active_principle" :error="errors.active_principle"
                        placeholder="Principio activo" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">Concentracion</Label>
                    <Input v-model="prduct.concentration" :error="errors.concentration" placeholder="Concentracion" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">Cantidad</Label>
                    <Input type="number" v-model="prduct.amount" :error="errors.amount" placeholder="Cantidad" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">FORMA FARMACEUTICA</Label>
                    <Input v-model="prduct.pharmaceutical_form" :error="errors.pharmaceutical_form"
                        placeholder="FORMA FARMACEUTICA" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">PRESENTACION COMERCIAL</Label>
                    <Input v-model="prduct.commercial_presentation" :error="errors.commercial_presentation"
                        placeholder="PRESENTACION COMERCIAL" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">UNIDAD DE MEDIDA</Label>
                    <Input v-model="prduct.medication_unit" :error="errors.medication_unit"
                        placeholder="UNIDAD DE MEDIDA" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">LOTE/SERIE</Label>
                    <Input v-model="prduct.batch" :error="errors.batch" placeholder="LOTE/SERIE" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">REGISTRO SANITARIO INVIMA</Label>
                    <Input v-model="prduct.health_register_Invima" :error="errors.health_register_Invima"
                        placeholder="REGISTRO SANITARIO INVIMA" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">FECHA DE VENCIMIENTO</Label>
                    <Input type="date" v-model="prduct.expiration_date" :error="errors.expiration_date"
                        placeholder="FECHA DE VENCIMIENTO" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">FECHA DE INGRESO</Label>
                    <Input type="date" v-model="prduct.date_of_admission" :error="errors.date_of_admission"
                        placeholder="FECHA DE INGRESO" />
                </div>
                <div class="d-flex justify-content-center">
                    <Button @click="edit('crear', {})"> Crear </Button>
                </div>
            </div>
        </div>
    </Modal>

    <Foot />

</template>
<script>
import Top from "@/Layouts/Administrator/Top.vue";
import pagination from "@/Layouts/Paginator.vue";
import Foot from "@/Layouts/Administrator/Foot.vue";
import desp from "@/Layouts/Administrator/Desp.vue";
import Modal from '@/Components/Modal.vue'
import Button from '@/Components/Button.vue'
import Label from '@/Components/Label.vue'
import Input from '@/Components/Input.vue'
export default {
    data() {
        return {
            prducts: {},
            prduct: { id: '', active_principle: "", concentration: "", amount: "", pharmaceutical_form: "", commercial_presentation: "", medication_unit: "", batch: "", health_register_Invima: "", expiration_date: "", date_of_admission: "" },
            errors: {},
            title: "",
        };
    },
    created() {
        this.getResults();
    },
    methods: {
        store(i) {
            this.errors = {}
            if (i == null) {
                for (const key in this.prduct) this.prduct[key] = ''
                this.title = "Nuevo producto";
            } else {
                for (const key in this.prduct) this.prduct[key] = i[key]
                this.title = "Editar producto";
            }
        },
        getResults(page = 1) {
            axios.get(route('administrator.products.index') + "?page=" + page).then((res) => {
                this.prducts = res.data.products;

            });
        },
        edit() {
            axios.post(route('administrator.products.store'), this.prduct).then((res) => {
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
            axios.post(route('administrator.products.destroy'), i).then((res) => {
                Swal.fire("Éxito", res.data.msg, "success");
            });
        },
    },
    components: {
        Top,
        Foot,
        pagination,
        desp,
        Modal,
        Label,
        Input,
        Button
    },
};
</script>
