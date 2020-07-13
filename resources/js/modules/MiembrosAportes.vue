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
        title="Aporte"
        :search-in="['attributes.nombre']"
      >
        <template v-slot:toolbar>
          <!-- b-button variant="success" :href="`${apiExcel}`" target="_blank" data-cy="tabla.excel"><i class="fas fa-file-excel"></i></!-->
        </template>
        <template v-slot:cell(attributes.monto)="{ item }">
          {{ format_number(item.attributes.monto) }}
        </template>
        <template v-slot:cell(attributes.mes)="{ item }">
          {{ mes(item.attributes.mes) }}
        </template>
        <template v-slot:cell(attributes.fecha)="{ item }">
          {{ item.attributes.fecha && moment(item.attributes.fecha).format('DD-MM-YYYY') }}
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
    const miembros = this.$api.miembro.array({per_page: -1, sort:'+nombre'}, [{id:null, attributes:{nombre:''}}]);
    return {
      //api: this.$api[`miembro/${this.id}/aportes`],
      api: this.$api.aportes,
      params: {
        page: 1,
        per_page: 5,
        meta: "pagination",
        filter: ['where,miembro_id,' + this.id],
        sort: '-gestion,-mes',
      },
      fields: [
        { key: "attributes.fecha", label: "Fecha"},
        { key: "attributes.mes", label: "Mes"},
        { key: "attributes.gestion", label: "Gestion"},
        { key: "attributes.monto", label: "Monto" },
        { key: "actions", label: "" },
      ],
      formFields: [
        { key: "attributes.miembro_id", label: "Miembro", create: true, edit: true, component: "b-form-select",
          default: this.id,
          properties: {
            options: miembros,
            'value-field': 'id',
            'text-field': 'attributes.nombre',
          },
        },
        { key: "attributes.diario_id", label: "# diario", create: true, edit: true },
        { key: "attributes.mes", label: "Mes", create: true, edit: true, component: "b-form-select",
          properties: {
            options: global.meses,
            'value-field': 'num',
            'text-field': 'nombre',
          },
        },
        { key: "attributes.gestion", label: "Gestión", create: true, edit: true },
        { key: "attributes.monto", label: "Monto", create: true, edit: true },
        { key: "attributes.fecha", label: "Fecha", create: true, edit: true, component: 'datetime',
          default: moment().format('YYYY-MM-DD'),
          properties: {
            type: 'date',
          },
        },
      ],
    };
  },
  methods: {
    mes(num) {
      return global.meses.find(m => m.num == num).nombre;
    },
  },
};
</script>
