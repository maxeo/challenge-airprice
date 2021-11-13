<template>
  <transition name="modal">
    <div v-if="modal_data.show_modal" class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <form @submit="saveForm" v-on:keydown.enter.prevent='saveForm' action="#" method="post">
            <div class="modal-header">
              <slot name="header">
                <h2 class="text-center w-100">Volo da <b>{{ toTranslateOrEmpty(code_departure) }}</b> verso <b>{{ toTranslateOrEmpty(code_arrival) }}</b></h2>
              </slot>
              <button type="button" class="btn-close" @click="closeModal"></button>
            </div>
            <div class="modal-body text-center p-3 pt-0">
              <slot name="body">
                <h4 class="text-center w-100"> Seleziona il tuo viaggio</h4>
                <div class="card mb-2" v-for="trip in trip_list" @click="activeTrip(trip)" :class="trip.active?'active':''">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-md-3 align-self-center">
                        <div class="price-text">{{ toCurrency(trip.price) }}</div>
                      </div>
                      <div class="col-12 col-md-6 text-center align-self-center">
                        <div v-if="trip.direct === 1">
                          <span class="direct-trip" type="button">Diretto</span>
                        </div>
                        <button type="button" v-else class="stop_over">
                          <template v-if="trip.stop_over === 1">1 Scalo</template>
                          <template v-if="trip.stop_over===2">2 Scali</template>
                        </button>

                      </div>
                      <div class="col-12 col-md-3 align-self-center scales-list">
                        <div>
                          <div v-if="trip.departure_1!==null">Scalo a {{ toTranslateOrEmpty(trip.departure_1) }}</div>
                          <div v-if="trip.departure_2!==null">Scalo a {{ toTranslateOrEmpty(trip.departure_2) }}</div>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>
              </slot>
            </div>
            <div class="modal-footer">
              <slot name="footer">
                <button type="button" class="btn btn-secondary float-end" @click="closeModal">Chiudi</button>
                <button class="btn btn-primary float-end" type="button" @click="bookFlights">Prenota</button>
              </slot>
            </div>
          </form>
        </div>
      </div>
    </div>
  </transition>
  <div class="row" v-if="show_loader">
    <div class="col-12">
      <Loader v-if="true"/>
    </div>
  </div>
  <div v-for="modal in alert_requests">
    <ModalAlert
        @remove-unused-modal-alert="removeUnusedModalAlert"
        :close_callback="modal.close_callback"
        :title="modal.title"
        :body="modal.body"
        v-if="modal.show_modal"
        @close="modal.show_modal = false"
        @close_callback="closeModal"
    />
  </div>

</template>

<script>
import Multiselect from '@vueform/multiselect'
import ModalAlert from "../ModalAlert";
import Loader from "../Loader";
import {apiFetch} from "../../helper/utility";

export default {
  components: {Loader, ModalAlert, Multiselect},
  name: "ModalShow",
  props: {
    modal_data: Object,
    airports: Array,
    trip_list: Array,
    code_departure: String,
    code_arrival: String,
  },
  data() {
    return {
      show_loader: false,
      alert_requests: [],
      active_trip: false,
    }
  },
  methods: {
    toCurrency(num) {
      return (num * 1).toLocaleString('it-IT', {style: 'currency', currency: 'EUR'})
    },
    toTranslateOrEmpty(code) {
      let a = this.airports.filter(a => a.code === code);
      return a.length ? a[0].name : '';
    },
    activeTrip(trip) {
      this.trip_list.filter(e => e.active = false);
      trip.active = true;
      this.active_trip = trip;
    },
    removeUnusedModalAlert() {
      this.alert_requests = this.alert_requests.filter((modal) => modal.show_modal === true);
    },
    closeModal() {
      this.active_trip = false;
      this.modal_data.show_modal = false;
    },
    bookFlights() {
      this.show_loader = true;
      apiFetch(this.$apibase + '/airport/book-flight', {
            method: 'POST',
            headers: {
              'Content-type': 'application/json',
              'Accept': 'application/json',
            },
            body: JSON.stringify({
              "trip": this.active_trip,
            }),
          }, json => {
            this.show_loader = false;
            this.alert_requests.push({
              title: "Prenotazione effettuata con successo",
              body: `Grazie di aver prenotato il tuo volo`,
              show_modal: true,
              close_callback: this.closeModal,
            },);
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
  },
  beforeMount() {
  },
  emits: [
    'close',
  ]
}
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 1200px;
  max-width: 95vw;
  max-height: 100vh;
  margin: 0px auto;
  padding: 0;
  background-color: #f4f4f4;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
  margin-bottom: 0;
  line-height: 1.5;
}

.modal-body {
  margin: 20px 0;
  padding: 8px;
  max-height: 70vh;
  overflow-y: auto;
}

.modal-body .card {
  background: #FFF;
  cursor: pointer;
}

.modal-body .card.active {
  background-color: #acf;
}


.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}


.form-label {
  font-size: 14px;
  font-weight: bold;
  line-height: 5px;
}

.multiselect.is-invalid {
  border-color: #dc3545;
  padding-right: calc(1.5em + .75rem);
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right calc(.375em + .1875rem) center;
  background-size: calc(.75em + .375rem) calc(.75em + .375rem);
}

.price-text {
  color: #073590;
  font-weight: bold;
  font-size: 34px;
}

.stop_over {
  border: 0;
  background-color: #FFF;
  color: #073590;
  border-radius: 12px;
  font-size: 18px;
  font-weight: bold;
  padding: 2px 8px;
}

.direct-trip {
  border: 0;
  background-color: #073590;
  color: #FFF;
  border-radius: 14px;
  font-size: 18px;
  padding: 6px 16px;
}

.scales-list {
  font-weight: bold;
  color: #073590;
}

.btn.btn-primary {
  background-color: #2c84c6;
  border-color: #3e88be;
}

.modal-container .btn.btn-primary {
  background-color: #073590;
  border-color: #073590;
}

.modal-container .btn.btn-primary {
  background-color: #073590;
  border-color: #073590;
}
</style>