/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);
// import store  from "./store/store";

require("./bootstrap");

// importaciones de ViewUI
import ViewUI from "view-design";
import locale from "view-design/dist/locale/es-ES";
Vue.use(ViewUI, { locale });

// importaciones de vuetify
import Vuetify from "vuetify";
Vue.use(Vuetify);

// importaciones de Vuelidate
import Vuelidate from "vuelidate";
Vue.use(Vuelidate);

// Registrar componentes vistas
Vue.component(
    "productos_component",
    require("./components/ProductosComponent.vue").default
);
Vue.component(
    "prime_component",
    require("./components/PrimeComponent.vue").default
);
Vue.component(
    "bootstrap_component",
    require("./components/BootstrapComponent.vue").default
);
Vue.component(
    "tareas_component",
    require("./components/TareasComponent.vue").default
);
Vue.component(
    "vuetify_component",
    require("./components/VuetifyComponent.vue").default
);

const app = new Vue({
    el: "#app",
    vuetify: new Vuetify()
    // store
});
