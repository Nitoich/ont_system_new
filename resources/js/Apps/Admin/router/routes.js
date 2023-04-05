import Home from "../pages/Home";
import Users from "../pages/Users/Users";
import UserEdit from "../pages/Users/UserEdit";
import Roles from "../pages/Users/UserEdit/Roles";
import General from "../pages/Users/UserEdit/General";
import Permissions from "../pages/Users/UserEdit/Permissions";
import AddUser from "../pages/Users/AddUser";
import Loads from "../pages/Load/Loads";
import AllRoles from "../pages/Roles/Roles.vue"
import Role from "../pages/Roles/Role.vue";
import RoleEdit from "../pages/Roles/RoleEdit.vue";
import RolePermissions from "../pages/Roles/RolePermissions.vue";
import AllItemsEntity from "../pages/EntitiesTemplate/AllItemsEntity.vue";

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
    { path: '/admin/loads', component: Loads, name: 'loads', meta: { page_group: 'loads' } },
    { path: '/admin/groups', component: {}, name: 'groups', meta: { page_group: 'groups' } },
    { path: '/admin/disciplines', component: {}, name: 'disciplines', meta: { page_group: 'disciplines' } },
    { path: '/admin/roles', component: AllRoles, name: 'roles', meta: { page_group: 'roles' } },
    {
        path: '/admin/role/:id',
        component: RoleEdit,
        name: 'role',
        meta: {
            page_group: 'roles'
        },
        children: [
            { path: '', component: Role, name: 'role-general', meta: { page_group: 'roles' } },
            { path: 'permissions', component: RolePermissions, name: 'role-permissions', meta: { page_group: 'roles' } }
        ]
    },
    { path: '/admin/speciality', component: AllItemsEntity, props: { entity: 'speciality' }, meta: { page_group: 'speciality' }}
];
