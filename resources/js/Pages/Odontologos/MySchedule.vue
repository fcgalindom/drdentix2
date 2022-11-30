<template>
    <top v-if="user.type_user != 'Administrator'" />
    <div class="container mb-3">
        <div class="row mt-4 mb-3">
            <div class="col-9 col-sm-8 col-md-10">
                <button class="btn btn-link d-none d-sm-inline">
                    <i class="fas fa-circle"></i>
                </button>
                <h5 class="d-inline">{{ dentist.name }}</h5>
            </div>
        </div>
    </div>
    <div class="container table-responsive mt-4 text-center prt-3">
        <table class="table">
            <thead class="bg-blue text-white">
                <th v-for="(i, index) in dias" :key="index">{{ i }}</th>
            </thead>
            <tbody class="h-4r">
                <!-- Hora de inicio -->
                <tr>
                    <td class="id"><strong>Hora de inicio</strong></td>
                    <td v-for="(i, index) in horainicio" :key="index">
                        <select name="" id="" class="rounded-pill" :disabled="!atiende[index]"
                            v-model="horainicio[index]">
                            <option v-for="(item, key) in horas" :key="key" :value="item" v-text="item"></option>
                        </select>
                    </td>
                </tr>

                <!-- Hora de finalización -->
                <tr>
                    <td class="id"><strong>Hora de Final</strong></td>
                    <td v-for="(i, index) in horafin" :key="index">
                        <select name="" id="" class="rounded-pill" :disabled="!atiende[index]" v-model="horafin[index]">
                            <option v-for="(item, key) in horas" :key="key" :value="item" v-text="item"></option>
                        </select>
                    </td>
                </tr>
                <!-- Dar descanso (Checbox) -->
                <tr>
                    <td class="id"><b>Dar descanso</b></td>
                    <td v-for="(i, index) in descanso" :key="index">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" :value="i" :id="'dardescanso' + index"
                                v-model="descanso[index]" :disabled="!atiende[index]" @change="editBreak(index, i)" />
                            <label class="form-check-label" :for="'dardescanso' + index">
                                SI
                            </label>
                        </div>
                    </td>
                </tr>
                <!-- Inicio de descanso -->
                <tr>
                    <td class="id"><strong>Inicio de descanso</strong></td>
                    <td v-for="(i, index) in inicioDescanso" :key="index">
                        <select name="" id="" class="rounded-pill" :disabled="!descanso[index] || !atiende[index]"
                            v-model="inicioDescanso[index]">
                            <option v-for="(item, key) in horas" :key="key" :value="item" v-text="item"></option>
                        </select>
                    </td>
                </tr>
                <!-- Termino de descanso -->
                <tr>
                    <td class="id"><strong>Termino de descanso</strong></td>
                    <td v-for="(i, index) in terminoDescanso" :key="index">
                        <select name="" id="" class="rounded-pill" :disabled="!descanso[index] || !atiende[index]"
                            v-model="terminoDescanso[index]">
                            <option v-for="(item, key) in horas" :key="key" :value="item" v-text="item"></option>
                        </select>
                    </td>
                </tr>
                <!-- No atiende (checkbox) -->
                <tr>
                    <td class="id"><b>Atiende</b></td>
                    <td v-for="(i, index) in atiende" :key="index">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" :value="i" :id="'atiende' + index"
                                v-model="atiende[index]" @change="editAttend(index, i)" />
                            <label class="form-check-label" :for="'atiende' + index">
                                SI
                            </label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-center my-4">
            <button type="button" class="btn bg-azul" @click="store">Guardar</button>
        </div>
    </div>
    <foot />
</template>
<script>
import top from "../../Layouts/Patient/TopPatient.vue";
import foot from "../../Layouts/Administrator/Foot.vue";
export default {
    props: ["id"],
    data() {
        return {
            dias: [
                "ASUNTO",
                "LUNES",
                "MARTES",
                "MIERCOLES",
                "JUEVES",
                "VIERNES",
                "SÁBADO",
            ],
            horainicio: [],
            horafin: [],
            descanso: [],
            inicioDescanso: [],
            terminoDescanso: [],
            atiende: [],
            user: {},
            dentist: {},
            horas: [
                "08:00:00",
                "08:15:00",
                "08:30:00",
                "08:45:00",
                "09:00:00",
                "09:15:00",
                "09:30:00",
                "09:45:00",
                "10:00:00",
                "10:15:00",
                "10:30:00",
                "10:45:00",
                "11:00:00",
                "11:15:00",
                "11:30:00",
                "11:45:00",
                "12:00:00",
                "12:15:00",
                "12:30:00",
                "12:45:00",
                "13:00:00",
                "13:15:00",
                "13:30:00",
                "13:45:00",
                "14:00:00",
                "14:15:00",
                "14:30:00",
                "14:45:00",
                "15:00:00",
                "15:15:00",
                "15:30:00",
                "15:45:00",
                "16:00:00",
                "16:15:00",
                "16:30:00",
                "16:45:00",
                "17:00:00",
                "17:15:00",
                "17:30:00",
                "17:45:00",
                "18:00:00",
            ],
        };
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults() {
            let url = window.location.pathname;
            axios.get("/log").then((res) => {
                this.user = res.data;
            });
            axios.put(url, { id: this.id }).then((res) => {
                this.dentist = res.data.dentist;
                if (res.data.schedules.length == 0) {
                    this.horainicio = [
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                    ];
                    this.horafin = [
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                    ];
                    this.descanso = [true, true, true, true, true, true];
                    this.inicioDescanso = [
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                    ];
                    this.terminoDescanso = [
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                        "08:00:00",
                    ];
                    this.atiende = [true, true, true, true, true, true];
                } else {
                    this.horainicio = [];
                    this.horafin = [];
                    this.descanso = [];
                    this.inicioDescanso = [];
                    this.terminoDescanso = [];
                    this.atiende = [];
                    res.data.schedules.forEach((row) => {
                        this.horainicio.push(row.hour_strart);
                        this.horafin.push(row.hour_end);
                        if (row.break == 1) {
                            this.descanso.push(true);
                        } else {
                            this.descanso.push(false);
                        }
                        if (row.attend == 1) {
                            this.atiende.push(true);
                        } else {
                            this.atiende.push(false);
                            // this.descanso.push(false)
                        }
                        this.inicioDescanso.push(row.break_strart);
                        this.terminoDescanso.push(row.break_end);
                    });
                }
            });
        },
        store() {
            let horario = [
                this.horainicio,
                this.horafin,
                this.descanso,
                this.inicioDescanso,
                this.terminoDescanso,
                this.atiende,
            ];
            let url = window.location.pathname + "?id=" + this.id;
            axios.post(url, horario).then((res) => {
                if (res.data.status == 422) {
                    Swal.fire("Éxito", res.data.msg, "success");
                } else if (res.data.status == 200) {
                    this.getResults();
                    Swal.fire("Éxito", res.data.msg, "success");
                }
            });
        },
        editBreak(index, i) {
            if (i == false) {
                this.inicioDescanso[index] = null;
                this.terminoDescanso[index] = null;
            }
        },
        editAttend(index, i) {
            if (i == false) {
                this.editBreak(index, i);
                this.horainicio[index] = null;
                this.horafin[index] = null;
            }
        },
    },
    components: {
        top,
        foot,
    },
};
</script>
<style lang="css">
.form-check-input:checked {
    background-color: #03adf0 !important;
    border-color: #03adf0 !important;
}

.prt-3 th {
    height: 3rem;
}
</style>
