<template>
  <nav class="navbar navbar-dark bg-principal navbar-expand-lg">
    <a class="navbar-brand text-white mx-3 mx-md-5" href="#">
      <img src="../../Img/logo.png" alt="" class="mt-1r size-top" />
      <!-- <h2>iLeven</h2> -->
    </a>
    <button
      class="navbar-toggler mx-3"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarColor01"
      aria-controls="navbarColor01"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse row mx-3" id="navbarColor01">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-end">
        <li class="nav-item" v-if="user.type_user == 'Patient'">
          <a
            class="nav-link text-white"
            aria-current="page"
            href="/Pacientes/MyProfile"
            ><b>
                <span v-bind:class="[uri == '/Pacientes/MyProfile' ? 'color-aqua' : '']">MI PERFIL</span> <span class="mx-md-3 d-none d-lg-inline">|</span></b
            ></a
          >
        </li>
        <li class="nav-item" v-else>
          <a
            class="nav-link text-white"
            aria-current="page"
            href="/Odontologos/MyProfile"
            ><b>
                <span v-bind:class="[uri == '/Odontologos/MyProfile' ? 'color-aqua' : '']">MI PERFIL</span>
                <span class="mx-md-3 d-none d-lg-inline">|</span></b
            ></a
          >
        </li>
        <li class="nav-item" v-if="user.type_user == 'Patient'">
          <a class="nav-link text-white" href="/Pacientes/citas"
            ><b>
                <span v-bind:class="[uri == '/Pacientes/citas' ? 'color-aqua' : '']">AGENDAR CITA</span>
                <span class="mx-md-3 d-none d-lg-inline">|</span></b
            ></a
          >
        </li>
        <li class="nav-item" v-else>
          <a class="nav-link text-white" href="/Odontologos/citas"
            ><b> <span v-bind:class="[uri == '/Odontologos/citas' ? 'color-aqua' : '']">MIS CITAS</span>
                <span class="mx-md-3 d-none d-lg-inline">|</span></b
            ></a
          >
        </li>
        <li class="nav-item" v-if="user.type_user == 'Patient'">
          <a class="nav-link text-white" href="/Pacientes/citasPorPaciente"
            ><b> <span v-bind:class="[uri == '/Pacientes/citasPorPaciente' ? 'color-aqua' : '']">MIS CITAS</span>
              <span class="mx-md-3 d-none d-lg-inline">|</span></b
            ></a
          >
        </li>
        <li class="nav-item" v-else>
          <a class="nav-link text-white" href="/Odontologos/MySchedule"
            ><b> <span v-bind:class="[uri == '/Odontologos/MySchedule' ? 'color-aqua' : '']">MI HORARIO</span>
              <span class="mx-md-3 d-none d-lg-inline">|</span></b
            ></a
          >
        </li>
        <li class="nav-item">
          <button
            type="button"
            class="btn btn-transparent text-white"
            @click="logout"
          >
            <i class="fas fa-sign-out-alt"></i>
          </button>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      user: {},
      uri: ''
    };
  },
  created() {
    this.getResults();
  },
  methods: {
    getResults() {
      axios.get("/log").then((res) => {
        this.user = res.data;
        this.uri = window.location.pathname
      });
    },
    logout() {
      let type = this.user.type_user;
      axios.get("/logout").then((res) => {
        if (type == "Patient") {
          window.location.href = "/";
        } else if (type == "Dentist") {
          window.location.href = "/loginAdministrador";
        }
      });
    },
  },
};
</script>

<style lang="css">
.mt-1r {
  margin-top: -1rem;
}
.size-top {
  height: 70px;
  width: 15rem;
}

.color-aqua {
    color: aquamarine;
}

@media (max-width: 400px) {
  .size-top {
    width: 11rem;
  }
}
@media (max-width: 300px) {
  .size-top {
    width: 10rem;
  }
}
</style>
