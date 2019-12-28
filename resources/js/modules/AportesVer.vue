<template>
  <panel name="Ver mis aportes" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <div class="m-t">
      <router-link to="/aportes/ver_detalle">
        <i class="fas fa-th-list"></i> Ver detalles
      </router-link>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Mes</th>
            <th scope="col">Año</th>
            <th scope="col">Monto</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in aportes" :key="row.id">
            <td>{{mes(row.attributes.mes)}}</td>
            <td>{{row.attributes.gestion}}</td>
            <td>{{row.attributes.monto}}</td>
            <td>
              <i v-if="row.attributes.verificado" class="fas fa-check-circle text-success"></i>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/aportes/ver",
  mixins: [window.ResourceMixin],
  data() {
    return {
      aportes: this.$api[
        `/user/1/aportes?filter[]=Consolidado&sort=-gestion,-mes`
      ].array()
    };
  },
  methods: {
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
