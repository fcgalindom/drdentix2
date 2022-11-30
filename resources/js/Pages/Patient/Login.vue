<template>
    <section class="slider d-flex justify-content-center align-items-center">
        <div class="">
            <div class="container text-center mb-5">
                <img src="../../Img/logo.png" class="size-img" alt="" />
            </div>
            <div class="container">
                <div class="form-group">
                    <label for="" class="text-white">Cédula</label>
                    <input class="form-control rounded-pill" type="text" placeholder="Cédula"
                        v-model="credentials.document" />
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-link text-white" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        ¿No tienes una cuenta?, regístrate
                    </button>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <button type="button" class="btn btn-login btn-lg rounded-pill" @click="login">
                        <b>Iniciar sesión</b>
                    </button>
                </div>
            </div>
        </div>

        <Modal id="exampleModal" title="Crea tu cuenta" maxWidth="sm">
            <div class="row">
                <div class="text-center mb-3">
                    <h5 class="modal-title" id="exampleModalLabel">{{ title }}</h5>
                </div>

                <div class="container">
                    <div class="col-12 mb-3">
                        <Label required="1"> Nombres y apellidos (completos) </Label>
                        <input class="form-control" v-model="patient.name" type="text" />
                    </div>
                    <div class="col-12 mb-3">
                        <Label required="1"> Documento </Label>
                        <input class="form-control" v-model="patient.document" type="text" />
                    </div>

                    <div class="col-12 mb-3">
                        <Label required="1"> Fecha de nacimiento </Label>
                        <div class="d-flex">
                            <div class="col-4">
                                <select name="" id="" class="form-select" v-model="fecha.day">
                                    <option value="" disabled>Día</option>
                                    <option v-for="(i, index) in days" :key="index" :value="i" v-text="i">
                                    </option>
                                </select>
                            </div>
                            <div class="col-4">
                                <select name="" id="" class="form-select" v-model="fecha.mount" @change="mount_number">
                                    <option value="" disabled>Mes</option>
                                    <option v-for="(i, index) in mounts" :key="index" :value="i" v-text="i">
                                    </option>
                                </select>
                            </div>
                            <div class="col-4">
                                <select name="" id="" class="form-select" v-model="fecha.year">
                                    <option value="" disabled>Año</option>
                                    <option v-for="(i, index) in years" :key="index" :value="i" v-text="i">
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <Label required="1"> Ciudad </Label>
                        <input class="form-control" v-model="patient.city" type="text" />
                    </div>
                    <div class="col-12 mb-3">
                        <Label required="1"> Email (opcional) </Label>
                        <input class="form-control fs-p-1" v-model="patient.email" type="text"
                            placeholder="Correo (Puede ser Hotmail o Gmail)" />
                    </div>
                    <div class="col-12 mb-3">
                        <Label required="1"> Teléfono </Label>
                        <input class="form-control" v-model="patient.telephone" type="text" />
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

    </section>
</template>



<script>
import Modal from '@/Components/Modal.vue'
import Label from '@/Components/Label.vue'

export default {
    data() {
        return {
            credentials: { document: "" },
            days: [],
            mounts: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
            ],
            years: [],
            patient: {},
            title: "",
            fecha: {
                day: "",
                mount: "",
                year: "",
                number: "",
            },
        };
    },
    beforeMount() {
        // axios.get(route('web.is_log')).then(res => {
        //     if (!this.$isEmpty(res.data)) {
        //         if (res.data.type_user == 'Patient') {
        //             window.location.href = route('patient.citas')
        //         } else {
        //             window.location.href = route('web.web.login_admin')
        //         }
        //     }
        // })
    },
    created() {
        for (let index = 1; index <= 31; index++) {
            this.days.push(index);
        }

        for (let index = 1920; index <= new Date().getFullYear(); index++) {
            this.years.push(index);
        }
        this.years.reverse();
    },
    methods: {
        login() {
            axios.post("/loginP", this.credentials).then((res) => {
                if (res.data.status == 422) {
                    Swal.fire("Error", res.data.msg, "error");
                } else if (res.data.status == 200) {
                    window.location.href = "/Pacientes/citas";
                }
            });
        },
        store() {
            this.patient.type = 1;
            this.patient.id = 0;
            this.validator_date()
            axios.post("/Administrador/Paciente-store", this.patient).then((res) => {
                if (res.data.status == 422) {
                    if (res.data.msg == "El valor del campo Documento ya se encuentra registrado.") {
                        res.data.msg = "Ya estás registrado, solo ingresa tu número de cédula en el logín";
                        $("#exampleModal").trigger("click");
                    }
                    Swal.fire("Error", res.data.msg, "error");
                } else if (res.data.status == 200) {
                    $("#exampleModal").trigger("click");

                    window.location.href = "/Pacientes/citas";
                }
            });
        },
        validator_date() {
            if (
                this.fecha.day != "" &&
                this.fecha.mount != "" &&
                this.fecha.year != ""
            ) {
                this.patient.birth =
                    this.fecha.year + "-" + this.fecha.number + "-" + this.fecha.day;
                return true;
                //   } else {
                //     Swal.fire(
                //       "Error",
                //       "Completa el formato de fecha de nacimiento",
                //       "error"
                //     );
                //     return false;
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
    },
    components: {
        Modal,
        Label
    }
};
</script>
