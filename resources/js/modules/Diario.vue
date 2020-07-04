<template>
  <panel :name="`Diario - ${$route.query.title || ''}`" icon="fa fa-table" class="panel-success">
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
        <template v-slot:toolbar>
          <b-button variant="success" :href="`${apiExcel}`" target="_blank" data-cy="tabla.excel"><i class="fas fa-file-excel"></i></b-button>
        </template>
        <template v-slot:cell(attributes.fecha)="{ item }">
          {{ format_date(item.attributes.fecha) }}
        </template>
        <template v-slot:cell(attributes.ingreso)="{ item }">
          {{ format(item.attributes.ingreso) }}
        </template>
        <template v-slot:cell(attributes.egreso)="{ item }">
          {{ format(item.attributes.egreso) }}
        </template>
        <template v-slot:cell(attributes.saldo)="{ item }">
          {{ format(item.attributes.saldo) }}
        </template>
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
        { key: "attributes.ingreso", label: "Ingreso", class: "text-right" },
        { key: "attributes.egreso", label: "Egreso", class: "text-right" },
        { key: "attributes.saldo", label: "Saldo", class: "text-right" },
        { key: "attributes.cuenta", label: "Cuenta", class: "text-center" },
        { key: "attributes.libreta", label: "" },
        { key: "actions", label: "" },
      ],
      formFields: [
        { key: "attributes.detalle", label: "Detalle", create: true, edit: true },
        { key: "attributes.ingreso", label: "Ingreso", create: true, edit: true },
        { key: "attributes.egreso", label: "Egreso", create: true, edit: true },
        { key: "attributes.cuenta", label: "Cuenta/Área", create: true, edit: true, component: "b-form-select",
          properties: {
            options: this.$api.economia_categorias.array({per_page: -1, filter:['whereNotNull,codigo'], sort:'+nombre'}),
            'value-field': 'attributes.codigo',
            'text-field': 'attributes.nombre',
          },
        },
        { key: "attributes.libreta", label: "Caja/Cuenta", create: true, edit: true, component: "b-select",
          default: this.$route.query.title === 'Cuenta' ? 'cuenta' : 'caja',
          properties: {
            options: ['caja', 'cuenta'],
          }
        },
        { key: "attributes.recibo", label: "Recibo", create: true, edit: true },
        { key: "attributes.fecha", label: "Fecha", create: true, edit: true, component: 'datetime',
          default: moment().format('YYYY-MM-DD'),
          properties: {
            type: 'date',
          },
        },
      ],
    };
  },
  computed: {
    apiExcel() {
      return '/excel/diario?per_page=-1&filter[]=whereCaja&columns=' + encodeURIComponent([
        'attributes.fecha_f',
        'attributes.detalle',
        'attributes.ingreso',
        'attributes.egreso',
        'attributes.saldo',
        'attributes.recibo',
        'attributes.cuenta',
      ].join(','));
    },
    params() {
      const params = {
        page: 1,
        per_page: 5,
        meta: 'pagination',
        sort: '-id',
      };
      if (this.$route.query.filter) {
        params.filter = this.$route.query.filter.split('|');
      }
      return params;
    },
  },
  methods: {
    format_date(value) {
      return moment(value).format('DD-MM-YYYY');
    },
    format(value) {
      return new Intl.NumberFormat("en-US", {style: 'currency', currency: 'BOB' })
        .format(value)
        .substr(3);
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
