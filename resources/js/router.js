import { createWebHistory, createRouter } from "vue-router";
import Home from "./components/Home.vue";
import Login from "./pages/Login.vue";
import Tags from "./admin/pages/Tags.vue";
import Categories from "./admin/pages/Category.vue";
import AdminUser from "./admin/pages/AdminUser.vue";
import Role from "./admin/pages/Role.vue";

const routes = [
    
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
    },
    {
        path: "/tags",
        name: "Tags",
        component: Tags,
    },
    {
        path: "/categories",
        name: "Categories",
        component: Categories,
    },
    {
        path: "/admin-users",
        name: "AdminUser",
        component: AdminUser,
    },
    {
        path: "/role",
        name: "Role",
        component: Role,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;