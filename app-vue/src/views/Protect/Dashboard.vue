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
                        <h1 class="mt-1 mb-3">398</h1>
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
                        <h1 class="mt-1 mb-3">274</h1>
                      </div>
                    </div>
                  </div>

                  <div class="col-12 mt-4" v-if="info?.user_permissions?.indexOf('preventivi/history/view') > -1">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col mt-0">
                            <h5 class="card-title">Ultimi preventivi</h5>
                          </div>

                          <div class="col-auto">
                            <div class="stat text-primary mb-1">
                              <i class="dash-icon fal fa-money-check"></i>
                            </div>
                          </div>
                        </div>
                        <div class="table-responsive">
                          <table class="table table-sm table-bordered text-center table-hover table-striped">
                            <thead class="table-dark">
                            <tr>
                              <th>Cliente</th>
                              <th>Data</th>
                              <th>Formato</th>
                              <th>Quantità</th>
                              <th>Dettagli generali</th>
                              <th>Totale preventivo</th>
                              <th>Totale cad</th>
                              <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                              <td>Azienda Agricola Prova</td>
                              <td>30/02/2020</td>
                              <td>120x200</td>
                              <td>12.000</td>
                              <td>Stampa K + Pantone + Serigrafia</td>
                              <td>2.640 €</td>
                              <td>0,22 cad</td>
                              <td>
                                <button class="btn btn-success btn-sm me-1" type="button"><i class="fal fa-edit"></i> Modifica</button>
                                <button class="btn btn-success btn-danger btn-sm" type="button"><i class="fal fa-file-pdf"></i> Scarica PDF</button>
                              </td>
                            </tr>
                            <tr>
                              <td>Poggio alla Valle</td>
                              <td>31/04/2021</td>
                              <td>120x80</td>
                              <td>20.000</td>
                              <td>Stampa C + Stampa M + Stampa Y + Stampa K</td>
                              <td>1.440 €</td>
                              <td>0,12 cad</td>
                              <td>
                                <button class="btn btn-success btn-sm me-1" type="button"><i class="fal fa-edit"></i> Modifica</button>
                                <button class="btn btn-success btn-danger btn-sm" type="button"><i class="fal fa-file-pdf"></i> Scarica PDF</button>
                              </td>
                            </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="float-end">
                          <router-link to="/storico-preventivi">Vedi altri</router-link>
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

import {setTitle} from "../../helper/utility";
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