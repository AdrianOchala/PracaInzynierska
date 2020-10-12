import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import UserHome from "./components/User/UserHomeComponent";
import UserCar from "./components/User/UserCarComponent";
import UserRepair from "./components/User/UserRepairComponent";
import UserRepairDetails from "./components/User/UserRepairDetailsComponent";
import AdminRoleManagement from "./components/Admin/AdminRoleManagementComponent";
import SearchMechanic from "./components/User/SearchMechanic";
import MechanicDetails from "./components/User/MechanicDetails";
import RepairDetails from "./components/User/RepairDetails";
import PageNotFound from "./pages/PageNotFound";

export default new VueRouter({
    routes:[
        //User & Owner Path's
        {path:'/',component:UserHome,name:'/'}, //Strona główna użytkowników
        {path:'/SearchMechanic',component:SearchMechanic,name:SearchMechanic},//Wyszukiwanie warsztatów ( User , Owner)
        {path:'/MechanicDetails/:id',component:MechanicDetails,name:MechanicDetails},//Wyszukiwanie warsztatów ( User , Owner)

        // {path:'/RepairDetails/:id',component:RepairDetails,name:RepairDetails},//Wyszukiwanie warsztatów ( User , Owner)

        {path:'/UserCar',component:UserCar,name:UserCar},//Wgląd w swoje samochody, dodawanie, edytowanie( User , Owner)
        {path:'/UserRepair',component:UserRepair,name:UserRepair},//Wgląd w swoje samochody, dodawanie, edytowanie( User , Owner)
        {path:'/UserRepairDetails/:id',component:UserRepairDetails,name:UserRepairDetails},//Wgląd w swoje samochody, dodawanie, edytowanie( User , Owner)
        //Owner Path's

        //Admin path's
        {path:'/AdminRoleManagement',component:AdminRoleManagement,name:AdminRoleManagement},

        {path:'*',component:PageNotFound,name:'pagenotfound'},

    ],
    mode: 'history'
})
