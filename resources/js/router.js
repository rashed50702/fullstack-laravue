import { createWebHistory, createRouter } from "vue-router";
import Home from "./components/Home.vue";
import Login from "./pages/Login.vue";
import Tags from "./admin/pages/Tags.vue";
import Categories from "./admin/pages/Category.vue";
import AdminUser from "./admin/pages/AdminUser.vue";
import Role from "./admin/pages/Role.vue";
import Permission from "./admin/pages/Permission.vue";

const routes = [
    
    {
        path: "/",
        name: "/",
        component: Home,
    },
    {
        path: "/login",
        name: "login",
        component: Login,
    },
    {
        path: "/tags",
        name: "tags",
        component: Tags,
    },
    {
        path: "/categories",
        name: "categories",
        component: Categories,
    },
    {
        path: "/admin-users",
        name: "admin-users",
        component: AdminUser,
    },
    {
        path: "/roles",
        name: "roles",
        component: Role,
    },
    {
        path: "/role-permissions",
        name: "role-permissions",
        component: Permission,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;