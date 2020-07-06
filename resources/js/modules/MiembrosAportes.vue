<template>
  <panel name="Aportes del miembro" icon="fas fa-users" class="panel-success">
    <template slot="actions">
      <a id="back" href="javascript:history.go(-1)" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <div class="m-t">
      <tabla
        :fields="fields"
        :form-fields="formFields"
        :api="api"
        :params="params"
        title="Miembro"
        :search-in="['attributes.nombre']"
      >
        <template v-slot:toolbar>
          <!-- b-button variant="success" :href="`${apiExcel}`" target="_blank" data-cy="tabla.excel"><i class="fas fa-file-excel"></i></!-->
        </template>
        <template v-slot:cell(attributes.monto)="{ item }">
          {{ format_number(item.attributes.monto) }}
        </template>
      </tabla>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/miembros/:id/aportes",
  mixins: [window.ResourceMixin],
  props: {
    id: null,
  },
  data() {
    return {
      //api: this.$api[`miembro/${this.id}/aportes`],
      api: this.$api.aportes,
      params: {
        page: 1,
        per_page: 5,
        meta: "pagination",
        filter: ['where,miembro_id,' + this.id],
        sort: 'gestion,mes',
      },
      fields: [
        { key: "attributes.mes", label: "Mes"},
        { key: "attributes.gestion", label: "Gestion"},
        { key: "attributes.monto", label: "Monto" },
        { key: "actions", label: "" },
      ],
      formFields: [
        { key: "attributes.nombre", label: "Nombre", create: true, edit: true },
        { key: "attributes.avatar", label: "", create: true, edit: true },
        { key: "attributes.aporte_mensual", label: "Aporte mensual", create: true, edit: true },
      ],
    };
  },
};
</script>
