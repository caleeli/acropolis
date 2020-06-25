<template>
  <panel :name="`Diario - ${$route.query.title || ''}`" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <div class="m-t overflow-hidden h-100">
      <tabla
        :fields="fields"
        :form-fields="formFields"
        :api="api"
        :params="params"
        title="Diario"
        :search-in="['attributes.fecha', 'attributes.detalle']"
      >
      </tabla>
    </div>
  </panel>
</template>

<script>
import moment from "moment";

export default {
  path: "/diario",
  mixins: [window.ResourceMixin],
  data() {
    return {
      api: this.$api.diario,
      fields: [
        { key: "attributes.fecha", label: "Fecha" },
        { key: "attributes.detalle", label: "Detalle" },
        { key: "attributes.ingreso", label: "Ingreso" },
        { key: "attributes.egreso", label: "Egreso" },
        { key: "attributes.saldo", label: "Saldo" },
        { key: "attributes.cuenta", label: "Cuenta" },
        { key: "attributes.libreta", label: "" },
        { key: "actions", label: "" },
      ],
      formFields: [
        { key: "attributes.fecha", label: "Fecha", create: true, edit: true, component: 'datetime',
          properties: {
            type: 'date',
          },
        },
        { key: "attributes.detalle", label: "Detalle", create: true, edit: true },
        { key: "attributes.ingreso", label: "Ingreso", create: true, edit: true },
        { key: "attributes.egreso", label: "Egreso", create: true, edit: true },
        { key: "attributes.cuenta", label: "Cuenta/Área", create: true, edit: true, component: "b-form-select",
          properties: {
            options: this.$api.economia_categorias.array({filter:['whereNotNull,codigo']}),
            'value-field': 'attributes.codigo',
            'text-field': 'attributes.nombre',
          },
        },
        { key: "attributes.libreta", label: "Caja/Cuenta", create: true, edit: true, component: "b-select",
          properties: {
            options: ['caja', 'cuenta'],
          }
        },
      ],
    };
  },
  computed: {
    params() {
      const params = {
        page: 1,
        per_page: 25,
        meta: "pagination",
      };
      if (this.$route.query.filter) {
        params.filter = this.$route.query.filter.split('|');
      }
      return params;
    },
  },
};
</script>

<style scoped>
.imagen {
  display: block;
  width: 100%;
}
</style>
