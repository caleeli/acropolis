<template>
  <panel name="Registrar aporte" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <router-link to="/" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </router-link>
    </template>
    <div class="m-t">
      <div class="form-group">
        <label>Mes</label>
        <select class="form-control" v-model="mes">
          <option value="1">enero</option>
          <option value="2">febrero</option>
          <option value="3">marzo</option>
          <option value="4">abril</option>
          <option value="5">mayo</option>
          <option value="6">junio</option>
          <option value="7">julio</option>
          <option value="8">agosto</option>
          <option value="9">septiembre</option>
          <option value="10">octubre</option>
          <option value="11">noviembre</option>
          <option value="12">diciembre</option>
        </select>
      </div>
      <div class="form-group">
        <label>Gestion</label>
        <input class="form-control" v-model="gestion" />
      </div>
      <div class="form-group">
        <upload v-model="imagen" @change="uploadImage">
          <button type="button" class="btn btn-secondary">Subir imagen</button>
          <img v-if="imagen" :src="imagen.url" class="imagen" />
        </upload>
      </div>
      <div class="form-group">
        <button type="button" class="btn btn-primary"><i class="fas fa-save"></i> Guardar registro</button>
      </div>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/aporte/registrar",
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
