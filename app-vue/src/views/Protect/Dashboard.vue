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
        <div class="container-fluid p-0" v-if="info?.user_permissions?.indexOf('dashboard/view') > -1">

          <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>

          <div class="row">
            <div class="col-12 d-flex">
              <div class="w-100">
                <div class="row">
                  <div class="col-sm-6 mt-2">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col mt-0">
                            <h5 class="card-title">Ricerche fatte</h5>
                          </div>

                          <div class="col-auto">
                            <div class="stat text-primary mb-1">
                              <i class="dash-icon fas fa-search"></i>
                            </div>
                          </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ getDashboardData('search_counter') ?? '...' }}</h1>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 mt-2">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col mt-0">
                            <h5 class="card-title">Voli prenotati</h5>
                          </div>

                          <div class="col-auto">
                            <div class="stat text-primary mb-1">
                              <i class="dash-icon fas fa-search-location"></i>
                            </div>
                          </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ getDashboardData('book_counter') ?? '...' }}</h1>
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

import {apiFetch, setTitle} from "../../helper/utility";
import Sidebar from "../../components/Sidebar";
import Navbar from "../../components/Navbar";
import Footer from "../../components/Footer";

export default {
  name: 'Dashboard',
  components: {
    Footer,
    Navbar,
    Sidebar
  },
  data() {
    return {
      dashboard_data: [],
    };
  },
  beforeMount() {
    this.$emit('check-authenticate');
    this.downloadDashboardData()
  },
  props: {
    access_token: String,
    sidebar_collapsed: Boolean,
    user: Object,
    info: Object,
    is_logged: Boolean,

  },
  methods: {
    getDashboardData(data_key) {
      let r = this.dashboard_data.filter(e => e.key_name === data_key);
      return r.length ? r[0].key_value : undefined;
    },
    downloadDashboardData() {
      if (this.info?.user_permissions?.indexOf('dashboard/view') > -1) {
        apiFetch(this.$apibase + '/info/dashboard/', {
          method: 'GET',
          headers: {
            'Content-type': 'application/json',
            'Accept': 'application/json',
            "Authorization": "Bearer " + this.access_token,
          },
        }, response => {
          if (response.success) {
            this.dashboard_data = response.data;
          }
        })
      }
    },
  },
  setup(props, {emit}) {
    setTitle();
  },
  emits: ['do_logout', 'do_login', 'check-authenticate', 'toggle_sidebar_collapse'],
}
</script>
<style scoped>
.dash-icon {
  color: #034ea2;
}

.table > :not(:last-child) > :last-child > *,
.table tbody, .table td, .table tfoot, .table th, .table thead, .table tr {
  border-color: #373b3e;
}

td.th {

}
</style>