import {createRouter, createWebHistory} from "vue-router";
import useUserStore from "./store/user.js";
import useCountryStore from "./store/countries.js";
import useCompanyStore from "./store/companies.js";
import useProjectStore from "./store/projects.js";

const routes = [
    {
        path: "/",
        name: "Home",
        component: () => import("./Pages/HomeRoute.vue"),
    },
    {
        path: "/admin",
        name: "Admin",
        component: () => import("./Pages/Admin/AdminRoute.vue"),
        children: [
            {path: "/admin/dashboard", name: 'Dashboard', component: () => import("./Pages/Admin/DashboardRoute.vue")},
            {path: "/admin/companies", name: 'Companies', component: () => import("./Pages/Admin/CompaniesRoute.vue")},
            {path: "/admin/projects", name: 'Projects', component: () => import("./Pages/Admin/ProjectsRoute.vue")},
            {path: "/admin/users", name: 'Users', component: () => import("./Pages/Admin/UsersRoute.vue")},
            {path: "/admin/reports", name: 'Reports', component: () => import("./Pages/Admin/ReportsRoute.vue")},
            {path: "/admin/user/:id", name: 'User', component: () => import("./Pages/Admin/UserEditRoute.vue")},
            {path: "/admin/company/:id", name: 'Company', component: () => import("./Pages/Admin/CompanyEditRoute.vue")},
            {path: "/admin/project/:id", name: 'Project', component: () => import("./Pages/Admin/ProjectEditRoute.vue")},
        ],
        beforeEnter: async (to, from, next) => {
            try {
                const userStore = await useUserStore();
                await userStore.fetchUser();
                await userStore.fetchUsers();

                const countryStore = await useCountryStore();
                await countryStore.fetchCountries();

                const companyStore = await useCompanyStore();
                await companyStore.fetchCompanies();

                const projectStore = await useProjectStore()
                await projectStore.fetchProjects();

                next();
            } catch (err) {
                next(false); // Cancel navigation if data fetching fails
            }
        },
    },
    {
        path: "/login",
        name: "Login",
        component: () => import("./Pages/LoginRoute.vue"),
    },
    {
        path: "/administration",
        name: "Administration",
        component: () => import("./Pages/User/UserLanding.vue"),
        children: [
            {path: "/administration/companies", name: 'User Companies', component: () => import("./Pages/User/CompaniesRoute.vue")},
            {path: "/administration/projects", name: 'User Projects', component: () => import("./Pages/User/ProjectsRoute.vue")},
            {path: "/administration/reports", name: 'User Reports', component: () => import("./Pages/User/ReportsRoute.vue")},
            {path: "/user/profile", name: 'Profile', component: () => import("./Pages/User/ProfileRoute.vue")},
            {path: "/user/settings", name: 'Settings', component: () => import("./Pages/SettingsRoute.vue")},
            {path: "/change-password", name: "ChangePassword", component: () => import("./Pages/User/ChangePasswordRoute.vue")},
        ],
        beforeEnter: async (to, from, next) => {
            try {
                const userStore = await useUserStore();
                await userStore.fetchUser();

                const countryStore = await useCountryStore();
                await countryStore.fetchCountries();

                const companyStore = await useCompanyStore();
                await companyStore.fetchCompaniesForUser(userStore.user.id);

                const projectStore = await useProjectStore()
                await projectStore.fetchProjectsForUser(userStore.user.id);

                next();
            } catch (err) {
                next(false); // Cancel navigation if data fetching fails
            }
        },
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
