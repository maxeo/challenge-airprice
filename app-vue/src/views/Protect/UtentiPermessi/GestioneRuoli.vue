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

          <h1 class="h3 mb-3"><strong>Gestione</strong> Ruoli</h1>

          <div class="row">
            <div class="col-12 d-flex">
              <div class="w-100">
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">

                        <div class="col-12">
                          <Crud
                              v-if="info?.user_permissions?.indexOf('roles-manage/list') > -1"

                              resource_prefix="manage-role"
                              permission_prefix="roles-manage"
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
  name: 'GestioneRuoli',
  components: {
    Crud,
    Footer,
    Navbar,
    Sidebar
  },
  data() {
    return {
      resource_data: {
        title: 'Ruolo',
        list_map: [
          {source: 'id', name: 'ID', class: 'fw-bold',},
          {source: 'name', name: 'Nome'},
          {
            source: 'permissions', name: 'Permessi', body_f: (roles) => {
              let ar = [];
              for (let i in roles) {
                ar.push(roles[i].name)
              }
              return ar.length ? ar.join(' - ') : '-';
            }
          },
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
    setTitle('Gestione Ruoli');
  },
  emits: ['do_logout', 'do_login', 'check-authenticate', 'toggle_sidebar_collapse'],
}
</script>
<style scoped>

</style>