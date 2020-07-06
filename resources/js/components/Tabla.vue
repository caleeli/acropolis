<template>
  <div class="d-flex flex-column h-100">
    <div class="d-flex flex-wrap flex-sm-nowrap">
      <b-input-group :class="{invisible: !searchIn}">
        <b-form-input :lazy="true" v-model="searchValue" @change="search" data-cy="tabla.input.search"></b-form-input>
        <b-input-group-append>
          <b-button variant="outline-secondary" @click="search" data-cy="tabla.search">
            <i class="fas fa-search"></i>
            <span class="d-none d-sm-inline">{{ __('buscar') }}</span>
          </b-button>
        </b-input-group-append>
      </b-input-group>
      <b-input-group v-if="params.per_page!==-1" class="flex-nowrap" style="width: 25em">
        <b-input-group-prepend>
          <b-button variant="outline-secondary" :disabled="params.page<=1" @click="setPage(1)" data-cy="table-toolbar-first"><i class="fas fa-step-backward"></i></b-button>
          <b-button variant="outline-secondary" :disabled="params.page<=1" @click="setPage(params.page - 1)" data-cy="table-toolbar-previous"><i class="fas fa-caret-left"></i></b-button>
        </b-input-group-prepend>
        <b-form-input v-model="page" :lazy="true" class="text-right" @change="setPage"></b-form-input>
        <b-input-group-append>
          <b-button variant="outline-secondary" disabled>/{{ meta.last_page }}</b-button>
          <b-button variant="outline-secondary" :disabled="params.page>=meta.last_page" @click="setPage(params.page + 1)" data-cy="table-toolbar-next"><i class="fas fa-caret-right"></i></b-button>
          <b-button variant="outline-secondary" :disabled="params.page>=meta.last_page" @click="setPage(meta.last_page)" data-cy="table-toolbar-last"><i class="fas fa-step-forward"></i></b-button>
        </b-input-group-append>
      </b-input-group>
    </div>
    <b-table :items="value" :fields="fields" responsive data-cy="tabla.table">
      <template v-slot:cell()="data">
        <slot v-if="hasSlot(`cell(${data.field.key})`)" :name="`cell(${data.field.key})`" v-bind="data" :update="update"></slot>
        <formulario-campo v-else-if="inline && data.item.edit"
          class="m-0"
          without-label
          :field="data.field"
          :value="data.item"
          :state="data.item.state"
          :feedback="feedback(data.item, data.field.key)"
        />
        <template v-else>
          {{ getValue(data.item, data.field.key) }}
        </template>
      </template>
      <template v-slot:cell(attributes.avatar)="data">
        <avatar style="font-size: 2em" :value="data.item.attributes.avatar" />
      </template>
      <template v-slot:head(actions)="">
        <div class="w-100 text-right">
          <div class="btn-group text-nowrap" role="group">
            <slot name="toolbar"></slot>
            <b-button v-if="!readonly" variant="primary" @click="loadData" data-cy="tabla.refresh"><i class="fas fa-sync"></i></b-button>
            <b-button v-if="!readonly" variant="primary" @click="nuevo" data-cy="tabla.new"><i class="fas fa-plus"></i></b-button>
          </div>
        </div>
      </template>
      <template v-slot:cell(actions)="data">
        <div class="w-100 text-right">
          <div class="btn-group text-nowrap" role="group">
            <slot name="actions" v-bind="data"></slot>
            <b-button data-cy="tabla.row.edit" v-if="!inline" variant="primary" @click="editar(data.item)"><i class="fas fa-pen"></i></b-button>
            <b-button data-cy="tabla.row.edit" v-else-if="!data.item.edit" variant="primary" @click="editarInline(data.item)"><i class="fas fa-pen"></i></b-button>
            <b-button data-cy="tabla.row.save" v-else variant="primary" @click="guardarInline(data.item)"><i class="fas fa-save"></i></b-button>
            <b-button data-cy="tabla.row.remove" variant="danger" @click="eliminar(data.item)"><i class="fas fa-times"></i></b-button>
          </div>
        </div>
      </template>
    </b-table>
    <b-modal
      ref="modal"
      :title="title"
      hide-backdrop
      @ok="guardar"
    >
      <formulario ref="formulario" :fields="formFieldsF" :value="registro" :api="api" />
      <template slot="modal-ok">
        <i class="fas fa-save"></i> Guardar
      </template>
      <template slot="modal-cancel">
        <i class="fas fa-window-close"></i> Cancelar
      </template>
    </b-modal>
  </div>
</template>

<script>
import { get, set, cloneDeep } from 'lodash';

const nuevoRegistro = {
  id: null,
  attributes: {},
};
const nuevoRegistroInline = {
  id: null,
  edit: true,
  state: null,
  error: '',
  errors: {},
  attributes: {},
};
export default {
  mixins: [window.ResourceMixin],
  props: {
    inline: {
      type: Boolean,
      default: false,
    },
    params: {
      type: Object,
      default() {
        return {
          page: 1,
          per_page: 5,
          meta: "pagination",
        };
      },
    },
    searchIn: Array,
    fields: Array,
    formFields: Array,
    api: Object,
    title: String,
    readonly: Boolean,
  },
  computed: {
    formFieldsF() {
      return this.formFields.filter(field => {
        return (!this.registro.id && (field.create)) || 
          (this.registro.id && (field.edit));
      });
    }
  },
  data() {
    return {
      searchValue: '',
      value: [],
      meta: {
        total: 0,
        last_page: 0,
      },
      page: this.params.page || 1,
      registro: Object.assign(cloneDeep(nuevoRegistro), this.getDefaults()),
      error: '',
    };
  },
  methods: {
    getDefaults() {
      const object = {};
      this.formFields.forEach(field => field.default ? set(object, field.key, field.default) : null);
      return object;
    },
    update(row) {
      this.api.save(row).catch(res => {
        this.error = res.response.data.message;
      }).then(() => {
        this.loadData();
      });
    },
    hasSlot(name) {
      return !!this.$scopedSlots[name];
    },
    search() {
      if (this.searchIn) {
        const filter = `whereAjaxFilter,${JSON.stringify(this.searchValue)},${this.searchIn.join(',')}`;
        if (this.params.filter === undefined) {
          this.params.filter = [];
        }
        const index = this.params.filter.findIndex(filter => filter.substr(0, 16) === 'whereAjaxFilter,');
        if (index === -1) {
          this.params.filter.push(filter);
        } else {
          this.params.filter[index] = filter;
        }
        this.page = 1;
        this.params.page = this.page;
        this.loadData();
      }
    },
    setPage(page) {
      if (this.params.page != page) {
        this.params.page = page;
        this.loadData();
      }
    },
    eliminar(registro) {
      this.$bvModal.msgBoxConfirm(this.__('Are you sure to delete this item?'), {
        title: this.__('Delete confirmation'),
        size: 'sm',
        buttonSize: 'sm',
        okVariant: 'danger',
        okTitle: this.__('yes'),
        cancelTitle: this.__('no'),
        hideHeaderClose: false,
        hideBackdrop: true,
        centered: true
      })
      .then(value => {
        if (value) {
          this.api.delete(registro).then(() => {
            this.loadData();
          }).catch(res => {
            alert(res.response.data.message);
          });
        }
      });
    },
    editar(registro) {
      this.error = '';
      this.registro = registro;
      this.$refs.modal.show();
    },
    guardar(bvModalEvt) {
      bvModalEvt.preventDefault();
      this.$refs.formulario.guardar().then(() => {
        this.$refs.modal.hide();
        this.loadData();
      });
    },
    feedback(row, key) {
      const errors = row.errors;
      return (errors[key] || []).join('. ');
    },
    loadErrors(row, errors) {
      const loaded = {};
      if (errors) {
        for(let e in errors) {
          const a = `attributes.${e}`;
          loaded[a] = errors[e];
        }
      }
      this.$set(row, 'errors', loaded);
    },
    editarInline(row) {
      this.$set(row, 'edit', true);
      this.$set(row, 'state', null);
      this.$set(row, 'error', '');
      this.$set(row, 'errors', {});
    },
    guardarInline(row) {
      row.state = null;
      if (row.id) {
        this.api.save(row).then((res) => {
          row.state = true;
          row.edit = false;
          this.api.refresh(row).then(() => {
            this.$emit('change');
          });
        }).catch(res => {
          row.error = res.response.data.message;
          this.loadErrors(row, res.response.data.errors);
          row.state = false;
        });
      } else {
        this.api.post(row).then((res) => {
          row.state = true;
          row.edit = false;
          this.$emit('change');
        }).catch(res => {
          row.error = res.response.data.message;
          this.loadErrors(row, res.response.data.errors);
          row.state = false;
        });
      }
    },
    getValue(object, key) {
      return get(object, key);
    },
    setValue(object, key, event) {
      set(object, key, event.target.value);
    },
    nuevo() {
      this.error = '';
      if (this.inline) {
        this.value.push(Object.assign(cloneDeep(nuevoRegistroInline), this.getDefaults()));
      } else {
        this.$set(this, 'registro', Object.assign(cloneDeep(nuevoRegistro), this.getDefaults()));
        this.$refs.modal.show();
      }
    },
    loadData() {
      this.value.splice(0);
      this.api.index(this.params, this.value).then(response => {
        this.meta = response.data.meta;
        if (this.meta.page) this.page = this.meta.page;
        this.value.forEach(row => {
          this.$set(row, 'edit', false);
        });
      });
    },
  },
  mounted() {
    this.loadData(); 
  },
}
</script>

<style>

</style>