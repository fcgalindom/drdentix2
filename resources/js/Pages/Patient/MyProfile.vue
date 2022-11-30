<template>
    <top />
    <div class="container my-4">
        <div class="card mb-3">
            <img src="../../Img/celest.png" class="card-img-top size-img-card d-none d-md-block" alt="..." />
            <img src="../../Img/fondo_profile.jpeg" class="card-img-top size-img-card d-block d-md-none" alt="..." />
            <div class="card-body" style="height: 12rem">
                <div class="container-fluid d-flex flex-column align-items-center prb-5">
                    <button type="button" class="btn-transparent position-relative top-2r" data-bs-toggle="modal"
                        data-bs-target="#photo" @click="avatar = patient.user.photo">
                        <img :src="patient.user.photo" class="rounded-circle size-perfil mb-4" alt="" />
                        <!-- <i class="fas fa-pen fa-lg" style="position: relative;right: .5rem;top: 1rem;"></i> -->
                        <!-- <button class="btn btn-success">
              <i class="fas fa-camera-alt"></i>
            </button> -->
                    </button>
                    <h4 class="card-title text-center">
                        <b class="position-relative top-2r">{{ patient.name }}</b>
                    </h4>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-lg-2 g-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><b>Información básica</b></h5>
                        <div class="container-fluid">
                            <div class="d-flex">
                                <span><b>Nombre:</b></span>
                                <p>{{ patient.name }}</p>
                            </div>
                            <div class="d-flex">
                                <span><b>Ciudad:</b></span>
                                <p>{{ patient.city }}</p>
                            </div>
                            <div class="d-flex">
                                <span><b>Fecha de nacimiento:</b></span>
                                <p>{{ dConvert(patient.user.birth) }}</p>
                            </div>
                            <div class="d-flex">
                                <span><b>Cédula:</b></span>
                                <p>{{ patient.user.document }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><b>Información de contacto</b></h5>
                        <div class="container-fluid">
                            <div class="d-flex">
                                <span><b>Email:</b></span>
                                <p>{{ patient.user.email }}</p>
                            </div>
                            <div class="d-flex">
                                <span><b>Número telefónico:</b></span>
                                <p>{{ patient.telephone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col" v-if="patient.user.type_user == 'Dentist'">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><b>Mis procedimiento</b></h5>
                        <div class="container-fluid">
                            <div class="d-flex" v-for="(i, index) in patient.procedures" :key="index">
                                <span><b>{{ index + 1 }}. </b></span>
                                <p>{{ i.name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <foot />

    <!-- Start modal -->

    <div class="modal fade" id="photo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dr. Dentix</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <label for="profile">Sube aquí tu imagen de perfil</label>
                        <input type="file" class="form-control" accept="image/*" id="profile"
                            @change="upload_file($event)" />
                        <div class="d-flex justify-content-center">
                            <img :src="avatar" class="size-img-profile my-3" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-red-danger" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-blue-primary" @click="store">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End modal -->
</template>

<script>
import top from "../../Layouts/Patient/TopPatient.vue";
import foot from "../../Layouts/Administrator/Foot.vue";
export default {
    props: ["patient"],
    data() {
        return {
            avatar: "",
            result: "",
            file: {},
        };
    },
    created() {
        this.avatar = this.patient.user.photo;
    },
    methods: {
        upload_file(e) {
            var file = e.target.files[0];
            this.file = e.target.files[0];
            var reader = new FileReader();
            var that = this;
            reader.readAsDataURL(file);
            reader.onload = function (e) {
                that.avatar = this.result;
            };
        },
        store() {
            let form = new FormData();
            form.append("photo", this.file);
            form.append("id", this.patient.user.id);
            axios.post("/upload_photo", form).then((res) => {
                if (res.data.status == 200) {
                    Swal.fire("Éxito", res.data.msg, "success");
                    $("#photo").trigger("click");
                    this.patient.user.photo = res.data.img;
                } else if (res.data.status == 422) {
                    Swal.fire("Error", res.data.msg, "error");
                }
            });
        },
        dConvert(date) {
            let array = date.split("-");
            return array[2] + "-" + array[1] + "-" + array[0];
        },
    },
    components: {
        top,
        foot,
    },
};
</script>
