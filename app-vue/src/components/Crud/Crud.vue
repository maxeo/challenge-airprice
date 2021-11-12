<template>

  <div class="row" v-if="loader">
    <div class="col-12">
      <Loader/>
    </div>
  </div>
  <div class="row" v-if="table_loaded && info?.user_permissions?.indexOf(permission_prefix+'/view') > -1">
    <div class="col-12">
      <button class="btn btn-success btn-sm mb-3 float-end" @click="openModalResource(null)" type="button">Aggiungi <i class="fas fa-plus"></i></button>
    </div>
  </div>
  <div class="table-responsive" v-if="table_loaded">
    <table class="table table-sm table-bordered text-center table-hover table-striped">
      <thead class="table-dark">
      <tr>
        <template v-for="map in resource_data?.list_map">
          <th>{{ map.name }}</th>
        </template>
        <th class="options-th"></th>
      </tr>
      </thead>
      <tbody>
      <template v-for="row in data_list">
        <tr>
          <template v-for="map in resource_data?.list_map">
            <td :class="map.class??''">
              <template v-if="map.html===undefined && map.body_f===undefined">{{ row[map.source] }}</template>
              <template v-else-if="map.html!==undefined">
                <div v-html="row[map.source]"></div>
              </template>
              <template v-else-if="map.body_f!==undefined">
                <div v-html="map.body_f(row[map.source],row)"></div>
              </template>
            </td>
          </template>

          <td>
            <button
                v-if="info?.user_permissions?.indexOf(permission_prefix+'/view') > -1"
                @click="openModalResource(row.id)"
                class="btn btn-success btn-sm me-1 ms-1"
                type="button">Visualizza <i class="fas fa-user"></i>
            </button>
            <button
                v-if="info?.user_permissions?.indexOf(permission_prefix+'/delete') > -1"
                class="btn btn-danger btn-sm me-1 ms-1"
                type="button"
                @click="deleteRow(row.id)"
            >Cancella <i class="fas fa-trash-alt"></i>
            </button>
          </td>
        </tr>
      </template>

      </tbody>
    </table>
  </div>
  <div v-for="modal in alert_requests">
    <ModalAlert
        @remove-unused-modal-alert="removeUnusedModalAlert"
        :title="modal.title"
        :body="modal.body"
        :confirm_callback="modal.confirm_callback"
        :confirm_btn="modal.confirm_btn"
        :confirm_btn_class="modal.confirm_btn_class"
        :confirm_callback_function="modal.confirm_callback_function"

        v-if="modal.show_modal"
        @close="modal.show_modal = false"
        @confirm_callback="confirmCallback"

    />
  </div>
  <ModalUpdateResource
      v-if="openResource"
      :resource_prefix="resource_prefix"
      :permission_prefix="permission_prefix"

      :data_form="data_form"
      :title="resource_data?.title"
      :target_key="target_key"
      :target_data="target_data"
      :info="info"
      :access_token="access_token"
      @close="openResource=false"
      @update_row="updateRow"
  />
</template>

<script>

import ModalAlert from "../ModalAlert";
import Loader from "../Loader";
import ModalUpdateResource from "./ModalUpdateResource";
import {apiFetch} from "@/helper/utility";

export default {
  name: "Crud",
  components: {ModalUpdateResource, ModalAlert, Loader},
  data() {
    return {
      loader: true,
      table_loaded: false,
      alert_requests: [],
      data_list: [],
      data_form: [],
      openResource: false,
      target_key: null,
      target_data: null,
    }
  },
  props: {
    info: Object,
    access_token: String,
    resource_prefix: String,
    permission_prefix: String,
    resource_data: Object,
  },
  beforeMount() {
    this.updateList();
  },
  methods: {
    updateList() {
      apiFetch(this.$apibase+'/' + this.resource_prefix, {
            method: 'GET',
            headers: {
              'Content-type': 'application/json',
              'Accept': 'application/json',
              "Authorization": "Bearer " + this.access_token,
            },
          }, response => {
            if (response.success === true) {
              this.data_list = response.data;
              this.data_form = response.info.form;
            } else {
              this.alert_requests.push({
                title: "Errore",
                body: `Impossibile caricare l'elenco`,
                show_modal: true
              });
            }
            this.loader = false;
            this.table_loaded = true;
          },
          () => {
            this.loader = false;
            this.alert_requests.push({
              title: "Codice Risposta non Previsto",
              body: `Errore nella richiesta`,
              show_modal: true
            },);
            this.table_loaded = true;
          },
          () => {
            this.loader = false;
            this.alert_requests.push({
              title: "Errore",
              body: `Errore nella richiesta`,
              show_modal: true
            },);
            this.table_loaded = true;
          })

    },
    removeUnusedModalAlert() {
      this.alert_requests = this.alert_requests.filter((modal) => modal.show_modal === true);
    },
    openModalResource(id) {
      this.openResource = true;
      this.target_key = id;
      this.target_data = id !== null ? this.data_list.filter((row) => row.id === id)[0] : [];
    },
    updateRow(row, id, type) {
      if (type === 'update') {
        for (let i in this.data_list) {
          if (this.data_list[i]?.id === id) {
            this.data_list[i] = row;
            this.data_list[i].id = id;
          }
        }
      } else {
        row.id = id;
        this.data_list.push(row)
      }
    },
    confirmCallback() {

    },
    deleteRow(id, confirm = false) {
      if (confirm === false) {
        this.alert_requests.push({
          title: "Confermare?",
          body: `Confermare l'eliminazione?`,
          show_modal: true,
          confirm_callback: true,
          confirm_btn: 'Cancella <i class="fas fa-trash-alt"></i>',
          confirm_btn_class: 'btn btn-danger',
          confirm_callback_function: () => {
            this.deleteRow(id, true);
          },
        });
      } else {
        this.delRow(id);
      }

    },
    delRow(id) {
      if (this.info?.user_permissions?.indexOf(this.permission_prefix + '/delete') > -1) {
        this.loader = true;
        apiFetch(this.$apibase+'/' + this.resource_prefix + '/' + id,
            {
              method: 'DELETE',
              headers: {
                'Content-type': 'application/json',
                'Accept': 'application/json',
                "Authorization": "Bearer " + this.access_token,
              },
            },
            response => {
              if (response.success === true) {
                this.data_list = this.data_list.filter((e) => e.id !== id);


              } else {
                this.alert_requests.push({
                  title: "Errore",
                  body: `Eliminazione non effettuata. <br>
                    <i style="font-size: 14px;">(Permessi mancanti o record non presente?)</i>`,
                  show_modal: true,
                });
              }
              this.loader = false;
            },
            () => {
              this.alert_requests.push({
                title: "Codice Risposta non Previsto",
                body: `Errore nella richiesta`,
                show_modal: true
              },);
              this.loader = false;
            },
            () => {
              this.alert_requests.push({
                title: "Errore",
                body: `Errore nella richiesta`,
                show_modal: true
              },);
              this.loader = false;
            });
      }
    }
  },
  emits: ['update_row'],

}
</script>

<style scoped>
.table > :not(:last-child) > :last-child > *,
.table tbody, .table td, .table tfoot, .table th, .table thead, .table tr {
  border-color: #373b3e;
}

.options-th {
  min-width: 220px;
}
</style>