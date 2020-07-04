<template>
  <div class="principal position-relative h-100 d-flex flex-column">
    <div>
      <div class="toolbar">
        <router-link v-for="tool in toolbar"
          :key="`toolbar-${tool.id}`"
          :to="tool.to" class="btn-plus"
          :id="tool.id">
          <i :class="tool.icon"></i>
        </router-link>
      </div>
      <portada />
    </div>
    <div class="flex-fill d-flex flex-column justify-content-center" style="padding:1em">
      <!-- mensaje v-for="(opcion,index) in mensajes" :key="index" :value="opcion"></mensaje> -->
      <center class="d-flex align-items-center justify-content-center">
        <dashboard @hover="hoverNode" />
        <chart
            :data="data"
            :title="chartTitle"
            label-field="periodo"
            :value-field="['ingresos','egresos']"
            :colors="['lightgreen','salmon']"
            type="line"
        />
      </center>
    </div>
  </div>
</template>

<script>
export default {
  path: "/",
  mixins: [window.ResourceMixin],
  data() {
    return {
      chartTitle: 'total ingresos, egresos acumulados (por semana)',
      data: [],
      toolbar: [
        {
          id: 'ver-aportes-todos',
          to: '/aportes/ver_todos',
          icon: 'fas fa-table',
        },
        {
          id: 'new-message',
          to: '/mensaje/tipo',
          icon: 'fas fa-pen',
        },
        {
          id: 'registrar-ingreso',
          to: '/registrar/ingreso',
          icon: 'fas fa-plus',
        },
        {
          id: 'registrar-egreso',
          to: '/registrar/egreso',
          icon: 'fas fa-minus',
        },
      ],
      today: window.moment().format(),
      mensajes: this.$api[`/user/1/messages?include=category&sort=-id`].array()
    };
  },
  methods: {
    hoverNode(node, libreta) {
      this.chartTitle = `Acumulado: ${node.attributes.nombre} (por semana)`;
      this.runReport(node && node.attributes.codigo, libreta);
    },
    runReport(cuenta, libreta) {
      this.$api.diario.call(null, 'seguimiento', { cuenta, libreta })
        .then(response => {
          this.data = response;
        });
    },
  },
  mounted() {
    this.runReport();
  },
};
</script>

<style scoped>
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
