<template>
  <div>
    <desp />
    <section class="home-section">
      <top />
    </section>
  </div>
</template>
<script>
import top from "../../Layouts/Administrator/Top";
import desp from "../../Layouts/Administrator/Desp";
export default {
  components: {
    top,
    desp,
  },
};
</script>
