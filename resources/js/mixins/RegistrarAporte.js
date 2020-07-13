import { cloneDeep } from 'lodash';

const nuevoRegistroCT = {
  id: null,
  attributes: {
    miembro_id: null,
    diario_id: null,
    mes: null,
    gestion: null,
    monto: null,
  },
};

let miembros;

export default {
  data() {
    return {
      miembro: null,
      complete: null,
      apiCT: this.$api.aportes,
      registroCT: cloneDeep(nuevoRegistroCT),
      formFieldsCT: [
        { key: "attributes.miembro_id", label: "Miembro", create: true, edit: true, component: "b-form-select",
          properties: {
            options: this.getMiembros(),
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
      const mes = global.meses.find(m => m.num == num);
      return mes && mes.nombre;
    },
    getMiembroIdField() {
      return this.formFields.find(f => f.key === 'attributes.miembro_id');
    },
    change(key, value, form) {
      if (key === 'attributes.detalle') {
        this.$api.diario.call(null, 'guessMemberId', { text: value })
          .then((miembro) => {
            this.miembro = miembro;
            form.setValue('attributes.miembro_id', miembro.id);
            form.setValue('attributes.ingreso', miembro.attributes.aporte_mensual);
            this.getMiembroIdField().label = `Miembro (último aporte: ${this.mes(miembro.attributes.ultimo_aporte_mes)}/${miembro.attributes.ultimo_aporte_gestion})`;
          });
      }
    },
    guardarCT() {
      this.$refs.formCT.guardar();
      this.complete && this.complete();
    },
    created(diario) {
      return new Promise((complete) => {
        if (diario.attributes.cuenta === 'CT') {
          this.registroCT = cloneDeep(nuevoRegistroCT);
          this.registroCT.attributes.miembro_id = diario.attributes.miembro_id;
          this.registroCT.attributes.diario_id = diario.id;
          this.registroCT.attributes.monto = diario.attributes.ingreso;
          this.registroCT.attributes.fecha = diario.attributes.fecha;
          this.registroCT.attributes.mes = (this.miembro.attributes.ultimo_aporte_mes % 12) + 1;
          this.registroCT.attributes.gestion = this.miembro.attributes.ultimo_aporte_gestion * 1 + (this.miembro.attributes.ultimo_aporte_mes == 12 ? 1 : 0);
          this.$refs.modalCT.show();
          this.complete = complete;
        }
      });
    },
    getMiembros() {
      if (!miembros) {
        miembros = this.$api.miembro.array({per_page: -1, sort:'+nombre'}, [{id:null, attributes:{nombre:''}}]);
      }
      return miembros;
    },
  },
};
