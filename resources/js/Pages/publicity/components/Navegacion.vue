<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img
            :src="logo"
            alt=""
            width="30"
            height="24"
            class="d-inline-block align-text-top logo-img"
          />
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <div class="d-flex justify-content-lg-around w-100 flex-column flex-lg-row align-items-center justify-content-center">
            <a
            class="mb-3"
              v-bind:class="[
                current == i.link
                  ? 'btn btn-primary botoni'
                  : 'btn btn-transparent botonolink',
              ]"
              :href="i.link"
              v-for="(i, index) in links"
              :key="index"
              >{{ i.text }}</a
            >
            <!-- <a class="btn btn-primary botoni" href="#" style="font-size: .84rem">¿Quiénes somos?</a> -->
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>
<script>
export default {
  data() {
    return {
      logo: "",
      links: [
        {text: "Inicio", link: '/home-publicity', },
        {text: "Promociones", link: '/promociones'},
        {text: "Financiación", link: '/financiacion'},
        {text: "Testimonios", link: '/testimonios'},
        // {text: "¿Quiénes somos?", link: '#'},
      ],
      current: ''
    };
  },
  created() {
    axios.post("/navegacion").then((res) => {
      this.logo = res.data;
      this.current = window.location.pathname
    });
  },
};
</script>

<style lang="css">
@media (min-width: 991px){
    #navbarNavDropdown a{
        position: relative;
        top: .6rem;
    }
}
</style>
