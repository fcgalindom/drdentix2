<template>
    <top v-if="user.type_user != 'Administrator'" />
    <topAdministrator v-else />
    <div class="container-fluid mt-5">
        <div class="d-flex flex-column flex-md-row">
            <div class="d-flex flex-column justify-content-center col-12 col-md-2 ml-md-4"
                v-if="user.type_user != 'Administrator'">
                <h2 class="text-celeste">¿Tienes dudas o consultas adicionales?</h2>
                <p class="color-cafe">
                    Contáctate con nosotros mediante nuestras redes sociales y números
                    telefónicos
                </p>
                <div class="d-flex justify-content-start justify-content-sm-center justify-content-lg-start ml-md-4">
                    <a class="btn btn-transparent text-cel" :href="whatsapp" target="_blank " role="button "><i
                            class="fab fa-whatsapp fa-2x"></i></a>
                    <a class="btn btn-transparent text-cel" :href="facebook" target="_blank " role="button "><i
                            class="fab fa-facebook fa-2x"></i></a>
                </div>
            </div>
            <div class="col-12 col-md-1" v-if="user.type_user != 'Administrator'"></div>
            <div class="col-12 pr-4" v-bind:class="[
                user.type_user != 'Administrator' ? 'col-md-9' : 'col-md-12',
            ]">
                <h1 class="mb-5 text-celeste" v-bind:class="[
                    user.type_user == 'Administrator' ? 'text-center fs-1' : '',
                ]">
                    <b>Agenda tu cita</b>
                </h1>
                <div class="row">
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="form-group" v-if="user.type_user != 'Administrator'">
                            <label for="">Paciente</label>
                            <input type="text" class="form-control" disabled v-model="patient.name"
                                style="background: transparent" />
                        </div>
                        <div class="form-group" v-if="user.type_user == 'Administrator'">
                            <Label>Paciente</Label>
                            <!-- <label for=""></label> -->
                            <Select2 v-if="!id_change && patient_state == 0" :options="patients"
                                v-model="appointenment.patientsf" placeholder="-- Selecciona --" />
                            <input v-else type="text" class="form-control" disabled
                                v-model="appointenment.d_pacient.name" style="background: transparent" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="form-group">
                            <label for="">Procedimiento</label>
                            <Select2 v-if="!id_change" :options="procedures" v-model="appointenment.proceduresf"
                                @select="modal2()" :settings="{ placeholder: '-- Selecciona --' }" />
                            <input v-else type="text" class="form-control" disabled
                                v-model="appointenment.denpro.procedures.name" style="background: transparent" />
                            <b class="text-danger">{{ validator.procedure }}</b>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="form-group">
                            <label for="">Día</label>
                            <input :min="min_date" id="date1" data-input type="date" class="form-control"
                                v-model="appointenment.day" @change="val_appointment" :disabled="disabled == 1" />
                            <b class="text-danger">{{ validator.day }}</b>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="form-group">
                            <label for="">Hora</label>
                            <input min="09:00" type="text" class="form-control" v-model="visual.hour" disabled />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="form-group">
                            <label for="">Odontólogo</label>
                            <input type="text" class="form-control" disabled v-model="visual.dentist" />
                        </div>
                        <span v-if="den_val == true" class="text-danger">
                            <b>En este momento no hay odontólogos capacitados para hacer este
                                procedimiento</b>
                        </span>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="">Sucursal</label>
                            <select class="form-select" v-model="appointenment.branchesf">
                                <option value="" disabled>Seleccione</option>
                                <option v-for="(i, index) in branchs" :key="index" :value="i.id" v-text="i.name">
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                v-model="readed" />
                            <label class="form-check-label" for="flexCheckDefault">
                                <p class="color-cafe">
                                    He leído y estoy informado sobre la ley 1581 de 2012 - Ley de
                                    protección de datos personales
                                </p>
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6"></div>
                </div>
                <div class="text-center mb-5">
                    <button type="button" class="btn btn-celeste" @click="store()">
                        Agendar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="d-none" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal1"></button>

    <!-- Modal -->

    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-medium">
            <div class="modal-content">
                <div class="d-flex justify-content-end position-absolute w-100">
                    <button type="button" class="btn-red-close ubication p-2 d-none" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" v-for="(i, index) in schedule" :key="index">
                        <div class="d-flex justify-content-between">
                            <h5 class="text-verde m-0 pl-1 mb-3">
                                <b>{{ i.dentists.name }}</b>
                            </h5>
                            <div class="w-5rem">
                                <button type="button" id="ejecutar"
                                    class="btn-check-dentist rounded-pill fa-5 position-relative bottom-10"
                                    @click="paint_dentist(i.dentists)">
                                    <i class="fas fa-check fa-sm"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-4 d-flex justify-content-center mb-2"
                            v-for="(item, index) in i.dentists.schedules_one" :key="index">
                            <button class="btn-day btn-sm w-4rem rounded-10px">
                                <span>
                                    {{ days[item.day] }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End modal -->

    <!-- Start modal days for date's -->

    <button type="button" class="d-none" id="modal_dates_button" data-bs-toggle="modal" data-bs-target="#modal_dates">
        Launch demo modal
    </button>

    <div class="modal fade" id="modal_dates" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-medium">
            <div class="modal-content rounded-5">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="text-verde m-0 pl-1"><b>Horarios disponibles </b></h5>
                        <button type="button" id="close_modal_hour" class="btn-red-close ubication p-2 d-none"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="row mb-1">
                        <div class="col-6 col-md-4 d-flex justify-content-center mb-2"
                            v-bind:class="[user.type_user != 'Administrator' ? 'col-md-6' : '']"
                            v-for="(i, index) in hours" :key="index">
                            <button class="btn-sug btn-sm w-4rem rounded-10px"
                                v-bind:class="[active[index] == true ? 'btn-sug-focus' : '']"
                                @click="getButton(index, 0)">
                                <span> {{ i.hour_start }} / {{ i.hour_end }} </span>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn-save-day mt-3 mb-1" @click="store_hour">
                            <b>Guardar</b>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End modal days for date's -->

    <foot />
</template>


<script>
import top from "@/Layouts/Patient/TopPatient.vue";
import topAdministrator from "@/Layouts/Administrator/Top.vue";
import foot from "@/Layouts/Administrator/Foot.vue";
import Select2 from 'vue3-select2-component';
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import Label from '@/Components/Label.vue'
import Modal from '@/Components/Modal.vue'

export default {
    props: ["id", "type_petition"],
    data() {
        return {
            schedules: {},
            user: {},
            patient: {},
            appointenment: {
                day: "",
                hour: "",
                branchesf: "",
                dentistf: "",
                patientsf: "",
                proceduresf: "",
                d_pacient: { name: "" },
                type: null,
            },
            disabled: 1,
            readed: false,
            min_date: "",
            procedures: [],
            branchs: [],
            patients: { id: [], name: [] },
            id_select2: ["303", "304"],
            schedule: {},
            visual: { dentist: "", hour: "" },
            active: [false, false, false, false, false, false],
            days: [
                "Domingo",
                "Lunes",
                "Martes",
                "Miercoles",
                "Jueves",
                "Viernes",
                "Sábado",
            ],
            hours: [],
            validator: { procedure: "", day: "" },
            datosP: {},
            id_change: false,
            patient_state: 0,
            datosP2: {},
            facebook: "https://www.facebook.com/Dr.Dentix/",
            whatsapp:
                "https://api.whatsapp.com/send?phone=573156549290&text=Hola Dr. Dentix, tengo dudas para agendar mi cita",
        };
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults() {
            // console.log(this.id);
            if (this.type_petition == 1) {
                if (this.id != "" && !this.id_change) {
                    this.appointenment = this.id
                    this.visual = { dentist: this.appointenment.denpro.dentists.name, hour: "" };
                    this.appointenment.dentistf = this.id.denpro.dentistsF
                    this.appointenment.proceduresf = this.id.denpro.proceduresF
                    this.appointenment.patientsf = this.id.patientsF
                    this.appointenment.branchesf = this.id.branchesF
                    this.appointenment.day = ""
                    this.appointenment.hour = ""
                    this.disabled = 0
                    // this.patient.name = this.appointenment.d_pacient.name
                    // this.filtros.paciente = this.id;
                    this.id_change = true;
                }
            } else if (this.type_petition == 2) {
                if (this.patient_state == 0) {
                    this.appointenment.patientsf = this.id.id
                    this.appointenment.d_pacient.name = this.id.name
                    this.patient_state = 1
                }
            }
            axios.post("/Pacientes/Paciente-citas").then((res) => {
                this.branchs = res.data.branchs;
                this.procedures = res.data.procedures;
                this.patients = res.data.patients;
                this.patient = res.data.patient;
                this.min_date = res.data.min_date;
                this.user = res.data.user;
            });
        },
        modal1(i) {
            axios
                .post("/Pacientes/schedulefordentist", {
                    id: i,
                })
                .then((res) => {
                    this.schedule = res.data.schedule;
                    $("#modal1").trigger("click");
                });
        },
        modal2() {
            this.appointenment.day = "";
            this.appointenment.hour = "";
            this.visual.hour = "";
            axios
                .post("/Pacientes/scheduleforprocedure", {
                    id: this.appointenment.proceduresf,
                })
                .then((res) => {
                    this.schedule = res.data.scheduleP;
                    if (this.schedule.length == 0) {
                        this.validator.procedure =
                            "Error, temporalmente no hay un odóntologo disponible para atender este procedimiento";
                    } else {
                        this.validator.procedure = "";
                        $("#modal1").trigger("click");
                    }
                });
        },
        store() {
            if (this.readed == false) {
                Swal.fire(
                    "Error",
                    "Confirma que has leído la ley 1581 de 2012",
                    "error"
                );
                return;
            }
            if (this.user.type_user == "Patient")
                this.appointenment["patientsf"] = this.patient.id;
            axios
                .post("/Pacientes/Paciente-citasStore", this.appointenment)
                .then((res) => {
                    if (res.data.status == 200) {
                        if (this.user.type_user == "Patient") {
                            Swal.fire("Éxito", "Cita agendada con éxito", "success").then(
                                (res) => {
                                    window.location.href = "/Pacientes/citasPorPaciente";
                                }
                            );
                        } else {
                            Swal.fire("Éxito", "Cita agendada con éxito", "success").then(
                                (res) => {
                                    window.location.href = "/Administrador/verCitas";
                                }
                            );
                        }
                        this.appointenment = {
                            day: "",
                            hour: "",
                            branchesf: "",
                            dentistf: "",
                            patientsf: "",
                            proceduresf: "",
                        };
                    } else if (res.data.status == 422) {
                        Swal.fire("Error", res.data.msg, "error");
                    } else if (res.data.status == 300) {
                        Swal.fire({
                            title: "¡Advertencia!",
                            text: res.data.msg,
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#7fca1f",
                            cancelButtonColor: "#fe0000",
                            cancelButtonText: "Cancelar",
                            confirmButtonText: "Si, Agendar cita",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.appointenment.type = 1;
                                axios
                                    .post("/Pacientes/Paciente-citasStore", this.appointenment)
                                    .then((res) => {
                                        Swal.fire(
                                            "Aprobado",
                                            "Has decidido agendar otra cita",
                                            "success"
                                        ).then((respuesta) => {
                                            window.location.href = "/Administrador/verCitas";
                                        });
                                    });
                            }
                        });
                    }
                });
        },
        getButton(index, x) {
            if (x < this.active.length) {
                if (x == index) {
                    this.active[index] = true;
                } else {
                    this.active[x] = false;
                }
                this.getButton(index, x + 1);
            }
        },

        store_hour() {
            for (let index = 0; index < this.active.length; index++) {
                if (this.active[index] == true) {
                    this.appointenment.hour = this.hours[index].hour_start;
                    this.visual.hour =
                        this.hours[index].hour_start + " / " + this.hours[index].hour_end;
                }
            }
            $("#close_modal_hour").trigger("click");
        },
        paint_dentist(dentist) {
            this.appointenment.dentistf = dentist.id;
            this.appointenment.day = "";
            this.appointenment.hour = "";
            this.visual = { dentist: dentist.name, hour: "" };
            $(".btn-red-close").trigger("click");

            this.disabled = 0;
        },
        val_appointment() {
            this.appointenment.hour = "";
            this.visual.hour = "";
            axios
                .post("/Pacientes/schedulefordate", this.appointenment)
                .then((res) => {
                    if (res.data.status == 422) {
                        this.validator.day = res.data.msg
                        return
                    } else {
                        this.validator.day = ""
                    }
                    this.hours = res.data.hours;

                    this.llenar_active();
                    let msg = "Recuerda que este odontólogo solo atiende los días ";
                    for (let index = 0; index < res.data.schedule1.length; index++) {
                        if (res.data.schedule1[index].attend == 1) {
                            msg += this.days[res.data.schedule1[index].day] + ", ";
                        }
                    }
                    if (res.data.schedule1[res.data.day - 1].attend == 0) {
                        Swal.fire({
                            title: "",
                            text: msg,
                            icon: "info",
                            confirmButtonText: "Ok",
                        });
                    } else {
                        if (res.data.hours.length == 0) {
                            Swal.fire(
                                "Advertencia",
                                "Este odontólogo está ocupado todo el día para la fecha seleccionada ",
                                "warning"
                            );
                        } else {
                            this.appointenment.hour = "";
                            this.visual.hour = "";
                            $("#modal_dates_button").trigger("click");
                        }
                    }
                });
        },
        format_hour(hour) {
            return hour.substring(0, 5);
        },
        llenar_active() {
            this.active = [];
            this.hours.forEach((row) => {
                this.active.push(false);
            });
        },
    },
    components: {
        top,
        foot,
        Select2,
        topAdministrator,
        Loading,
        Label,
        Modal
    },
};
</script>
