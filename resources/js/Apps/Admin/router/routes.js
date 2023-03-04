import Home from "../pages/Home";
import Users from "../pages/Users/Users";
import UserEdit from "../pages/Users/UserEdit";
import Roles from "../pages/Users/UserEdit/Roles";
import General from "../pages/Users/UserEdit/General";
import Permissions from "../pages/Users/UserEdit/Permissions";
import AddUser from "../pages/Users/AddUser";

export default [
    { path: '/admin/home', component: Home, name: 'home', meta: { page_group: 'home' } },
    { path: '/admin/users', component: Users, name: 'users', meta: { page_group: 'users' } },
    { path: '/admin/user/new', component: AddUser, name: 'user-create', meta: { page_group: 'users' } },
    {
        path: '/admin/user/:id',
        component: UserEdit,
        name: 'user-edit',
        meta: {
            page_group: 'users'
        },
        children: [
            { path: '', component: General, name: 'user-general', meta: { page_group: 'users' } },
            { path: 'roles', component: Roles, name: 'user-roles', meta: { page_group: 'users' } },
            { path: 'permission', component: Permissions, name: 'user-permission', meta: { page_group: 'users' } }
        ]
    },
];
