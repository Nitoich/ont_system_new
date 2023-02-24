import Login from "../pages/Login";
import Home from "../pages/Home";
import LoadEdit from "../pages/LoadEdit";

export default [
    { path: '/manage/home', component: Home, name: 'main' },
    { path: '/manage/login', component: Login, name: 'login'},
    { path: '/manage/load/:id', component: LoadEdit }
];
