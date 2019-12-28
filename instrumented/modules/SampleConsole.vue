<template>
  <panel name="Examen de simbologia" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <router-link to="/" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </router-link>
    </template>
    <b>Celtas</b>
    <p>Fecha: 3/dic/2019</p>
  </panel>
</template>

<script>
export default {
  path: "/sample/console",
  mixins: [window.workflowMixin],
  data() {
    return {
      actions: {
        close: {
          name: "",
          icon: "fas fa-times"
        }
      },
      log: ""
    };
  },
  watch: {
    "$route.query": {
      immediate: true,
      deep: true,
      handler() {
        this.cleanSocketListeners();
        this.listenConsole(log => {
          window.axios
            .get(log.url, { baseURL: "/" })
            .then(response => (this.log = response.data));
        });
      }
    }
  }
};
</script>
