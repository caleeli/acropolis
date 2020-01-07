<template>
  <panel name="Registrar aporte" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <div class="m-t">
      <div class="form-group">
        <label>Mes</label>
        <select id="mes" class="form-control" v-model="mes">
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
        <input id="gestion" class="form-control" v-model="gestion" />
      </div>
      <div class="form-group">
        <label>Fecha de pago</label>
        <datetime id="fecha_pago" type="date" v-model="fecha_pago" />
      </div>
      <div class="form-group">
        <label>Monto</label>
        <input id="monto" class="form-control" v-model="monto" />
      </div>
      <div class="form-group">
        <label>Medio</label>
        <select id="medio" class="form-control" v-model="medio">
          <option value="Caja">Caja</option>
          <option value="Banco">Banco</option>
        </select>
      </div>
      <div class="form-group" v-if="medio==='Caja'">
        <label>Recibo</label>
        <input id="recibo" class="form-control" v-model="recibo" />
      </div>
      <div class="form-group">
        <upload v-model="imagen" @change="uploadImage">
          <button type="button" class="btn btn-secondary">Subir imagen</button>
          <img v-if="imagen" :src="imagen.url" class="imagen" />
        </upload>
      </div>
      <div class="form-group">
        <button id="registrar" type="button" class="btn btn-primary" @click="guardarRegistro">
          <i class="fas fa-save"></i> Guardar registro
        </button>
      </div>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/aporte/registrar",
  mixins: [window.ResourceMixin],
  data() {
    return {
      aportes: this.$api[`user/${this.$root.user.id}/aportes`],
      imagen: null,
      mes: String(new Date().getMonth() + 1),
      gestion: String(new Date().getFullYear() + 1),
      fecha_pago: moment().format("YYYY-MM-DD"),
      monto: "",
      medio: "Banco",
      recibo: ""
    };
  },
  methods: {
    guardarRegistro() {
      this.aportes
        .post({
          attributes: {
            miembro_id: this.$root.user.id,
            mes: this.mes,
            gestion: this.gestion,
            fecha_pago: this.fecha_pago,
            monto: this.monto,
            medio: this.medio,
            recibo: this.recibo,
            imagen: this.imagen
          }
        })
        .then(() => {
          this.$router.push({ path: "/aportes/ver" });
        });
    },
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
