<template>
  <panel name="Tipo de mensaje" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <router-link to="/" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </router-link>
    </template>
    <div class="m-t">
      <div class="form-group">
        <div>Escoge el tipo de mensaje</div>
        <button
          v-for="template in templates"
          :key="template.id"
          type="button"
          class="btn btn-light"
          @click="seleccionarTempleta(template)"
        >
          <i :class="template.attributes.icon"></i><br>
          <small>{{template.attributes.title}}</small>
        </button>
      </div>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/mensaje/tipo",
  mixins: [window.ResourceMixin],
  data() {
    return {
      templates: this.$api.templates.array(),
    };
  },
  methods: {
    seleccionarTempleta(template) {
      this.$router.push({path: '/mensaje/nuevo/' + template.id});
    }
  }
};
</script>

<style scoped>
.imagen {
  display: block;
  width: 100%;
}
</style>
