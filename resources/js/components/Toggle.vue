<template>
  <h3 :class="status" class="toggle" @click="click"></h3>
</template>

<script>
export default {
  props: {
    value: null,
  },
  computed: {
    status() {
      return `fas fa-toggle-${this.value ? 'on' : 'off'}`;
    },
  },
  methods: {
    click() {
      this.$emit('change', !this.value);
    },
  },
}
</script>

<style scoped>
.toggle {
  cursor: pointer;
}
</style>

</style>