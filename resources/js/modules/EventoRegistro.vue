<template>
  <panel name="Registro - Caminata por El Choro" icon="fa fa-walking" class="panel-success">
    <template slot="actions">
      <router-link to="/" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </router-link>
    </template>
    <div class="m-t">
      <div class="form-group">
        <b>Equipo necesario:</b>
        <p>...</p>
      </div>
      <div class="form-group">
        <label>Respuesta:</label>
        <select class="form-control" v-model="mes">
          <option value="1">Asistiré</option>
          <option value="2">No Asistire</option>
        </select>
      </div>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/evento/:id/registrar",
  mixins: [window.workflowMixin],
  data() {
    return {
      imagen: null,
      mes: String(new Date().getMonth() + 1),
      gestion: String(new Date().getFullYear() + 1)
    };
  },
  methods: {
    uploadImage(imagen) {
      this.imagen = imagen;
    }
  }
};
</script>

<style scoped>
.imagen {
  display: block;
  width: 100%;
}
</style>
