<template>
  <panel :name="user.attributes.name" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <div class="m-t">
      <avatar v-model="user" style="font-size: 8em"></avatar>
      <div class="form-group">
        <div class="d-inline-block">
          <upload v-model="avatar" @change="updateAvatar">
            <button type="button" class="btn btn-primary">Cambiar imagen</button>
          </upload>
        </div>
      </div>
      <div class="form-group">
        <label>Nombre de usuario</label>
        <input id="name" class="form-control" v-model="user.attributes.name" />
      </div>
      <div class="form-group">
        <label>Correo electrónico</label>
        <input id="email" class="form-control" v-model="user.attributes.email" />
      </div>
      <div class="form-group">
        <label>Iniciales</label>
        <input id="iniciales" class="form-control" v-model="user.attributes.iniciales" />
      </div>
      <button id="save" type="button" class="btn btn-success" @click="save">
        <i class="fas fa-save"></i> Guardar
      </button>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/user/avatar",
  mixins: [window.workflowMixin],
  data() {
    return {
      avatar: null,
      user: this.$root.user
    };
  },
  methods: {
    save() {
      this.$root.$api.user
        .axios(null, {
          url: "/api/data/user/" + this.user.id,
          method: "put",
          data: { data: this.user }
        })
        .then(() => {
          window.history.go(-1);
        });
    },
    updateAvatar(avatar) {
      this.user.attributes.avatar = avatar;
    }
  }
};
</script>
