require("./bootstrap");
import * as VueGoogleMaps from "vue2-google-maps";
import GmapCluster from "vue2-google-maps/dist/components/cluster";
import store from "./store"
window.Vue = require("vue");

Vue.component("example-component", require("./components/ExampleComponent.vue").default);
Vue.component("notifications-component", require("./components/NotificationsComponent.vue").default);
Vue.component("maps-component", require("./components/MapsComponent.vue").default);
Vue.component("map-view-component", require("./components/MapView.vue").default);


Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyC40Clev1ycrQdtwqme8y6U_WC472aSmJI",
    }
});

Vue.component("GmapCluster", GmapCluster)

const app = new Vue({
    store,
    el: "#wrapper",
});
