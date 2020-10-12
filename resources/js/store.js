import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
   state:{
        deleteModalData:{
            showDeleteModal: false,
            deleteUrl: "",
            data: null,
            deletingIndex:1,
            isDeleted:false,
        },
        user:false,
        userPermission:null,
        companyLocation:null,
        showLoginComponent:false,
        showRegisterComponent:false,
        userLocation:null,
        showAskForRepair:null,
   },
    getters:{
        getUserPermission(state){
            return state.userPermission;
        },
        getDeleteModalData(state){
           return state.deleteModalData;
        },
        getCompanyLocation(state){
           return state.companyLocation;
        },
        getUserLocation(state){
            return state.userLocation;
        },
        getUser(state){
          return state.user;
        },
        getShowLoginComponent(state){
           return state.showLoginComponent;
        },
        getShowRegisterComponent(state){
           return state.showRegisterComponent;
        },
        getShowAskForRepair(state){
            return state.showAskForRepair;
        }
    },
    mutations:{
       setShowAskForRepair(state,data){
            state.showAskForRepair = data;
       },
       updateUser(state, data){
           state.user = data;
       },
        updateUserPermission(state, data){
          state.userPermission = data;
        },
        setShowLoginComponent(state,data){
          state.showLoginComponent = data;
        },
        setShowRegisterComponent(state,data){
          state.showRegisterComponent = data;
        },
       //Przekazuję który obiekt ma zostać usunięty wraz z parametrami
       setDeletingModalData(state, data){
           state.deleteModalData = data
       },
        //Ustawiam pojawienie się okienka akceptacji
        setShowModal(state,data){
           state.deleteModalData.showDeleteModal = data;
        },
        //Po usunięciu obiektu resetuję dane w celu aktualizacji widoku
        setDeletingModalDataAfterDelete(state, data){
            const deleteModal = {
                    showDeleteModal: false,
                    deleteUrl: "",
                    data: null,
                    deletingIndex:data.index,
                    isDeleted:data.isDeleted,
                };
           state.deleteModalData = deleteModal;
        },
        setCompanyLocation(state,data){
          state.companyLocation = data;
        },
        setUserLocation(state,data){
            state.userLocation = data;
        },

    }
});
//Edycja stora poprzez mutacje !
// computed: {
//     users() {
//         return this.$store.state.users;
//     }
// } i można się odwoływać do danych przez users -> users.name itp

/*   STATE JEST ZAWSZE PRZEKAZYWANE JAKO PIERWSZE
        odwołanie do Getters: this.$store.getters.NazwaGettera
        odwołanie do Mutations: this.@store.commit("nazwaMutacji", obiekt zawierający dane które chcemy przekazać)
        mutacje są synchroniczne, wykonują się od pocz. do końca
        odwołanie do Actions: this.$store.dispatch("NazwaAkcji", { obiekt })
        w akcjach  możemy wykonywać asynchroniczne akcje
        tworzenie akcji:
        remove(context, payload)
        context.commit -> wywołanie mutacji
        context.state -> odwołanie do stora

    Odwołujemy się do tego w COMPUTED ale musimy zaimportować "  import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'
        ...mapState(["nazwaZmiennejZState"]) dzięki czemu używamy this.users zamiast this.$store.state.users
        ...mapGetters(["getUser"])

        Do ...mapMutations i ...mapActions odwołujemy się w methods:{} i wywołujemy: this.Mutacja(payload), this.Akcja(payload)

*/

