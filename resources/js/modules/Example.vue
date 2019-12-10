<template>
    <div class="principal">
        <img src="http://www.acropolis.org.bo/wp-content/uploads/2016/08/portada0.jpg" class="portada">
        <div  style="padding:1em">
            <opcion-menu v-for="(opcion,index) in opciones" :key="index" :value="opcion"></opcion-menu>
        </div>
    </div>
</template>

<script>
export default {
  path: "/",
  mixins: [window.workflowMixin],
  data() {
    return {
      today: window.moment().format(),
      opciones: [
          {
              icon: "fas fa-address-book",
              content: "<h5>Recordatorio Aporte Mensual</h5><p>Último aporte: Agosto/2019</p>",
              link: "/",
          },
          {
              icon: "fas fa-book-reader",
              content: "<h5>Examen de Simbología</h5><p><b>Celtas:</b> 3/dic/2019</p>",
              link: "/sample/console",
          },
          {
              icon: "fas fa-address-book",
              content: "<h5>Registrar aporte mensual</h5><p>Sube la imagen de tu recibo/deposito</p>",
              link: "/aporte/registrar",
          },
          {
              icon: "fas fa-walking",
              content: "<h5>Caminata por El Choro</h5><p>12/feb/2020. Bs.30</p><a href='#/evento/5/registrar'>Registrate</a>",
              link: "/evento/5/registrar",
          },
          {
              icon: "fas fa-user",
              content: "<h5>Cambia tu avatar</h5><p>Cambia la imagen de tu avatar</p>",
              link: "/user/avatar",
          },
      ],
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
</style>
