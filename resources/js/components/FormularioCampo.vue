<template>
  <div v-if="field.key==='attributes.avatar'">
    <avatar v-model="value.attributes.avatar" style="font-size: 3em"></avatar>
    <div class="form-group">
      <div class="d-inline-block">
        <upload v-model="value.attributes.avatar" @change="updateAvatar" :autofocus="autofocus">
          <button type="button" class="btn btn-primary" :data-cy="`field.${field.key}`">Cambiar imagen</button>
        </upload>
      </div>
    </div>
  </div>
  <b-form-group
    v-else-if="field.component"
    :label="withoutLabel ? '': field.label"
    label-size="sm"
    :state="state"
    :invalid-feedback="invalidFeedback"
    :data-cy="`fieldset.${field.key}`" 
  >
    <component :is="field.component" v-bind="field.properties" :data-cy="`field.${field.key}`" :value="getValue(value, field.key)" @change="setValue(value, field.key, $event)" :autofocus="autofocus" />
  </b-form-group>
  <b-form-group
    v-else
    :label="withoutLabel ? '': field.label"
    label-size="sm"
    :state="state"
    :invalid-feedback="invalidFeedback"
    :data-cy="`fieldset.${field.key}`" 
  >
    <b-form-input class="form-control" :type="field.type || 'text'" :data-cy="`field.${field.key}`" :value="getValue(value, field.key)" @change="setValue(value, field.key, $event)" :autofocus="autofocus" />
  </b-form-group>
</template>

<script>
import { get, set } from 'lodash';

export default {
  props: {
    field: Object,
    value: Object,
    state: Boolean,
    changes: Object,
    invalidFeedback: String,
    withoutLabel: Boolean,
    autofocus: Boolean,
  },
  methods: {
    updateAvatar(avatar) {
      this.value.attributes.avatar = avatar;
    },
    getValue(object, key) {
      this.changes[key];
      return get(object, key);
    },
    setValue(object, key, value) {
      set(object, key, value);
      this.changes[key]++;
      this.$emit('change', key, value, { setValue: (k, v) => this.setValue(object, k, v) });
    },
  },
}
</script>
