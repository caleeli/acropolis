<template>
  <panel name="Ver detalle de mis aportes" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <div class="m-t">
      <div v-for="row in aportes" class="row border-bottom mb-3 pb-3" :key="row.id">
        <div class="col-4 col-md-2">
          <b>{{mes(row.attributes.mes)}}/{{row.attributes.gestion}}</b>
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
          <small class="d-block">verificado por</small>
        </div>
      </div>
    </div>
  </panel>
</template>

<script>
import moment from "moment";

export default {
  path: "/aportes/ver_detalle",
  mixins: [window.ResourceMixin],
  data() {
    return {
      aportes: this.$api[`/user/1/aportes?sort=-gestion,-mes`].array()
    };
  },
  methods: {
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
