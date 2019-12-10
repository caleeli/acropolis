<template>
  <router-link :to="value.link" v class="opcion-menu">
    <span class="opcion-icon">
      <i :class="value.icon"></i>
    </span>
    <div class="opcion-text" v-html="value.content"></div>
  </router-link>
</template>

<script>
export default {
  props: {
    value: Object
  }
};
</script>

<style>
h5 {
  font-size: 1em;
}
.opcion-menu {
  width: 100%;
  display: flex;
  flex-direction: row;
  background-color: white;
  color: darkgreen;
  padding: 8px;
  border-radius: 4px;
  font-size: 10pt;
  vertical-align: top;
  margin-bottom: 1em;
}
.opcion-icon {
  width: 20%;
  display: block;
  background-color: antiquewhite;
  color: darkgreen;
  font-size: 30px;
  text-align: center;
}
.opcion-text {
  margin-left: 1em;
}
</style>
