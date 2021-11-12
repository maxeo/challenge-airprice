<template>
  <div></div>
  <router-view
      @check-authenticate="checkAutenticate"
      @do_login="doLogin"
      @do_logout="doLogout"
      @toggle_sidebar_collapse="toggleSidebar"
      :user="user"
      :info="info"
      :is_logged="is_logged"
      :sidebar_collapsed="sidebar_collapsed"
      :access_token="access_token"
  />
</template>

<script>
import {apiFetch, getStorageData, setStorageData} from "./helper/utility";

export default {
  name: 'App',
  components: {},
  data() {

    return {
      storage_mode: 'local',
      is_logged: null,
      access_token: null,
      info: {},
      user: {
        first_name: null,
        last_name: null,
        username: null,
        email: null,
      },
      sidebar_collapsed: false,
      fresh_check: new Date('2020-01-01'),
    }
  },
  methods: {
    checkAutenticate(reverse = false) {
      if (this.is_logged === false && reverse === false) {
        this.$router.push(this.$router.getByName('login'));
      }

      if (this.is_logged === true && reverse === true) {
        this.$router.push(this.$router.getByName('admin-dashboard'));
      }

      //Check if min 3 minutes was spend
      if (new Date() * 1 - this.fresh_check * 1 > 3 * 60 * 1000) {
        this.freshLogin();
        this.fresh_check = new Date();
      }
    },
    doLogin(user, token, storage_mode = 'session', info = {}) {
      this.is_logged = true;
      this.user = user;
      this.access_token = token;
      this.info = info;

      setStorageData('is_logged', 1, storage_mode);
      setStorageData('access_token', token, storage_mode);
      setStorageData('user', JSON.stringify(user), storage_mode);
      setStorageData('info', JSON.stringify(info), storage_mode);
      setStorageData('storage_mode', storage_mode, 'local');
    },
    doLogout(redirect = true) {
      window.sessionStorage.clear();

      this.storage_mode = 'local';
      setStorageData('storage_mode', 'local', 'local');

      this.storage_mode = null;
      setStorageData('access_token', null, 'local');

      this.is_logged = false;
      setStorageData('is_logged', '0', 'local');

      this.user = {};
      setStorageData('user', '{}', 'local');

      this.info = {};
      setStorageData('info', '{}', 'local');

      this.access_token = "";
      setStorageData('access_token', '', 'local');

      if (redirect) {
        this.$router.push(this.$router.getByName('login'));
      }
    },

    toggleSidebar() {
      this.sidebar_collapsed = !this.sidebar_collapsed
    },
    freshLogin() {
      if (this.is_logged === true) {
        apiFetch(this.$apibase + '/fresh', {
              method: 'POST',
              headers: {
                'Content-type': 'application/json',
                'Accept': 'application/json',
                "Authorization": "Bearer " + this.access_token,
              },
              body: JSON.stringify({
                "info": ['navigation', 'user_permissions'],
              }),
            },
            data => {
              if (data.success === true) {
                this.info = data.info;
                this.user = data.user;

                setStorageData('user', JSON.stringify(data.user), this.storage_mode);
                setStorageData('info', JSON.stringify(data.info), this.storage_mode);

              } else {
                this.doLogout();
              }
            }, (r) => {

              if (r.status === 401) {
                this.doLogout();
              } else {

              }
            }, (e) => console.log(e))
      }
    }
  },
  created() {
    const storage_mode = getStorageData('storage_mode', null, 'String');
    this.storage_mode = storage_mode === "" ? 'local' : storage_mode;
    this.is_logged = getStorageData('is_logged', this.storage_mode, 'Boolean');
    this.access_token = getStorageData('access_token', this.storage_mode, 'String');

    const user = getStorageData('user', this.storage_mode, 'JSON');
    this.user = (typeof user === "object" && user != null) ? user : {};

    const info = getStorageData('info', this.storage_mode, 'JSON');
    this.info = (typeof info === "object" && info != null) ? info : {};
  },

}
</script>

