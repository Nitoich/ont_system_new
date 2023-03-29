import Vue from "vue";
import Vuex from 'vuex';
import Session from "./stores/Session";
import User from "./stores/User";
import Role from "./stores/Role";
import Load from './stores/Load'
import ASide_menu from "./stores/ASide_menu";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        Session,
        User,
        Role,
        Load,
        ASide_menu
    }
});
