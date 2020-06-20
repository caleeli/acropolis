<template>
  <panel name="Diario" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <div class="m-t">
      <tabla
        :fields="fields"
        :form-fields="formFields"
        :api="api"
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
        { key: "id", label: "id" },
        { key: "attributes.fecha", label: "Fecha" },
        { key: "attributes.detalle", label: "Detalle" },
        { key: "attributes.ingreso", label: "Ingreso" },
        { key: "attributes.egreso", label: "Egreso" },
        { key: "attributes.saldo", label: "Saldo" },
        { key: "attributes.cuenta", label: "Cuenta" },
        { key: "attributes.libreta", label: "" },
      ],
      formFields: [
        { key: "attributes.fecha", label: "Fecha", create: true, edit: true },
        { key: "attributes.detalle", label: "Fecha", create: true, edit: true },
        { key: "attributes.ingreso", label: "Fecha", create: true, edit: true },
        { key: "attributes.egreso", label: "Fecha", create: true, edit: true },
        { key: "attributes.cuenta", label: "Fecha", create: true, edit: true },
        { key: "attributes.cuenta", label: "Fecha", create: true, edit: true },
        { key: "attributes.libreta", label: "Fecha", create: true, edit: true, component: "b-select",
          properties: {
            options: ['caja', 'cuenta'],
          }
        },
      ],
    };
  },
};
</script>

<style scoped>
.imagen {
  display: block;
  width: 100%;
}
</style>
