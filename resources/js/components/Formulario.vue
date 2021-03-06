<template>
  <div v-if="value.attributes">
    <template v-for="(field,index) in fields">
      <formulario-campo :key="`field-${index}`"
        :field="field"
        :value="value"
        :state="state"
        :changes="changes"
        :invalid-feedback="feedback(field.key)"
        :autofocus="index===0"
        @change="change"
      />
    </template>
    <div class="text-right w-100 mt-2" data-cy="form.status">
      <label class="text-danger" v-if="error">{{ error }}</label>
      <ul class="text-danger font-weight-light" v-for="(error, index) in errorsInFieldsNotPresent" :key="`error-np-${index}`">
        <li v-for="(label, i) in error" :key="`error-np-${index}-${i}`">{{ label }}</li>
      </ul>
      <label class="text-success" v-if="success">{{ success }} <i class="fa fa-check"></i></label>
    </div>
  </div>
</template>

<script>
export default {
  mixins: [window.ResourceMixin],
  props: {
    value: Object,
    fields: Array,
    api: Object,
  },
  data() {
    const changes = {};
    this.fields.forEach(({key}) => changes[key] = 0);
    return {
      changes,
      state: null,
      errors: {},
      error: '',
      success: '',
    };
  },
  computed: {
    errorsInFieldsNotPresent() {
      const errors = {};
      for(let e in this.errors) {
        !this.fields.find(field => field.key === e) ? errors[e] = this.errors[e] : null;
      }
      return errors;
    },
  },
  methods: {
    change(...params) {
      this.$emit('change', ...params);
    },
    loadErrors(errors) {
      const loaded = {};
      if (errors) {
        for(let e in errors) {
          const a = `attributes.${e}`;
          loaded[a] = errors[e];
        }
      }
      this.$set(this, 'errors', loaded);
    },
    feedback(key) {
      const errors = this.errors;
      return (errors[key] || []).join('. ');
    },
    guardar() {
      return new Promise((accept, reject) => {
        this.success = '';
        this.state = null;
        if (this.value.id) {
          this.api.save(this.value).then((res) => {
            this.api.refresh(this.value);
            this.success = 'Los cambios se guardaron correctamente';
            this.state = true;
            accept(res.data.data);
          }).catch(res => {
            this.error = this.__(res.response.data.message);
            this.loadErrors(res.response.data.errors);
            this.state = false;
            reject(res.data.data);
          });
        } else {
          this.api.post(this.value).then((res) => {
            this.success = this.__('Los cambios se guardaron correctamente');
            this.state = true;
            accept(res.data.data);
          }).catch(res => {
            this.error = res.response.data.message;
            this.loadErrors(res.response.data.errors);
            this.state = false;
            reject(res.data.data);
          });
        }
      });
    },
  },
}
</script>
