<template>
  <div class="portada">
    <img :src="portada" :style="`margin-top:-${margin}px`" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      margin: 0,
      portada: require('../../images/portada.jpg'),
    };
  },
  methods: {
    resize() {
      this.margin = 200 * window.innerWidth / 1800 - 60;
    },
  },
  mounted() {
    this.resize();
    window.addEventListener('resize', () => {
      this.resize();
    });
  },
}
</script>

<style scoped>
.portada {
  width: 100%;
  height: 120px;
  display: block;
  overflow: hidden;
}
@media only screen and (max-width: 344px) {
  .portada img {
    height: 120px;
  }
}
@media only screen and (min-width: 345px) {
  .portada img {
    width: 100%;
  }
}

</style>