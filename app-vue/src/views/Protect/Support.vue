<template>
  <div class="wrapper" v-if="is_logged">
    <Sidebar :collapsed="sidebar_collapsed" :info="info"/>

    <div class="main">
      <Navbar
          @toggle_sidebar_collapse="$emit('toggle_sidebar_collapse')"
          @do_logout="$emit('do_logout')"
          :user="user"
          :info="info"
      />

      <main class="content">
        <div class="container-fluid p-0">

          <h1 class="h3 mb-3"><strong>Supporto</strong></h1>

          <div class="row">
            <div class="col-12 d-flex">
              <div class="w-100">
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">

                        <form>
                          <div class="col-12">
                            <h4>Vedi il mio sito web</h4>
                            <h5><a href="https://www.maxeo.net" target="_blank">Clicca qui</a></h5>


                          </div>
                        </form>


                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


          </div>


        </div>
      </main>

      <Footer></Footer>
    </div>
  </div>
</template>

<script>

import {setTitle} from "../../helper/utility";
import Sidebar from "../../components/Sidebar";
import Navbar from "../../components/Navbar";
import Footer from "../../components/Footer";

export default {
  name: 'Support',
  components: {
    Footer,
    Navbar,
    Sidebar
  },
  data() {
    return {
    };
  },
  beforeMount() {
    this.$emit('check-authenticate');
  },
  props: {
    access_token: String,
    sidebar_collapsed:Boolean,
    user: Object,
    info: Object,
    is_logged: Boolean,
  },
  methods: {
  },
  setup(props, {emit}) {
    setTitle('Supporto');
  },
  emits: ['do_logout', 'do_login', 'check-authenticate','toggle_sidebar_collapse'],
}
</script>
<style scoped>
.table-dark {
  --bs-table-bg: #222e3c;
  color: #fff;
}


</style>