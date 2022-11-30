<template>
    <nav class="navbar navbar-dark bg-white navbar-expand-md">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center w-100 flex-column flex-md-row">
                <div class="col-12 col-lg-3">
                    <a class="navbar-brand" href="#">
                        <img src="../../Img/logo.png" alt="" class="size-image" />
                    </a>
                </div>
                <div class="btn-header col-12 col-lg-9 d-flex justify-content-md-end justify-content-center">
                    <div class="d-flex col-6">
                        <button @click="modal_verify()">Verificar citas</button>
                        <button class="mx-2" @click="Appoinment()">Agendar cita</button>
                        <button class="mx-2" @click="modal" data-bs-toggle="modal"
                            data-bs-target="#modal_crear_paciente">
                            Crear paciente
                        </button>
                    </div>
                    <div class="col-6">
                        <Select2 v-model="id_select2" :options="patients" :settings="{ width: '100%' }"
                            placeholder="Seleccione" @select="v_select2(id_select2)" />
                    </div>
                    <!-- <button>Buscar paciente</button> -->
                </div>
            </div>
        </div>
    </nav>

    <hr />

    <Modal id="modal_crear_paciente" maxWidth="sm" title="Crear paciente">
        <div class="row">
            <div class="text-center mb-3">
                <h5 class="modal-title" id="exampleModalLabel">{{ title }}</h5>
            </div>

            <div class="container">
                <div class="col-12 mb-3">
                    <Label required="1">Nombre</Label>
                    <Input :error="errors.name" v-model="patient.name" placeholder="Nombre" />
                </div>
                <div class="col-12 mb-3">
                    <Label required="1">Documento</Label>
                    <Input :error="errors.document" v-model="patient.document" placeholder="Documento" />
                </div>

                <div class="col-12 mb-3">
                    <Label required="1">Teléfono</Label>
                    <Input :error="errors.telephone" v-model="patient.telephone" placeholder="Teléfono" />
                </div>

                <div class="col-12 mb-3">
                    <Label>Fecha de nacimiento</Label>
                    <div class="d-flex p-0-col-4">
                        <div class="col-3 cols-p-0">
                            <select class="form-select" v-model="fecha.day">
                                <option value="" disabled>Día</option>
                                <option v-for="(i, index) in days" :key="index" :value="i" v-text="i"></option>
                            </select>
                        </div>
                        <div class="col-5 cols-p-0">
                            <select class="form-select" v-model="fecha.mount" @change="mount_number">
                                <option value="" disabled>Mes</option>
                                <option v-for="(i, index) in mounts" :key="index" :value="i" v-text="i">
                                </option>
                            </select>
                        </div>
                        <div class="col-4 cols-p-0">
                            <select class="form-select" v-model="fecha.year">
                                <option value="" disabled>Año</option>
                                <option v-for="(i, index) in years" :key="index" :value="i" v-text="i"></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <Label>Ciudad</Label>
                    <Input v-model="patient.city" placeholder="Ciudad" />
                </div>
                <div class="col-12 mb-3">
                    <Label>Email (opcional)</Label>
                    <Input v-model="patient.email" placeholder="Email" />
                </div>
                <div class="col-12 text-center">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-lg bg-azul rounded-pill h2" @click="store">
                            <span class="center">Crear</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Modal>

    <Modal id="modal_verificar_citas" title="Verificar citas">
        <div class="row">
            <div class="col-12 mb-3">
                <Label>Cédula</Label>
                <Input v-model="verify.document" />
            </div>
            <div class="col-12 d-flex justify-content-center">
                <Button @click="verify_appoinments()">Verificar</Button>
            </div>
        </div>
    </Modal>
</template>


<script>
import Select2 from 'vue3-select2-component';
import Modal from '@/Components/Modal.vue'
import Label from '@/Components/Label.vue'
import Input from '@/Components/Input.vue'
import Button from '@/Components/Button.vue'
export default {
    data() {
        return {
            myValue: '',
            patient: {},
            patients: [],
            redirection: {},
            verify: {
                document: ''
            },
            fecha: {
                dia: false,
                mes: false,
                ano: false,
            },
            days: [],
            mounts: this.$months_array(),
            years: [],
            id_select2: 0,
            fecha: {
                day: "",
                mount: "",
                year: "",
                number: "",
            },
            errors: {},
        };
    },
    created() {
        if (window.innerWidth > 992) $('.fa-bars').click()
        this.getResults();
    },
    methods: {
        getResults() {
            axios.post(route('administrator.patients_top')).then((res) => {
                this.patients = res.data.patients;
                for (let index = 1; index <= 31; index++) {
                    this.days.push(index);
                }

                for (let index = 1920; index <= new Date().getFullYear(); index++) {
                    this.years.push(index);
                }
                this.years.reverse();
            });
        },
        Appoinment() {
            window.location.href = "/Administrador/citasAdministrador";
        },
        store() {
            this.patient.type = 1;
            this.patient.id = 0;
            this.validator_date()
            axios.post("/Administrador/Paciente-store", this.patient).then((res) => {
                if (res.data.status == 422) {
                    Swal.fire("Error", res.data.msg, "error");
                } else if (res.data.status == 200) {
                    $("#modal_crear_paciente").trigger("click");
                    Swal.fire("Éxito", res.data.msg, "success").then(() => {
                        console.log('patient', res.data)
                        window.location.href = '/Administrador/citaAdminxPaciente/' + res.data.patient.id;
                    });
                }
            }).catch(errors => {
                this.isLoading = false
                this.errors = errors.response.data.errors
            })
        },
        modal() {
            $("#modal_crear_paciente").trigger("click");
        },
        v_select2(id) {
            window.location.href = "/Administrador/verCitas/" + id;
        },
        validator_date() {
            if (this.fecha.day != "" && this.fecha.mount != "" && this.fecha.year != "") {
                this.patient.birth = this.fecha.year + "-" + this.fecha.number + "-" + this.fecha.day;
                return true;
            }
        },
        mount_number() {
            let index = 0;
            this.mounts.forEach((item) => {
                index++;
                if (item == this.fecha.mount) {
                    this.fecha.number = index;
                }
            });
        },
        modal_verify() {
            $('#modal_verificar_citas').modal('show')
        },
        verify_appoinments() {
            axios.post(route('administrator.verify_appoinments'), this.verify).then(res => {
                if (res.data.status == 200) window.location.href = '/Administrador/verCitas/' + res.data.id
                else if (res.data.status == 422) {
                    this.patient.document = res.data.document
                    alert('Este paciente no se encuentra registrado')
                    $('#modal_verificar_citas').modal('hide')
                    $('#modal_crear_paciente').modal('show')
                }
            })
        }
    },
    components: {
        Select2,
        Modal,
        Label,
        Input,
        Button
    },
};
</script>


<style>
.bg-blue {
    background-color: #00aff1;
}

.p-0-col-4 .cols-p-0 {
    padding: 0;
}

.p-0-col-4 .cols-p-0 select {
    box-shadow: none;
    font-size: .85rem;
}

.modal-body {
    padding: 1rem !important;
}

.bg-pink {
    background-color: #ff3366;
    border: 1px solid #ff3366;
}

.select2-container--default .select2-selection--single {
    border-radius: 12px !important;
    background: #7cb91d;
}

.select2-selection__rendered {
    color: white !important;
}

.bg-pink::placeholder {
    color: white;
}

.bg-pink:focus {
    background-color: #ff3366;
    border: 1px solid #ff3366;
    color: white;
}

.text-gray {
    color: #9fa4a7;
}

.bg-principal {
    background-color: #013253;
}

.color-principal {
    color: #013253 !important;
}

table {
    border: 1px solid #9fa4a7 !important;
}

hr {
    height: 6px !important;
    background: #013253;
    opacity: 1;
    margin-top: 0px;
    margin-bottom: auto;
    position: relative;
    bottom: 5px;
}

.size-image {
    height: 79px;
    width: 15rem;
    margin-top: -0.7rem;
}

.btn-header button {
    background-color: #7cb91d;
    border: 1px solid #7cb91d;
    color: #fff;
    width: 9rem;
    height: 2.2rem;
    border-radius: 12px;
}

.select2-selection__placeholder {
    color: white !important;
}

.select2-results__option {
    font-size: .9em;
}

@media (max-width: 320px) {
    .size-image {
        position: relative;
        right: 2rem;
    }
}
</style>
