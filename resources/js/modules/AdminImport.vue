<template>
  <panel name="Importar" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <div class="m-t">
      <div class="form-group">
        <div class="d-inline-block">
          <upload
            v-model="excel"
            @change="importExcel"
            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
          >
            <button id="load-excel" type="button" class="btn btn-primary">
              <i class="fas fa-file-excel"></i> Cargar archivo
            </button>
          </upload>
          <pre>{{ result }}</pre>
        </div>
      </div>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/admin/import",
  mixins: [window.ResourceMixin],
  data() {
    return {
      excel: null,
      result: ""
    };
  },
  methods: {
    importExcel(excel) {
      this.$api.aportes.call(null, "importar", { excel }).then(r => {
        this.result = r;
        console.log(r);
      });
    }
  },
  mounted() {}
};
</script>

<style scoped>
.imagen {
  display: block;
  width: 100%;
}
</style>
