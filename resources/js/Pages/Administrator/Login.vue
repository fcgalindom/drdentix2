<template>
    <section class=" slider d-flex justify-content-center align-items-center">
        <div class="">
            <div class="container text-center mb-5">
                <img src="../../Img/logo.png" class="size-img" alt="" />
            </div>
            <div class="container">
                <div class="form-group">
                    <label for="" class="text-white">Correo electrónico</label>
                    <input class="form-control rounded-pill" type="text" placeholder="Correo electrónico"
                        v-model="credentials.email" />
                </div>
                <div class="form-group">
                    <label for="" class="text-white">Contraseña</label>
                    <input class="form-control rounded-pill" type="password" placeholder="Contraseña"
                        v-model="credentials.password" />
                </div>
                <div class="text-end">
                    <a href="#" class="text-white">¿Olvidó su contraseña?</a>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <button class="btn btn-login btn-lg rounded-pill" @click="login">
                        <b>Iniciar sesión</b>
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            credentials: { email: "", password: "" },
        };
    },
    beforeMount() {
        // axios.get(route('web.is_log')).then(res => {
        //     if (!this.$isEmpty(res.data)) {
        //         if(res.data.type_user == 'Administrator'){
        //             window.location.href = route('web.home_admin')
        //         }else{
        //             window.location.href = route('web.login')
        //         }
        //     }
        // })
    },
    methods: {
        login() {
            axios.post("/loginAdministrador", this.credentials).then((res) => {
                if (res.data.status == 422) {
                    Swal.fire("Error", res.data.msg, "error");
                } else if (res.data.status == 200) {
                    if (res.data.user.type_user == "Administrator") {
                        window.location.href = "/home";
                    } else if (res.data.user.type_user == "Dentist") {
                        window.location.href = "/Odontologos/citas";
                    }
                }
            });
        },
    },
};
</script>
