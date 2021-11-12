<template>
  <div class="main-bg">
    <div class="d-flex justify-content-center h-100">
      <div class="message-flex">
        <div class="brand_logo_container">
          <img src="@/assets/plane-inline.svg" class="brand_logo" alt="Logo">
        </div>
        <div class="box-container mt-3">

          <h1 class="text-center">Prenota il tuo volo</h1>


          <div class="row">
            <div class="col-12 col-md-5">
              <div class="m-3">
                <label class="form-label ps-2">Aeroporto di partenza</label>
                <select class="form-select" v-model="code_departure">
                  <option value=""></option>
                  <template v-for="airport in airports">
                    <option v-if="airport.code!==code_arrival" :value="airport.code">{{ airport.name }}</option>
                  </template>
                </select>
              </div>
            </div>
            <div class="col-12 col-md-2 d-flex align-items-end">
              <div class="m-3 w-100">
                <button @click="invertDestinations" type="button" class="btn btn-light w-100 d-none d-md-block "><i class="fas fa-arrows-alt-h"></i></button>
                <button @click="invertDestinations" type="button" class="btn btn-light d-block d-md-none pe-5 ps-5"><i class="fas fa-arrows-alt-v"></i></button>
              </div>
            </div>
            <div class="col-12 col-md-5">
              <div class="m-3">
                <label class="form-label ps-2">Aeroporto di arrivo</label>
                <select class="form-select" v-model="code_arrival">
                  <option value=""></option>
                  <template v-for="airport in airports">
                    <option v-if="airport.code!==code_departure" :value="airport.code">{{ airport.name }}</option>
                  </template>
                </select>
              </div>
            </div>
            <div class="col-12">
              <p class="text-danger text-center" v-if="code_departure===code_arrival && code_arrival!==''">
                L'aeroporto di partenza e di arrivo non possono coincidere
              </p>
            </div>
            <div class="col-12 mt-2 mb-3 text-center">
              <button type="button" @click="checkFlights" class="btn btn-primary w-50" :disabled="code_departure==='' || code_arrival==='' || code_departure===code_arrival">Mostra
                le
                soluzioni
              </button>
            </div>
          </div>

          <p class="text-center">Sei un amministratore?
            <router-link :to="$router.getByName('login')">accedi</router-link>
          </p>
        </div>

      </div>
    </div>
  </div>
  <div v-for="modal in alert_requests">
    <ModalAlert @remove-unused-modal-alert="removeUnusedModalAlert" :title="modal.title" :body="modal.body" v-if="modal.show_modal" @close="modal.show_modal = false"/>
  </div>
  <Loader v-if="show_loader"/>
  <ModalShow
      :modal_data="modal_data"
      :trip_list="trip_list"
      :airports="airports"
      :code_departure="code_departure"
      :code_arrival="code_arrival"
  />

</template>


<script>
import {apiFetch, setTitle} from "../helper/utility";
import ModalShow from "../components/Preventivi/ModalShow";
import Loader from "../components/Loader";
import ModalAlert from "../components/ModalAlert";

export default {
  name: "HomePage",
  components: {ModalAlert, Loader, ModalShow},
  data() {
    return {
      alert_requests: [],
      airports: [],
      trip_list: [],
      code_departure: '',
      code_arrival: '',
      modal_data: {
        show_modal: false,
      },
      show_loader: false,
    }
  },
  methods: {
    invertDestinations() {
      let tmp = this.code_departure;
      this.code_departure = this.code_arrival;
      this.code_arrival = tmp;
    },
    checkFlights() {
      this.show_loader = true;
      apiFetch(this.$apibase + '/airport/check-flights', {
            method: 'POST',
            headers: {
              'Content-type': 'application/json',
              'Accept': 'application/json',
            },
            body: JSON.stringify({
              "code_departure": this.code_departure,
              "code_arrival": this.code_arrival,

            }),
          }, json => {
            this.show_loader = false;
            if (json.success) {
              this.modal_data.show_modal = true;
              this.trip_list = json.data;
            } else {
              this.alert_requests.push({
                title: "Nessun volo trovato",
                body: `Non è stato trovato nessun volo per la destinazione selezionata`,
                show_modal: true
              },);
            }
          }, () => {
            this.alert_requests.push({
              title: "Codice Risposta non Previsto",
              body: `Errore nella richiesta`,
              show_modal: true
            },);
            this.show_loader = false;
          },
          () => {
            this.alert_requests.push({
              title: "Errore",
              body: `Errore nella richiesta`,
              show_modal: true
            },);
            this.show_loader = false;
          });
    },
    removeUnusedModalAlert() {
      this.alert_requests = this.alert_requests.filter((modal) => modal.show_modal === true);
    },
  },
  setup() {
    setTitle('Pagina non trovata', false);
  },
  beforeCreate() {
    apiFetch(this.$apibase + '/airport/list', {}, (response) => {
      this.airports = response;
    })
  },
  props: ['user', 'info', 'is_logged', 'sidebar_collapsed', 'access_token'],
  emits: ['checkAuthenticate', 'do_login', 'do_logout', 'toggle_sidebar_collapse'],
}
</script>

<style scoped>
.main-bg {
  height: 100vh;
  margin: 0;
  background-image: url("~@/assets/NYNF.jpg");
  background-size: cover;
}

.message-flex {
  margin-top: auto;
  margin-bottom: auto;
  display: flex;
  justify-content: center;
  flex-direction: column;
}

.box-container {
  background: rgba(255, 255, 255, 0.666);
  padding: 30px;
  border-radius: 20px;
  width: 800px;
  max-width: 90vw;

}

.brand_logo_container {
  width: 400px;
  height: 90px;
  border-radius: 100px;
  padding: 8px;
  text-align: center;
  background: rgba(255, 255, 255, 0.666);
  margin: 0 auto;
  max-width: 90vw;
}

.brand_logo_container .brand_logo {
  height: 100%;
  max-width: 100%;
}

a {
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

.btn-light {
  border: 1px solid #ced4da;
  margin: 0 auto;
}
</style>