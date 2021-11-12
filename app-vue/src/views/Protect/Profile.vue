<template>
  <div class="wrapper" v-if="is_logged">
    <Sidebar :collapsed="sidebar_collapsed" :info="info"/>

    <div className="main">
      <Navbar
          @toggle_sidebar_collapse="$emit('toggle_sidebar_collapse')"
          @do_logout="$emit('do_logout')"
          :user="user"
          :info="info"
      />

      <main className="content">
        <div className="container-fluid p-0">

          <h1 className="h3 mb-3"><strong>Profilo</strong></h1>

          <div className="row">
            <div className="col-12 d-flex">
              <div className="w-100">
                <div className="row">
                  <div className="col-12">
                    <div className="card">
                      <div className="card-body">

                        <form>
                          <div className="col-12">
                            <h4>Informazioni del profilo</h4>
                            <p>
                              <b>Nome:</b> {{ user?.first_name }} <br>
                              <b>Cognome:</b> {{ user?.last_name }} <br>
                              <b>Username:</b> {{ user?.username }} <br>
                              <b>Email:</b> {{ user?.email }} <br>
                            </p>


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
  name: 'Profile',
  components: {
    Footer,
    Navbar,
    Sidebar
  },
  data() {
    return {};
  },
  beforeMount() {
    this.$emit('check-authenticate');
  },
  props: {
    access_token: String,
    sidebar_collapsed: Boolean,
    user: Object,
    info: Object,
    is_logged: Boolean,
  },
  methods: {},
  setup(props, {emit}) {
    setTitle('Profilo Utente');
  },
  emits: ['do_logout', 'do_login', 'check-authenticate', 'toggle_sidebar_collapse'],
}
</script>
<style scoped>

</style>