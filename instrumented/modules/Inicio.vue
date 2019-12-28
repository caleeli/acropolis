<template>
    <div class="principal position-relative">
        <router-link to="/mensaje/tipo" class="btn-plus"><i class="fas fa-pen"></i></router-link>
        <img src="http://www.acropolis.org.bo/wp-content/uploads/2016/08/portada0.jpg" class="portada">
        <div  style="padding:1em">
            <opcion-menu v-for="(opcion,index) in mensajes" :key="index" :value="opcion"></opcion-menu>
        </div>
    </div>
</template>

<script>
export default {
  path: "/",
  mixins: [window.ResourceMixin],
  data() {
    return {
      today: window.moment().format(),
      mensajes: this.$api[`/user/1/messages?include=category&sort=-id`].array()
    };
  }
};
</script>

<style scoped>
    .portada {
        width: 100%;
        height: 120px;
        display: block;
    }
    .principal {
        overflow: auto;
    }
    .btn-plus {
        position: absolute;
        top: 0.5em;
        right: 0.5em;
        width: 3em;
        height: 3em;
        padding: 1em;
        border-radius: 50%;
        background-color: darkgreen;
        color: white;
        display: table;
        text-align: center;
        vertical-align: middle;
    }
    .btn-plus i {
        display: table-cell;
    }
</style>
