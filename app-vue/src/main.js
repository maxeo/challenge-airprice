import {createApp} from 'vue'
import App from './App.vue'
import router from './router'

import './assets/css/admin-app.css'
import './assets/css/fontawesome.css'
import './assets/css/multiselect.css'


const app = createApp(App);


/** ENV-CODE-START **/
app.config.globalProperties.$apibase = "https://api-webserver.docker.local/api";
/** ENV-CODE-END **/


app.use(router).mount('#app');
