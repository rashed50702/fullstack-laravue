import { createWebHistory, createRouter } from "vue-router";
import Home from "./components/Home.vue";
import Tags from "./admin/pages/Tags.vue";
import Categories from "./admin/pages/Category.vue";

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
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;