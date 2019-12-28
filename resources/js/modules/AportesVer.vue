<template>
  <panel name="Ver mis aportes" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <div class="m-t">

    </div>
  </panel>
</template>

<script>
export default {
  path: "/aportes/ver",
  mixins: [window.ResourceMixin],
  data() {
    return {
      aportes: this.$api[`/user/1/aportes?filter[]=Consolidado`].array()
    };
  },
  methods: {
    uploadImage(imagen) {
      this.imagen = imagen;
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
