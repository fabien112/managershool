require("./bootstrap");
window.Vue = require("vue").default;
import router from "./routers/router";
import ViewUI from "view-design";
import "view-design/dist/styles/iview.css";
import store from "./store";
import common from "./common";
import moment from "moment";

import Vue from "vue";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

// Import Bootstrap and BootstrapVue CSS files (order is important)

// import "bootstrap/dist/css/bootstrap.css";
// import "bootstrap-vue/dist/bootstrap-vue.css";

//import  jsPDF  from "jspdf";
Vue.mixin(common);
Vue.use(ViewUI);

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);
import Vuelidate from "vuelidate";
Vue.use(Vuelidate);

import VueTimers from "vue-timers";

Vue.use(VueTimers);

Vue.filter("dateFormat", function(arg) {
    return moment(arg).format("DD/MM/YYYY");
});
Vue.filter("dateFormatHeure", function(arg) {
    return moment(arg).format("DD/MM/YYYY , hh:mm:ss "); // Do MMM YYYY , h:mm:ss
});

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);

const app = new Vue({
    el: "#app",
    router,
    store: store
});
