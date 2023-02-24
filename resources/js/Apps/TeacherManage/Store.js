import Vue from "vue";
import Vuex from 'vuex';
import Session from "./stores/Session";
import User from "./stores/User";
import Load from './stores/Load'
import Group from "./stores/Group";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        Session,
        User,
        Load,
        Group
    }
});
