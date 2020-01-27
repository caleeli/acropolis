<template>
  <panel name="Registrar aporte" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <div class="m-t">
      <div class="form-group">
        <select-box
          id="miembro"
          v-model="miembro"
          :data="miembros"
          placeholder="Seleccione a un miembro"
          filter-by="attributes.name"
        >
          <template slot-scope="{row,format}">
            <span class="option" v-html="format(row.attributes.name)"></span>
          </template>
        </select-box>
      </div>
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
        <upload v-model="imagen" accept="image/*" @change="uploadImage" @error="uploadError">
          <template slot-scope="{ bgStyle }">
            <button
              type="button"
              class="btn btn-secondary w-100"
              :style="{ 'background-image': bgStyle }"
            >Subir imagen</button>
            <img v-if="imagen" :src="imagen.url" class="imagen" />
          </template>
        </upload>
        <div v-show="showUploadError" class="alert alert-danger alert-dismissible">
          {{uploadErrorMessage}}
          <button type="button" class="close" @click="showUploadError=false">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="form-group">
        <button id="registrar" type="button" class="btn btn-primary" @click="guardarRegistro">
          <i class="fas fa-save"></i> Guardar registro
        </button>
      </div>
      <div v-if="error" class="alert alert-danger" role="alert">{{ error }}</div>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/aporte/admin/registrar/:id",
  mixins: [window.ResourceMixin],
  data() {
    return {
      error: "",
      aporte_id: null,
      aportes: this.$api[`user/${this.$root.user.id}/aportes`],
      miembros: this.$api[`/users?sort=name&per_page=200`].array(),
      imagen: null,
      miembro: null,
      a_pagar: 150,
      mes: String(new Date().getMonth() + 1),
      gestion: String(new Date().getFullYear() + 1),
      fecha_pago: moment().format("YYYY-MM-DD"),
      monto: "",
      medio: "Banco",
      recibo: "",
      uploadErrorMessage: "",
      showUploadError: false
    };
  },
  methods: {
    loadRegistro(id) {
      this.aporte_id = this.$route.params.id;
      if (!id) return;
      this.$api.aporte.load(id, { include: "miembro" }).then(aporte => {
        this.miembro = aporte.attributes.miembro_id;
        (this.a_pagar = aporte.relationships.miembro.attributes.aporte_mensual),
          (this.mes = aporte.attributes.mes);
        this.gestion = aporte.attributes.gestion;
        this.fecha_pago = aporte.attributes.fecha_pago;
        this.monto = aporte.attributes.monto;
        this.medio = aporte.attributes.medio;
        this.recibo = aporte.attributes.recibo;
        this.imagen = aporte.attributes.imagen;
      });
    },
    uploadError(response, status, message) {
      this.showUploadError = true;
      this.uploadErrorMessage = response.responseJSON.message || message;
    },
    guardarRegistro() {
      this.aportes[parseInt(this.aporte_id) ? "put" : "post"]({
        id: parseInt(this.aporte_id) ? this.aporte_id : undefined,
        attributes: {
          miembro_id: this.miembro,
          a_pagar: this.a_pagar,
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
          this.$router.push({
            path: "/aportes/ver_todos",
            query: { miembro: this.miembro }
          });
        })
        .catch(error => {
          this.error = error.response;
        });
    },
    uploadImage(imagen) {
      this.showUploadError = false;
      this.imagen = imagen;
    }
  },
  mounted() {
    this.loadRegistro(parseInt(this.$route.params.id));
  }
};
</script>

<style scoped>
.imagen {
  display: block;
  width: 100%;
}
</style>
