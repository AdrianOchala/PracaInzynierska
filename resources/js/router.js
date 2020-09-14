import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import AdminRole from "./components/AdminRoleComponent";
import AdminRoleManagement from "./components/AdminRoleManagementComponent";
import SearchMechanic from "./components/Modals/SearchMechanic";

export default new VueRouter({
    routes:[
        {path:'/AdminRole',component:AdminRole},
        {path:'/AdminRoleManagement',component:AdminRoleManagement},
        {path:'/searchMechanic',component:SearchMechanic},

    ],
    mode: 'history'
})
