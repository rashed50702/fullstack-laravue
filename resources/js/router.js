import { createWebHistory, createRouter } from "vue-router";
import Home from "./components/Home.vue";
import Tags from "./components/Tags.vue";

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
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;