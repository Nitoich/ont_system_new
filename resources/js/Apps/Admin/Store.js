import Vue from "vue";
import Vuex from 'vuex';
import Session from "./stores/Session";
import User from "./stores/User";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        Session,
        User
    }
});
