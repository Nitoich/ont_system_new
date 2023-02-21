import VueRouter from "vue-router";
import routes from "./routes";

const router = new VueRouter({
    // history: VueRouter.createWebHashHistory(),
    mode: 'history',
    routes
});

export default router;
