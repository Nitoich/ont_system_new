import Index from "../pages";
import Login from "../pages/Login";

export default [
    { path: '/manage/home', component: Index },
    { path: '/manage/login', component: Login, name: 'login'}
];
