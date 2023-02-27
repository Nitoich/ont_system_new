import Home from "../pages/Home";
import Users from "../pages/Users";
import UserEdit from "../pages/UserEdit";
import Roles from "../pages/UserEdit/Roles";
import General from "../pages/UserEdit/General";

export default [
    { path: '/admin/home', component: Home, name: 'home', meta: { page_group: 'home' }},
    { path: '/admin/users', component: Users, name: 'users', meta: { page_group: 'users' } },
    {
        path: '/admin/user/:id',
        component: UserEdit,
        name: 'user-edit',
        meta: {
            page_group: 'users'
        },
        children: [
            { path: '', component: General, name: 'user-general', meta: { page_group: 'users' } },
            { path: 'roles', component: Roles, name: 'user-roles', meta: { page_group: 'users' }}
        ]
    }
];
