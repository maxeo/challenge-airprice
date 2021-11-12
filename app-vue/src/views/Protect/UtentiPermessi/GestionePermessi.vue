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

          <h1 className="h3 mb-3"><strong>Gestione</strong> Permessi</h1>

          <div className="row">
            <div className="col-12 d-flex">
              <div className="w-100">
                <div className="row">
                  <div className="col-12">
                    <div className="card">
                      <div className="card-body">

                        <div className="col-12">
                          <Crud
                              v-if="info?.user_permissions?.indexOf('roles-manage/list') > -1"

                              resource_prefix="manage-permission"
                              permission_prefix="permissions-manage"
                              :resource_data="resource_data"

                              :info="info"
                              :access_token="access_token"
                          />
                        </div>


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

import {setTitle} from "../../../helper/utility";
import Sidebar from "../../../components/Sidebar";
import Navbar from "../../../components/Navbar";
import Footer from "../../../components/Footer";
import Crud from "@/components/Crud/Crud";

export default {
  name: 'GestionePermessi',
  components: {
    Crud,
    Footer,
    Navbar,
    Sidebar
  },
  data() {
    return {
      resource_data: {
        title: 'Permesso',
        list_map: [
          {source: 'id', name: 'ID', class: 'fw-bold',},
          {source: 'name', name: 'Nome'},
        ]
      }


    };
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
    setTitle('Gestione Permessi');
  },
  emits: ['do_logout', 'do_login', 'check-authenticate', 'toggle_sidebar_collapse'],
}
</script>
<style scoped>

</style>