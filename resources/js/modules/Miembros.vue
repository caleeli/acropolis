<template>
  <panel name="Miembros" icon="fas fa-users" class="panel-success">
    <template slot="actions">
      Aportes {{ moment().format('YYYY') }}: <label class="badge badge-success" title="Aportes realizados durante la gestión actual">Bs {{ format_number(totalAporte) }}</label>
      Saldo pendiente: <label class="badge badge-danger" title="Total aportes pendientes a la fecha">Bs {{ format_number(totalPendiente) }}</label>
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
          <i :class="`${item.attributes.activo ? 'fas fa-circle text-success' : 'far fa-circle text-secondary'}`" :title="item.attributes.activo ? 'Miembro activo' : 'Miembro inactivo'"></i>
        </template>
        <template v-slot:cell(attributes.aporte_mensual)="{ item }">
          {{ format_number(item.attributes.aporte_mensual) }}
        </template>
        <template v-slot:cell(attributes.ultimo_aporte_mes)="{ item }">
          {{ mes(item.attributes.ultimo_aporte_mes) }} / {{ item.attributes.ultimo_aporte_gestion }}
        </template>
        <template v-slot:cell(attributes.saldo_pendiente)="{ item }">
          {{ format_number(item.attributes.saldo_pendiente) }}
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
      totalAporte: 0,
      totalPendiente: 0,
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
        { key: "attributes.aporte_mensual", label: "Aporte mensual", class: "text-right" },
        { key: "attributes.ultimo_aporte_mes", label: "Úlmito aporte", class: "text-center" },
        { key: "attributes.saldo_pendiente", label: "Pendiente", class: "text-right" },
        { key: "actions", label: "" },
      ],
      formFields: [
        { key: "attributes.nombre", label: "Nombre", create: true, edit: true },
        { key: "attributes.avatar", label: "", create: true, edit: true },
        { key: "attributes.aporte_mensual", label: "Aporte mensual", create: true, edit: true },
        { key: "attributes.activo", label: "Miembro activo", create: true, edit: true, component: "toggle" },
      ],
    };
  },
  mounted() {
    this.$api.miembros.call(null, 'totales').then(res => {
      this.totalAporte = res.totalAporte;
      this.totalPendiente = res.totalPendiente;
    })
  },
  methods: {
    mes(num) {
      const mes = global.meses.find(m => m.num == num);
      return mes && mes.nombre;
    },
  },
};
</script>
