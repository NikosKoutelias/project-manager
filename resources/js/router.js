import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "Home",
        component: () => import("./Pages/HomeRoute.vue"),
    },
    {
        path: "/admin",
        name: "Admin",
        component: () => import("./Pages/AdminRoute.vue"),
        children: [
            {path: "/admin/dashboard", name:'Dashboard', component: () => import("./Pages/DashboardRoute.vue")},
            {path: "/admin/companies", name:'Companies', component: () => import("./Pages/CompaniesRoute.vue")},
            {path: "/admin/projects", name:'Projects', component: () => import("./Pages/ProjectsRoute.vue")},
            {path: "/admin/users", name:'Users', component: () => import("./Pages/UsersRoute.vue")},
            {path: "/admin/reports", name:'Reports', component: () => import("./Pages/ReportsRoute.vue")},
            {path: "/admin/settings", name:'Settings', component: () => import("./Pages/SettingsRoute.vue")},
            {path: "/admin/profile", name:'Profile', component: () => import("./Pages/ProfileRoute.vue")},
        ],
    },
    {
        path: "/login",
        name: "Login",
        component: () => import("./Pages/LoginRoute.vue"),
    },
    {
        path: "/register",
        name: "Register",
        component: () => import("./Pages/RegisterRoute.vue"),
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: () => import("./Pages/PageNotFound.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
