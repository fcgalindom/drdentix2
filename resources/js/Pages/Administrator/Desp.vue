<template>
  <div class="sidebar">
    <ul class="nav-list">
      <li @click="pantalla='branch'">
          <button class="btn btn-transparent shadow-none">
          <i class="fas fa-search-location"></i></button>
        <span class="tooltip">Sucursales</span>
      </li>
      <li @click="pantalla='dentis'">
            <button class="btn btn-transparent shadow-none">
          <i class="fas fa-user-md"></i>
            </button>
        <span class="tooltip">Odontólogos</span>
      </li>
      <li @click="pantalla='patient'">
          <button class="btn btn-transparent shadow-none">
          <i class="fas fa-tooth"></i></button>
        <span class="tooltip">Pacientes</span>
      </li>
      <li @click="pantalla='procedure'">
            <button class="btn btn-transparent shadow-none">
            <i class="fas fa-paste"></i></button>
        <span class="tooltip">Procedimientos</span>
      </li>
      <li @click="pantalla='citas'">
            <button class="btn btn-transparent shadow-none">
            <i class="fas fa-calendar-check"></i></button>
        <span class="tooltip">Citas</span>
      </li>
      <li class="profile" @click="logout">
          <button class="btn-transparent">
        <div class="profile-details">
          <div class="name_job">
            <div class="name">Prem Shahi</div>
            <div class="job">Web designer</div>
          </div>
        </div>
        <i class="bx bx-log-out" id="log_out"></i>

          </button>
      </li>
    </ul>
  </div>

<div v-if="pantalla=='branch'">
    <branch />
</div>
<div v-if="pantalla=='dentis'">
    <dentis />
</div>

<div v-if="pantalla=='procedure'">
    <procedure />
</div>
<div v-if="pantalla=='patient'">
    <patient />
</div>
<div v-if="pantalla=='citas'">
    <citas />
</div>
</template>

<script>
import branch from "./Branch"
import dentis from "./Dentis"
import procedure from "./Procedure"
import patient from "./Patient"
import citas from "./Citas"

export default {
    data(){
        return{
            pantalla: 'citas',
        }
    },
    created(){

    },
    methods:{
        logout(){
            axios.post('/logout').then(res => {
                window.location.href = "/loginAdministrador"
            })
        }
    },
    components:{
        branch,
        dentis,
        procedure,
        patient,
        citas
    }
}
</script>
