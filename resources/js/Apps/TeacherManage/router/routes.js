import Home from "../pages/Home";
import LoadEdit from "../pages/LoadEdit";

export default [
    { path: '/manage/home', component: Home, name: 'main' },
    { path: '/manage/load/:id', component: LoadEdit }
];
