<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <form @submit="saveForm" v-on:keydown.enter.prevent='saveForm' action="#" method="post">
            <div class="modal-header">
              <slot name="header">
                <h4 class="text-center w-100">{{ target_key === null ? 'Aggiungi' : (mode !== 'edit' ? 'Visualizza' : 'Modifica') }} {{ title }}</h4>
              </slot>
              <button type="button" class="btn-close" @click="closeModal"></button>
            </div>
            <div class="modal-body text-center p-3">
              <slot name="body">

                <div class="row">
                  <template v-for="form_group in form">
                    <template v-if="form_group.primary!==true">

                      <template v-if="mode==='edit'">
                        <div class="col-12 col-md-6 text-start">
                          <div class="mb-3">
                            <label class="form-label">{{ form_group?.render?.label?.length ? form_group.render.label : form_group.name }}</label>
                            <!-- For input text email and password -->
                            <template v-if="['text','email','number','password'].indexOf(form_group?.render?.type)>-1">
                              <input :type="form_group.render.type" v-model="form_group.value" class="form-control" :class="form_group?.validation?.length?'is-invalid':''">
                            </template>
                            <!-- Relations -->
                            <template v-else-if="form_group.render.type==='select'">
                              <Multiselect
                                  v-model="form_group.value"
                                  :options="form_group.options"
                                  :closeOnSelect="form_group.render.multiple!==true"
                                  :searchable="true"
                                  :createTag="form_group.render.multiple!==true"
                                  :mode="form_group.render.multiple===true?'tags':'single'"
                                  :class="form_group?.validation?.length?'is-invalid':''"
                              />
                            </template>
                            <div class="invalid-feedback">
                              <template v-if="form_group?.validation?.length">
                                <ul>
                                  <template v-for="error in form_group.validation">
                                    <li>{{ error }}</li>
                                  </template>
                                </ul>
                              </template>
                            </div>
                          </div>
                        </div>
                      </template>
                      <template v-else>
                        <template v-if="!form_group.hidden">
                          <div class="col-6 text-start">
                            <div class="mb-3">
                              <label class="form-label">{{ form_group?.render?.label?.length ? form_group.render.label : form_group.name }}</label>
                              <template v-if="['text','number','email','password'].indexOf(form_group?.render?.type)>-1">
                                <div v-if="!form_group.hidden">
                                  {{ form_group.render.type === 'number' ? parseInt(form_group.value) : form_group.value }}
                                </div>
                              </template>
                              <template v-else-if="form_group.render.type==='select'">
                                <div v-if="!form_group.hidden">
                                  <template v-if="form_group.render.multiple===true">
                                    <ul>
                                      <li v-for="li in getSelectString(form_group)">{{ li }}</li>
                                    </ul>
                                  </template>
                                  <template v-else>
                                    {{ getSelectString(form_group)[0] }}
                                  </template>
                                </div>
                              </template>
                            </div>
                          </div>
                        </template>
                      </template>
                    </template>
                  </template>
                  <div class="col-12" v-if="mode!=='edit'">
                    <button type="button" @click="mode='edit'" class="btn btn-warning float-start">Modifica</button>
                  </div>
                </div>
              </slot>
            </div>
            <div class="modal-footer">
              <slot name="footer">
                <button class="btn btn-secondary float-end" @click="closeModal">{{ close_btn }}</button>
                <button v-if="mode==='edit'" class="btn btn-primary float-end" type="submit">{{ target_key > 0 ? 'Salva' : 'Aggiungi' }}</button>
              </slot>
            </div>
          </form>
        </div>
      </div>
    </div>
  </transition>
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
  <div class="row" v-if="loader">
    <div class="col-12">
      <Loader/>
    </div>
  </div>
</template>

<script>
import Multiselect from '@vueform/multiselect'
import ModalAlert from "../ModalAlert";
import Loader from "../Loader";
import {apiFetch} from "@/helper/utility";

export default {
  components: {Loader, ModalAlert, Multiselect},
  name: "ModalUpdateResource",
  props: {
    title: {type: String,},
    close_btn: {type: String, default: 'Chiudi',},
    info: Object,
    user: Object,
    access_token: String,
    resource_prefix: String,
    permission_prefix: String,
    data_form: Array,
    target_key: Number | null,
    target_data: Object,
  },
  data() {
    return {
      loader: false,
      alert_requests: [],
      form: {},
      mode: 'view',
    }
  },
  methods: {
    removeUnusedModalAlert() {
      this.alert_requests = this.alert_requests.filter((modal) => modal.show_modal === true);
    },
    closeModal() {
      this.$emit('close');
    },
    updateDataForm(data_form, target_data = {}) {
      this.form = {};
      let t_data = target_data;

      for (let i in data_form) {
        let group = data_form[i];
        if (group.primary !== true) {
          let form_group = {};
          form_group = JSON.parse(JSON.stringify(group));
          if (group?.render?.type === 'select') {
            let render = group?.render;
            let select_val_orig = t_data[group.name];
            let sel = this.inGroupSelect(render, select_val_orig);
            form_group.value = sel.value;
            form_group.options = sel.options;


          } else {
            form_group.value = t_data[group.name];
          }

          this.form[group.name] = form_group;
        }
      }
    },
    optionCodeDataForm(form) {
      try {
        let res_form = JSON.parse(JSON.stringify(form));
        for (let i in res_form) {
          let group = res_form[i];
          if (group?.render?.type === 'select') {
            let newVal = [];
            let options = group.options;
            if (group.render.multiple === true) {
              for (let indexOpt in options) {
                if (group.value.indexOf(options[indexOpt].value) > -1) {
                  let el = {};
                  el[group.render.key] = options[indexOpt].value;
                  el[group.render.option] = options[indexOpt].label;
                  newVal.push(el);
                }
              }
            } else {
              let el = {};
              el[group.render.key] = group.value;
              for (let indexOpt in options) {
                if (options[indexOpt].value === group.value) {
                  el[group.render.option] = options[indexOpt].label;
                  break;
                }
              }
              newVal = el;
            }
            res_form[i].value = newVal;
          }
        }
        return res_form;
      } catch (e) {
        console.log(e);
      }

    },
    inGroupSelect(render, val) {
      let tmp_val;
      let tmp_options;
      val = val ?? {};
      if (Array.isArray(val)) {
        tmp_val = [];
        tmp_options = [];
        for (let i in val) {
          let data_sel = val[i];
          tmp_val.push(data_sel[render.key]);
          tmp_options.push({
            value: data_sel[render.key],
            label: data_sel[render.option],
          });
        }
      } else {
        tmp_val = val[render.key];
        tmp_options = {
          value: val[render.key],
          label: val[render.option],
        }
      }
      return {
        value: tmp_val,
        options: tmp_options,
      };
    },
    updateRelationList(relation_list) {
      for (let relation in relation_list) {
        let relation_data = relation_list[relation];
        let sel = this.inGroupSelect(this.form[relation].render, relation_data);
        this.form[relation].options = sel.options;
      }

    },
    saveForm(e) {
      e.preventDefault();
      e.target.blur();

      this.loader = true;
      let dataForm = {};
      for (let el in this.form) {
        dataForm[el] = this.form[el].value;
      }

      let suffix;
      let method_action;
      if (this.target_key > 0) {
        suffix = '/' + this.target_key;
        method_action = 'PUT';
      } else {
        suffix = '';
        method_action = 'POST';
      }

      apiFetch(this.$apibase + '/' + this.resource_prefix + suffix,
          {
            method: method_action,
            headers: {
              'Content-type': 'application/json',
              'Accept': 'application/json',
              "Authorization": "Bearer " + this.access_token,
            },
            body: JSON.stringify(dataForm),
          },
          response => {
            if (response.success === true) {
              this.alert_requests.push({
                title: this.target_key > 0 ? 'Modificato' : 'Aggiunto',
                body: `L'Operazione è stata completata`,
                show_modal: true,
                close_callback: true,
              });

              let formEmit = {};
              let sel_fix = this.optionCodeDataForm(this.form);
              for (let el in sel_fix) {
                formEmit[el] = sel_fix[el].value;
              }

              this.$emit('update_row', formEmit, response.data.id, this.target_key > 0 ? 'update' : 'add')
            } else {
              this.alert_requests.push({
                title: "Errore",
                body: `Correggere i campi e riprovare`,
                show_modal: true
              });

              for (let grp in this.form) {
                this.form[grp].validation = [];
                for (let validation_name in response.validation) {
                  if (grp === validation_name) {
                    this.form[grp].validation = response.validation[validation_name];
                  }
                }
              }

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
    },
    getSelectString(group) {
      let values = group.value;
      let options = group.options;
      let label_val = [];

      if (values === undefined) {
        return [null];
      }

      if (Array.isArray(options) && group.render.multiple === true) {
        options.filter((e) => {
          for (let i in values) {
            if (values[i] === e.value) {
              label_val.push(e.label);
            }
          }
        });
      } else {
        if (Array.isArray(options)) {
          label_val = [options.filter(e => e.value === values)[0].label];
        } else {
          label_val = [options.label]
        }
      }
      return label_val;
    },
    reloadDataView() {
      if (this.info?.user_permissions?.indexOf(this.permission_prefix + '/view') > -1) {
        let target_key = this.target_key ?? 0;

        apiFetch(this.$apibase + '/' + this.resource_prefix + '/' + target_key,
            {
              method: 'GET',
              headers: {
                'Content-type': 'application/json',
                'Accept': 'application/json',
                "Authorization": "Bearer " + this.access_token,
              },
            },
            response => {
              if (response.success === true) {
                this.updateDataForm(response.info.form, response.data);
                this.updateRelationList(response.info.relation_list);

              } else {
                this.alert_requests.push({
                  title: "Errore",
                  body: `Errore di caricamento dati`,
                  show_modal: true,
                  close_callback: true,
                });
              }
            }
        )
      }
    }
  },
  beforeMount() {
    if (this.target_key > 0) {
      this.updateDataForm(this.data_form, this.target_data);
      this.mode = 'view';
    } else {
      this.updateDataForm(this.data_form);
      this.mode = 'edit';
    }
    this.reloadDataView();

  },
  emits: ['close', 'update_row']
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
  overflow-y: auto;
  margin: 0px auto;
  padding: 0;
  background-color: #fff;
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

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type=number] {
  -moz-appearance: textfield;
}


.multiselect.is-invalid {
  border-color: #dc3545;
  padding-right: calc(1.5em + .75rem);
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right calc(.375em + .1875rem) center;
  background-size: calc(.75em + .375rem) calc(.75em + .375rem);
}


</style>