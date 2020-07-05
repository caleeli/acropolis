<template>
  <panel name="Registro ingreso/egreso" icon="fa fa-table" class="panel-success">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <div class="m-t">
      <formulario ref="formulario" :fields="formFields" :value="registro" :api="api">
      </formulario>
    </div>
    <button id="save" type="button" class="btn btn-secondary" @click="cancel">
      <i class="fas fa-times"></i> Cancelar
    </button>
    <button id="save" type="button" class="btn btn-success" @click="save">
      <i class="fas fa-save"></i> Guardar
    </button>
  </panel>
</template>

<script>
export default {
  path: '/registrar/ingreso',
  mixins: [window.ResourceMixin],
  data() {
    return {
      api: this.$api.diario,
      registro: {
        id: null,
        attributes: {
          detalle: '',
          libreta: 'caja',
          recibo: '',
          fecha: moment().format('YYYY-MM-DD'),
          miembro_id: null,
        },
      },
      formFields: [
        { key: "attributes.detalle", label: "Detalle", create: true, edit: true },
        { key: "attributes.ingreso", label: "Ingreso", create: true, edit: true },
        { key: "attributes.egreso", label: "Egreso", create: true, edit: true },
        { key: "attributes.cuenta", label: "Categoría", create: true, edit: true, component: "b-form-select",
          properties: {
            options: this.$api.economia_categorias.array({per_page: -1, filter:['whereNotNull,codigo'], sort:'+nombre'}),
            'value-field': 'attributes.codigo',
            'text-field': 'attributes.nombre',
          },
        },
        { key: "attributes.libreta", label: "Caja/Cuenta Banco", create: true, edit: true, component: "b-select",
          properties: {
            options: ['caja', 'cuenta'],
          }
        },
        { key: "attributes.recibo", label: "Recibo", create: true, edit: true },
        { key: "attributes.fecha", label: "Fecha", create: true, edit: true, component: 'datetime',
          properties: {
            type: 'date',
          },
        },
        { key: "attributes.miembro_id", label: "Miembro", create: true, edit: true, component: "b-form-select",
          properties: {
            options: this.$api.miembro.array({per_page: -1, sort:'+nombre'}, [{id:null, attributes:{nombre:''}}]),
            'value-field': 'id',
            'text-field': 'attributes.nombre',
          },
        },
      ]
    };
  },
  methods: {
    save() {
      this.$refs.formulario.guardar().then(() => {
        this.$router.go(-1);
      });
    },
    cancel() {
      this.$router.go(-1);
    },
  },
}
</script>

<style>

</style>