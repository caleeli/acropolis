<template>
  <panel name="Nuevo mensaje" icon="fas fa-pen" class="panel-success">
    <template slot="actions">
      <router-link to="/" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
      </router-link>
    </template>
    <div class="m-t">
      <div>Categoria</div>
      <div class="btn-group" role="group">
        <button
          v-for="categoria in categorias"
          :key="categoria.id"
          type="button"
          class="btn"
          :class="{'btn-secondary':categoria.id==categoria_id,'btn-light':categoria.id!=categoria_id}"
          @click="categoria_id=categoria.id"
        >
          <i :class="categoria.attributes.icon"></i>
          <small>{{categoria.attributes.name}}</small>
        </button>
      </div>
      <div>Icono</div>
      <div class="btn-group" role="group">
        <button
          v-for="icon in icons"
          :key="icon"
          type="button"
          class="btn"
          :class="{'btn-secondary':icono==icon,'btn-light':icono!=icon}"
          @click="icono=icon"
        >
          <i :class="icon"></i>
        </button>
      </div>
      <div>Título</div>
      <input class="form-control" v-model="titulo" />
      <div>Texto</div>
      <tinymce v-model="contenido"></tinymce>
      <button type="button" class="btn btn-success" @click="enviar">Enviar</button>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/mensaje/nuevo/:template",
  mixins: [window.ResourceMixin],
  props: {
    template: String
  },
  data() {
    return {
      icons: [
          'fas fa-calendar-day',
          'fas fa-coins',
          'fas fa-book-reader',
          'fas fa-walking',
      ],
      templeta: this.$api.templates.row(this.template),
      categorias: this.$api.categories.array(),
      userApi: this.$api.user,
      icono: "",
      categoria_id: 1,
      titulo: "",
      contenido: "",
      link: ""
    };
  },
  methods: {
    enviar() {
      this.userApi
        .call(this.$root.user.id, "sendMessage", {
          icon: this.icono,
          category_id: this.categoria_id,
          title: this.titulo,
          content: this.contenido,
          link: this.link
        })
        .then(() => {
          this.$router.push({ path: "/" });
        }).catch(error => {
            alert(error.response.data.message);
        });
    }
  },
  watch: {
    templeta: {
      deep: true,
      handler(templeta) {
        this.icono = templeta.attributes.icon;
        this.categoria_id = templeta.attributes.category_id;
        this.titulo = templeta.attributes.title;
        this.contenido = templeta.attributes.content;
        this.link = templeta.attributes.link;
      }
    }
  }
};
</script>
