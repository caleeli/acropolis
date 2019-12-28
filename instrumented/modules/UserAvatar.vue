<template>
  <panel name="Cambia tu avatar" icon="fa fa-user" class="panel-success">
    <template slot="actions">
      <router-link to="/" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </router-link>
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
    updateAvatar(avatar) {
        console.log('entro!!');
      this.user.attributes.avatar = avatar;
      this.$root.$api.user.axios(null, {
        url: "/api/data/user/" + this.user.id,
        method: "put",
        data: { data: this.user }
      });
    }
  }
};
</script>
