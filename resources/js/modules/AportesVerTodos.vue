<template>
  <panel name="Administración" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <router-link
        data-cy="import-excel"
        :to="{path:'/admin/import'}"
        class="btn btn-sm btn-outline-secondary"
      >
        <i class="fas fa-file-import"></i>
      </router-link>
      <router-link
        :to="{path:'/aporte/admin/registrar/0'}"
        class="btn btn-sm btn-outline-secondary"
      >
        <i class="fas fa-plus"></i>
      </router-link>
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
          @change="cargarAportes"
        >
          <template slot-scope="{row,format}">
            <span class="option" v-html="format(row.attributes.name)"></span>
          </template>
        </select-box>
      </div>
      <div v-for="(row,index) in aportes" class="row border-bottom mb-3 pb-3" :key="row.id">
        <div class="col-12 col-md-12 text-white bg-success text-uppercase" v-if="esPrimero(index)">
          <b>{{row.relationships.miembro.attributes.name}}</b>
        </div>
        <div class="col-4 col-md-2">
          <b>{{mes(row.attributes.mes)}}/{{row.attributes.gestion}}</b>
          <div>
            <a class="view-image" href="javascript:void(0)" @click="verImagen(row)">
              <i v-if="row.id === showImage" class="far fa-image"></i>
              <i v-else class="fas fa-eye"></i>
              <small>imagen</small>
            </a>
          </div>
        </div>
        <div class="col-4 col-md-2">
          {{fecha(row.attributes.fecha_pago)}}
          <small class="d-block">Fecha de pago</small>
        </div>
        <div class="col-4 col-md-2">
          {{row.attributes.monto}}
          <small class="d-block">monto</small>
        </div>
        <div class="col-4 col-md-2">
          {{row.attributes.medio}}
          <small class="d-block">medio</small>
        </div>
        <div class="col-4 col-md-2">
          {{row.attributes.recibo}}
          <small class="d-block">recibo</small>
        </div>
        <div class="col-4 col-md-2">
          {{row.attributes.verificado_por}}
          <small
            v-if="row.attributes.verificado_por"
            class="d-block"
          >verificado por</small>
          <button
            v-if="!row.attributes.verificado_por"
            type="button"
            class="btn btn-sm btn-success verificar"
            @click="verificarAporte(row)"
          >
            <i class="fas fa-check"></i>
          </button>
          <router-link
            class="btn btn-sm btn-primary editar"
            :to="{path: `/aporte/admin/registrar/${row.id}`}"
          >
            <i class="fas fa-pen-fancy"></i>
          </router-link>
        </div>
        <div class="col-12" v-if="row.id === showImage">
          <img :src="row.attributes.imagen.url" class="recibo w-100" />
        </div>
      </div>
      <button class="btn btn-info w-100" type="button" :disabled="apiIsRunning" @click="verMas">
        <i v-if="apiIsRunning" class="fas fa-spinner fa-spin"></i>
        Ver más
      </button>
    </div>
  </panel>
</template>

<script>
import moment from "moment";

export default {
  path: "/aportes/ver_todos",
  mixins: [window.ResourceMixin],
  data() {
    let miembro = this.$route.query.miembro || 0;
    return {
      apiIndex: {
        aportes: {
          $api: `/user/${miembro}/aportes`,
          sort: "-gestion,-mes",
          include: "miembro",
          page: 1,
          per_page: 10
        }
      },
      miembro: this.$route.query.miembro || null,
      showImage: null,
      miembros: this.$api[`/users?sort=name&per_page=200`].array(),
      aportes: []
    };
  },
  methods: {
    verificarAporte(aporte) {
      aporte.attributes.verificado_por = this.$root.user.attributes.iniciales;
      const data = { ...aporte };
      delete data.relationships;
      this.$api[`/aportes`].put(data).then(response => {
        this.cargarAportes();
        return response;
      });
    },
    verMas() {
      this.apiIndex.aportes.per_page += 10;
    },
    cargarAportes() {
      if (this.miembro) {
        this.apiIndex.aportes.$api = `/user/${this.miembro}/aportes`;
      } else {
        this.apiIndex.aportes.$api = `/user/0/aportes`;
      }
      this.apiIndex.aportes.per_page = 10;
    },
    esPrimero(index) {
      return (
        index === 0 ||
        this.aportes[index - 1].relationships.miembro.attributes.name !=
          this.aportes[index].relationships.miembro.attributes.name
      );
    },
    verImagen(row) {
      if (this.showImage === row.id) {
        this.showImage = null;
      } else {
        this.showImage = row.id;
      }
    },
    fecha(date) {
      return moment(date).format("DD/MM/YYYY");
    },
    mes(mes) {
      return [
        "Ene",
        "Feb",
        "Mar",
        "Abr",
        "May",
        "Jun",
        "Jul",
        "Ago",
        "Sep",
        "Oct",
        "Nov",
        "Dic"
      ][mes - 1];
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
