<template>
  <div class="main-bg">
    <div class="d-flex justify-content-center h-100">
      <div class="message-flex">
        <h1>404</h1>
        <h2>Pagina non trovata</h2>
        <router-link :to="$router.getByName('home-page')">torna alla home</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import {setTitle} from "../helper/utility";

export default {
  name: "PageNotFound",
  setup() {
    setTitle('Pagina non trovata',false);
  }
}
</script>

<style scoped>
.main-bg {
  height: 100vh;
  margin: 0;
  background: linear-gradient(45deg, #17ead9, #6078ea);
}

.message-flex {
  margin-top: auto;
  margin-bottom: auto;
  display: flex;
  justify-content: center;
  flex-direction: column;
  text-align: center;
}
h1{
  font-size: 140px;
}
h2{
  font-size: 40px;
}
a {
  color: #FFF;
  font-size: 30px;
  text-transform: uppercase;
  text-decoration: none;
}
a:hover {
  text-decoration: underline;
}
</style>