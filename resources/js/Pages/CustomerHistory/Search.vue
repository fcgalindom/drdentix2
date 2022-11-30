<template>
    <Top />
    <div class="container my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <Label> Número de cédula </Label>
                    <Input v-model="filter.document" />
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 d-flex justify-content-center">
                    <Button @click="getClient()">Filtrar</Button>
                </div>
            </div>
        </div>
        <div class="mt-4" v-if="!$isEmpty(appoinments_visible)">
            <div class="card mb-3" v-for="(i, index) in appoinments.data" :key="index">
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
                                <p>{{ i.hour }}</p>
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
                                <p>{{ i.day }}</p>
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
                        <button type="button" class="btn btn-red-danger rounded-pill prl-3 w-10r"
                            v-if="i.state == 'Pagado'" @click="download_pdf(i)">
                            Mi factura
                        </button>
                    </div>
                </div>
            </div>
            <pagination :users="appoinments" @pagi="getClient($event)" />
            <!-- <AppoinmentForPatient :document="filter.document" /> -->
        </div>
    </div>
    <Foot />
</template>
<script>
import Top from "@/Layouts/Administrator/Top.vue";
import Foot from "@/Layouts/Administrator/Foot.vue";
import Label from '@/Components/Label.vue'
import Input from '@/Components/Input.vue'
import Button from '@/Components/Button.vue'
import Paginator from "laravel-vue-pagination";
import AppoinmentForPatient from '@/Layouts/Appoinments/AppoinmentForPatient.vue'

export default {
    components: {
        Top,
        Foot,
        Input,
        Label,
        AppoinmentForPatient,
        Button
    },
    data() {
        return {
            filter: { document: '' },
            appoinments_visible: false,
            appoinments: {}
        }
    },
    methods: {
        getClient(page = 1) {
            // this.appoinments_visible = true
            let url = route('administrator.citas.pacienteDado') + '?page=' + page
            axios.post(url, { document: this.filter.document }).then((res) => {
                this.appoinments = res.data.appoinments;
            });
        },
        download_pdf(i) {
            window.open("/Pacientes/download_pdf?key=" + i.id);
        },
    }
}
</script>
