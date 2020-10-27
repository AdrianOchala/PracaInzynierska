import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import UserHome from "./components/User/UserHomeComponent";
import UserCar from "./components/User/UserCarComponent";
import UserRepair from "./components/User/UserRepairComponent";
import UserRepairDetails from "./components/User/UserRepairDetailsComponent";
import OwnerRepairDetails from "./components/Owner/OwnerRepairDetailsComponent";
import AdminRoleManagement from "./components/Admin/AdminRoleManagementComponent";
import SearchMechanic from "./components/User/SearchMechanic";
import MechanicDetails from "./components/User/MechanicDetails";
import OwnerCompany from "./components/Owner/OwnerCompanyComponent";
import PageNotFound from "./pages/PageNotFound";
import UserMessages from "./components/User/UserMessagesComponent";

export default new VueRouter({
    routes:[
        //User & Owner Path's
        {path:'/',component:UserHome,name:'/'}, //Strona główna użytkowników
        {path:'/SearchMechanic',component:SearchMechanic,name:SearchMechanic},//Wyszukiwanie warsztatów ( User , Owner)
        {path:'/MechanicDetails/:id',component:MechanicDetails,name:MechanicDetails},//Wyszukiwanie warsztatów ( User , Owner)

        // {path:'/RepairDetails/:id',component:RepairDetails,name:RepairDetails},//Wyszukiwanie warsztatów ( User , Owner)

        {path:'/UserCar',component:UserCar,name:UserCar},//Wgląd w swoje samochody, dodawanie, edytowanie( User , Owner)
        {path:'/UserRepair',component:UserRepair,name:UserRepair},
        {path:'/UserRepairDetails/:id',component:UserRepairDetails,name:UserRepairDetails},
        {path:'/UserMessages',component:UserMessages,name:UserMessages},
        //Owner Path's
        {path:'/OwnerCompany',component:OwnerCompany,name:OwnerCompany},//Wgląd w swój warsztat
        {path:'/OwnerRepairDetails/:id',component:OwnerRepairDetails,name:OwnerRepairDetails},//Wgląd w swoje samochody, dodawanie, edytowanie
        //Admin path's
        {path:'/AdminRoleManagement',component:AdminRoleManagement,name:AdminRoleManagement},

        {path:'*',component:PageNotFound,name:'pagenotfound'},

    ],
    mode: 'history'
})
