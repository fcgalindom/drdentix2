<template>


  <div class="container table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Day</th>
          <th scope="col">Hora</th>

        </tr>
      </thead>
      <tbody>
        <tr v-for="(i, index) in dentists" :key="index">
          <td>{{ i?.day }}</td>
          <td>{{ i?.hour }}</td>

        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  data() {
    return {
      dentists: {},
      dentist: { day:"", hour:""},
    };
  },
  created() {
    this.getResults();
  },
  methods: {
    getResults() {
         axios.get("/Odontologos/index").then((res) => {
        this.dentists = res.data.dentists;
      });
    },
  },
};
</script>
<style lang="css">
.form-check-input:checked {
  background-color: #01c001;
  border-color: #01c001;
}
</style>








