<template>
    <div class="container-fluid">
        <v-row>
            <v-col cols="12" lg="7">
                <v-card v-if="userRepair">
                    <v-card-title v-if="userRepair.car" style="background: rgba(0, 0, 0, 0.7); color: white; ">
                        Szczegóły naprawy {{userRepair.car.model.brand.name}} {{userRepair.car.model.name}}
                        <v-spacer></v-spacer>
                        <v-btn outlined color="white">Status: " {{userRepair.status}}"</v-btn>
                    </v-card-title>
                    <v-card-title v-if="!userRepair.car" style="background: rgba(0, 0, 0, 0.7); color: white; ">
                        Samochód usunięto
                        <v-spacer></v-spacer>
                        <v-btn outlined color="white">Status: " {{userRepair.status}}"</v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-list two-line subheader>
                            <v-list-item>
                                <v-row><v-col cols="12" lg="6">
                                <v-list-item-content>
                                    <v-list-item-title>Warsztat</v-list-item-title>
                                    <v-list-item-subtitle>{{userRepair.company.name}}</v-list-item-subtitle>
                                </v-list-item-content>
                                </v-col>
                                <v-col cols="12" lg="6">
                                    <v-list-item-content>
                                        <v-list-item-title>Temat naprawy</v-list-item-title>
                                        <v-list-item-subtitle>{{userRepair.category}}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-col></v-row>
                            </v-list-item>
                            <v-list-item>
                                <v-row><v-col cols="12" lg="6">
                                <v-list-item-content>
                                    <v-list-item-title>Samochód</v-list-item-title>
                                    <v-list-item-subtitle v-if="userRepair.car">{{userRepair.car.model.brand.name}} {{userRepair.car.model.name}}</v-list-item-subtitle>
                                    <v-list-item-subtitle v-if="!userRepair.car">Samochód usunięto</v-list-item-subtitle>
                                </v-list-item-content>
                                </v-col>
                                <v-col cols="12" lg="6">
                                    <v-list-item-content>
                                        <v-list-item-title>Preferowany kontakt</v-list-item-title>
                                        <v-list-item-subtitle>{{userRepair.contact}}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-col></v-row>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title><v-textarea
                                        label="Problem użytkownika"
                                        v-model="userRepair.description"
                                        filled
                                        auto-grow
                                        background-color="#CFD8DC"
                                        rows="1"
                                        disabled
                                    ></v-textarea></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title><v-textarea
                                        label="Odpowiedź warsztatu"
                                        v-model="userRepair.companyReply"
                                        filled
                                        auto-grow
                                        background-color="#CFD8DC"
                                        rows="1"
                                    ></v-textarea></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title v-if="priceAdded" style="text-align: center">
                                        <v-btn outlined @click="addPrice">Cena: {{userRepair.price}} zł</v-btn>
                                    </v-list-item-title>
                                    <v-list-item-title style="text-align: center" v-else>
                                        <v-btn @click="addPrice" outlined >Cena: Brak podanej ceny przez warsztat</v-btn>
                                    </v-list-item-title>
                                    <v-dialog v-model="priceModal" width="500px" persistent>
                                        <v-card><v-card-text>
                                            <v-row>
                                                <v-col cols="12">
                                                    <v-text-field v-model="userRepair.price" label="Cena" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12">
                                                    <v-btn @click="cancelPrice">Anuluj</v-btn>
                                                    <v-btn @click="savePrice">Zapisz</v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-card-text></v-card>
                                    </v-dialog>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                        <v-btn @click="showAcceptationModal" v-if="userRepair.status ==='Oczekujące'">Przyjmij zgłoszenie</v-btn>
                        <v-btn @click="showRejectionModal" v-if="userRepair.status !=='Zakończone'">Odrzuć zgłoszenie</v-btn>
                        <v-dialog v-model="showAcceptRepairModal" persistent max-width="500px">
                            <v-card>
                                <v-card-title class="justify-center text-danger">
                                    Czy na pewno chcesz przyjąć to zgłoszenie?
                                </v-card-title>
                                <v-card-actions class="justify-center">
                                    <v-btn text color="primary" @click="closeAcceptationModal">Nie</v-btn>
                                    <v-btn text color="primary" @click="acceptRepair">Tak</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="showRejectRepairModal" persistent max-width="500px">
                            <v-card>
                                <v-card-title class="justify-center text-danger">
                                    Czy na pewno chcesz odrzucić to zgłoszenie?
                                </v-card-title>
                                <v-card-actions class="justify-center">
                                    <v-btn text color="primary" @click="closeRejectionModal">Nie</v-btn>
                                    <v-btn text color="primary" @click="rejectRepair">Tak</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" lg="5">
                <v-card>
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; ">Czat</v-card-title>
                    <v-card-text v-if="userRepair">
                        <chat :me="userRepair.company.user" :otherPerson="userRepair.user" ></chat>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';
    import chat from '../Modals/ChatComponent';
    export default {
        name:'OwnerRepairDetails',
        components:{
            chat
        },
        data(){
            return{
                userRepair:'',
                priceModal:false,
                priceAdded:false,
                showAcceptRepairModal:false,
                showRejectRepairModal:false,
            }
        },
        methods:{
            closeRejectionModal(){
                this.showRejectRepairModal = false;
            },
            showRejectionModal(){
                this.showRejectRepairModal = true;
            },
            closeAcceptationModal(){
                this.showAcceptRepairModal = false;
            },
            showAcceptationModal(){
                this.showAcceptRepairModal = true;
            },
            async rejectRepair(){
                const res = await this.callApi('post','/rejectRepair',this.userRepair);
                if(res.status === 200){
                    this.$toast.success('Pomyślnie odrzucono naprawę');
                    this.showRejectRepairModal = false;
                    setTimeout(() => {
                        this.$router.go();
                    }, 2000)
                }else{
                    this.$toast.error('Nie udało się odrzucić naprawy, prosze spróbowac później')
                }
            },
            async acceptRepair(){
                const repairId = parseInt(this.$route.params.id);
                const res = await this.callApi('post','/acceptRepair',this.userRepair);
                if(res.status === 200){
                    this.$toast.success('Pomyślnie zatwierdzono naprawę');
                    this.showAcceptRepairModal = false;
                    setTimeout(() => {
                        this.$router.go();
                        }, 2000)
                }else{
                    this.$toast.error('Nie udało się zatwierdzić naprawy, proszę spróbowac później')
                }
            },
            cancelPrice(){
                this.userRepair.price = "";
                this.priceModal=false;
            },
            savePrice(){
                console.log(this.userRepair)
                this.priceAdded = true;
                this.priceModal = false;
            },
            addPrice(){
                this.priceModal = true;
            }

        },
        async created() {
            const repairId = parseInt(this.$route.params.id);
            const [ownerRepair] = await Promise.all([
                this.callApi('get',`/getRepairDetails/${repairId}`),
            ]);
            if(ownerRepair.status === 200){
                this.userRepair = ownerRepair.data;
                if(this.userRepair.price > 0){
                    this.priceAdded = true;
                }
                console.log(this.userRepair)
            }else{
                this.$toast.error('Błąd');
            }
            console.log(this.userRepair)
        },
        computed:{

        },
        watch:{

        },
    }
</script>
