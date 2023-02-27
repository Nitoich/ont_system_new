import Home from "../pages/Home";
import Users from "../pages/Users";
import UserEdit from "../pages/UserEdit";
import Roles from "../pages/UserEdit/Roles";

export default [
    { path: '/admin/home', component: Home, name: 'home' },
    { path: '/admin/users', component: Users, name: 'users' },
    {
        path: '/admin/user/:id',
        component: UserEdit,
        name: 'user-edit',
        children: [
            { path: 'roles', component: Roles, name: 'user-roles' }
        ]
    }
];
