<template>
  <panel name="Miembros" icon="fas fa-users" class="panel-success">
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
        <template v-slot:cell(attributes.activo)="{ item }">
          <i :class="`${item.attributes.activo ? 'fas fa-circle text-success' : 'far fa-circle text-secondary'}`"></i>
        </template>
        <template v-slot:cell(attributes.aporte_mensual)="{ item }">
          {{ format_number(item.attributes.aporte_mensual) }}
        </template>
        <template v-slot:cell(attributes.ultimo_aporte_mes)="{ item }">
          {{ item.attributes.ultimo_aporte_mes }} / {{ item.attributes.ultimo_aporte_gestion }}
        </template>
        <template v-slot:actions="{ item }">
          <router-link :to="`/miembros/${item.id}/aportes`" class="btn btn-info">
            <i class="fas fa-list-ol"></i>
          </router-link>
        </template>
      </tabla>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/miembros",
  mixins: [window.ResourceMixin],
  data() {
    return {
      api: this.$api.miembro,
      params: {
        page: 1,
        per_page: 5,
        meta: "pagination",
        sort: 'nombre',
      },
      fields: [
        { key: "attributes.avatar", label: "", thStyle: "width: 5em;" },
        { key: "attributes.activo", label: "", thStyle: "width: 2em;" },
        { key: "attributes.nombre", label: "Nombre" },
        { key: "attributes.aporte_mensual", label: "Aporte mensual" },
        { key: "attributes.ultimo_aporte_mes", label: "Úlmito aporte" },
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
