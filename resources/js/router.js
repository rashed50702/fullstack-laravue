import { createWebHistory, createRouter } from "vue-router";
import Home from "./components/Home.vue";
import Tags from "./admin/pages/Tags.vue";
import Categories from "./admin/pages/Category.vue";
import AdminUser from "./admin/pages/AdminUser.vue";

const routes = [
    
    {
        path: "/",
        name: "Home",
        component: Home,
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
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;