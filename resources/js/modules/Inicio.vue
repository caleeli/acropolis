<template>
  <div class="principal position-relative">
    <div class="toolbar">
      <router-link to="/aportes/ver_todos" class="btn-plus" id="ver-aportes-todos">
        <i class="fas fa-table"></i>
      </router-link>
      <router-link to="/mensaje/tipo" class="btn-plus" id="new-message">
        <i class="fas fa-pen"></i>
      </router-link>
    </div>
    <img src="http://www.acropolis.org.bo/wp-content/uploads/2016/08/portada0.jpg" class="portada" />
    <div style="padding:1em">
      <mensaje v-for="(opcion,index) in mensajes" :key="index" :value="opcion"></mensaje>
    </div>
  </div>
</template>

<script>
export default {
  path: "/",
  mixins: [window.ResourceMixin],
  data() {
    return {
      today: window.moment().format(),
      mensajes: this.$api[`/user/1/messages?include=category&sort=-id`].array()
    };
  }
};
</script>

<style scoped>
.portada {
  width: 100%;
  height: 120px;
  display: block;
}
.principal {
  overflow: auto;
}
.toolbar {
  position: absolute;
  top: 0.5em;
  right: 0.5em;
}
.btn-plus {
  width: 3em;
  height: 3em;
  padding: 1em;
  border-radius: 50%;
  background-color: darkgreen;
  color: white;
  display: table-inline;
  text-align: center;
  vertical-align: middle;
}
.btn-plus i {
  display: table-cell;
}
</style>
