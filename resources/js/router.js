import { createWebHistory, createRouter } from "vue-router";
import Home from "./components/Home.vue";
import Login from "./pages/Login.vue";
import Tags from "./admin/pages/Tags.vue";
import Categories from "./admin/pages/Category.vue";
import CreateBlog from "./admin/pages/CreateBlog.vue";
import AdminUser from "./admin/pages/AdminUser.vue";
import Role from "./admin/pages/Role.vue";
import Permission from "./admin/pages/Permission.vue";
import NotFound from "./admin/pages/NotFound.vue";

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
        path: "/create-blog",
        name: "create-blog",
        component: CreateBlog,
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
    {
        path: "/:pathMatch(.*)*",
        name: "not-found",
        component: NotFound,
    },
    
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;