<template>
  <panel :name="title" :icon="icon" class="panel-success">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <div class="m-t">
      <div v-if="mensaje.attributes" class="form-group" v-html="mensaje.attributes.content"></div>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/mensaje/ver/:id",
  mixins: [window.ResourceMixin],
  props: {
    id: String
  },
  data() {
    return {
      mensaje: this.$api.messages.row(this.id)
    };
  },
  computed: {
    title() {
      return this.mensaje.attributes ? this.mensaje.attributes.title : "";
    },
    icon() {
      return this.mensaje.attributes ? this.mensaje.attributes.icon : "";
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
