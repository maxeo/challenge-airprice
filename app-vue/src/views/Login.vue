<template>
  <div class="main-bg" v-if="!is_logged">
    <div class="container h-100">
      <div class="d-flex justify-content-center h-100">
        <div class="user_card">
          <div class="d-flex justify-content-center">
            <div class="brand_logo_container">
              <router-link class="sidebar-brand" :to="$router.getByName('home-page')">
                <img src="@/assets/plane.svg" class="brand_logo" alt="Logo">
              </router-link>
            </div>
          </div>
          <div class="d-flex justify-content-center form_container">
            <form action="#" @submit="onSubmit">
              <h1 class="text-center mt-3 mb-3">Esegui il login</h1>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" name="username" v-model="username" class="form-control input_user" placeholder="Nome utente o mail" required>
              </div>
              <div class="input-group mb-2">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="password" v-model="password" class="form-control input_pass" placeholder="Password" required>
              </div>
              <div class="form-group">
                <div class="custom-control custom-checkbox text-center">
                  <input type="checkbox" v-model="remember_me" class="custom-control-input" id="customControlInline">
                  <label class="custom-control-label" for="customControlInline">Remember me</label>
                </div>
              </div>
              <div class="d-flex justify-content-center mt-3 login_container">
                <button type="submit" name="button" class="btn login_btn">Login</button>
              </div>
            </form>
          </div>

          <div class="mt-4 d-none">
            <div class="d-flex justify-content-center links">
              <!-- TODO: recover password -->
              <a href="#">Password dimenticata</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div v-for="modal in alert_requests">
    <ModalAlert @remove-unused-modal-alert="removeUnusedModalAlert" :title="modal.title" :body="modal.body" v-if="modal.show_modal" @close="modal.show_modal = false"/>
  </div>


</template>

<script>

import {apiFetch, setTitle} from "../helper/utility";
import ModalAlert from "../components/ModalAlert";

export default {
  name: "Login",
  components: {
    ModalAlert
  },
  data() {
    return {
      alert_requests: [],
      pending_form: false,
      username: "",
      password: "",
      remember_me: false,
    }
  },
  props: {
    access_token: String,
    sidebar_collapsed: Boolean,
    user: Object,
    info: Object,
    is_logged: Boolean,
  },
  methods: {
    onSubmit(e) {
      e.preventDefault();
      e.target.blur();

      if (this.pending_form === false) {
        this.pending_form = true;

        apiFetch(this.$apibase + '/login', {
              method: 'POST',
              headers: {
                'Content-type': 'application/json',
                'Accept': 'application/json',
              },
              body: JSON.stringify({
                "user": this.username,
                "password": this.password,
                "info": ['navigation', 'user_permissions'],

              }),
            }, json => {
              if (json.success === true) {
                this.$emit('do_login', json.user, json.token, this.remember_me ? 'local' : 'session', json.info);
                this.$router.push(this.$router.getByName('admin-dashboard'));
              } else {
                this.alert_requests.push({
                  title: "Login non valido",
                  body: `Nome utente o Password non validi`,
                  show_modal: true
                });
              }
              this.pending_form = false;
            }, () => {
              this.alert_requests.push({
                title: "Codice Risposta non Previsto",
                body: `Errore nella richiesta`,
                show_modal: true
              },);
              this.pending_form = false;
            },
            () => {
              this.alert_requests.push({
                title: "Errore",
                body: `Errore nella richiesta`,
                show_modal: true
              },);
              this.pending_form = false;
            });
      }

    },
    removeUnusedModalAlert() {
      this.alert_requests = this.alert_requests.filter((modal) => modal.show_modal === true);
    }
  },
  setup() {
    setTitle('Login');
  },
  beforeMount() {
    this.$emit('check-authenticate', true);
  },
  emits: ['do_login', 'do_logout', 'check-authenticate', 'toggle_sidebar_collapse']
}
</script>

<style scoped>
.container {
  padding: 30px;
  min-height: 300px;
}

.brand_logo_container {
  width: 150px;
  height: 150px;
  border: 5px solid #034EA2;
  border-radius: 100%;
  padding: 20px;
  text-align: center;
  background-color: #FFF;
}

.brand_logo_container .brand_logo {
  max-width: 100%;
  max-height: 100%;
}

.user_card {
  height: 500px;
  width: 350px;
  margin-top: auto;
  margin-bottom: auto;
  background: #FFF;
  position: relative;
  display: flex;
  justify-content: center;
  flex-direction: column;
  padding: 10px;
  border-radius: 20px;
  box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.3), 0 8px 25px 0 rgba(0, 0, 0, 0.2);
  -webkit-box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.3), 0 8px 25px 0 rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.3), 0 8px 25px 0 rgba(0, 0, 0, 0.2);
}

.input-group-text {
  height: 100%;
  border-right: 0;
  background: #FFF;
}

.main-bg {
  height: 100%;
  min-height: 100vh;
  margin: 0;
  background: linear-gradient(45deg, #17ead9, #6078ea) fixed;
}

.fas {
  color: #034ea2;
}

.login_btn {
  width: 100%;
  background: #034ea2;
  color: #FFF;
}

.login_btn:hover {
  background: #0360C8;
}

.login_btn:active {
  background: #037AFF;
}

.custom-control-input {
  margin-right: 10px;
}

.custom-control-label,
.custom-control-input {
  cursor: pointer;
  user-select: none;
}

.custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
  background-color: #034ea2 !important;
}

.links a {
  color: #4a5568;
  text-decoration: none;
  margin-bottom: .5rem;
}

.links a:hover,
.links a:active {
  text-decoration: underline;
}

.links a:active {
  color: #037AFF;
}
</style>