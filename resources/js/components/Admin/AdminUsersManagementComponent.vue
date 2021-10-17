<template>
        <div class="container-fluid">
            <v-row>
                <v-col cols="12" md="12">
                    <v-card>
                        <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; ">Użytkownicy w systemie</v-card-title>
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                        <tr>
                            <th class="text-left">Imię</th>
                            <th class="text-left">Nazwisko</th>
                            <th class="text-left">E-mail</th>
                            <th class="text-left">Rola</th>
                            <th class="text-left">Status</th>
                            <th class="text-left">Opcje</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(user,i) in users" :key="i">
                            <td>{{ user.name }}</td>
                            <td>{{ user.surname }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.role.name }}</td>
                            <td v-if="user.active">Aktywny</td>
                            <td v-if="!user.active">Nieaktywny</td>
                            <td>
                                <v-btn color="dark" @click="showMessageModal(user.id)">Wyslij wiadomość</v-btn>
                                <v-btn v-if="user.active" color="red" @click="showActiveModal(user.id,i)">Dezaktywuj</v-btn>
                                <v-btn v-if="!user.active" color="red" @click="showDeletingModal(user,i)">Usuń</v-btn>
                                <v-btn v-if="!user.active" color="green" @click="showActivatingModal(user,i)">Aktywuj</v-btn>
                            </td>
                        </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                    </v-card>
                    <v-dialog v-model="activateUserModal" persistent max-width="500px">
                        <v-card>
                            <v-card-title class="justify-center text-info">
                                <p>Czy chcesz aktywować konto?</p>
                            </v-card-title>
                            <v-card-actions class="justify-center">
                                <v-btn color="primary" @click="activateUserModal = false">Nie</v-btn>
                                <v-btn color="primary" @click="activateAccount">Tak</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="showSendMessageModal" persistent max-width="700px">
                        <v-card>
                            <v-card-title class="justify-center ">
                                <h4>Wyślij wiadomość</h4>
                            </v-card-title>
                            <v-card-text>
                                <v-text-field v-model="message.title" label="Tytuł"></v-text-field>
                                <v-textarea
                                    clearable
                                    counter
                                    clear-icon="mdi-close-circle"
                                    label="Treść wiadomości"
                                    v-model="message.message"
                                    hint="Max 250 znaków"
                                    filled
                                    auto-grow
                                    background-color="#CFD8DC"
                                    rows="1"
                                ></v-textarea>
                            </v-card-text>
                            <v-card-actions class="justify-center">
                                <v-btn text color="primary" >Anuluj</v-btn>
                                <v-btn text color="primary" @click="sendUserMessage" >Wyślij</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <deleteModal v-if="getDeleteModalData.showDeleteModal">
                        <h4 slot="header">Czy napewno chcesz usunąć użytkownika?
                        <p>Pamiętaj, że wszystkie jego komentarze, wiadomości oraz firma również zostaną usunięte!</p></h4>
                    </deleteModal>
                    <v-dialog v-model="showDeactivateModal" persistent max-width="500px">
                        <v-card>
                            <v-card-title class="justify-center text-danger">
                                Czy na pewno chcesz dezaktywować to konto?
                            </v-card-title>
                            <v-card-actions class="justify-center">
                                <v-btn text color="primary" @click="showDeactivateModal = false">Nie</v-btn>
                                <v-btn text color="primary" @click="deactivateUser">Tak</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-col>
            </v-row>
        </div>
</template>

<script>
    import deleteModal from '../Modals/DeleteModalComponent';
    import {mapGetters} from 'vuex';
    export default {
        name: "AdminUsersComponent",
        components:{
            deleteModal,
        },
        data(){
            return{
                users:[],
                showSendMessageModal:false,
                message:{
                    title:'',
                    message:'',
                    userId:0,
                },
                showDeactivateModal: false,
                deactivateUserId:0,
                deactivateUserIndex:0,
                activateUserModal:false,
                activateUser:null,
                activateUserId:0,
            }
        },
        async created(){
            const res = await this.callApi('get','/getUsers');
            if(res.status ===200){
                this.users = res.data;
            }else{
                this.$toast.warning('Nie udało się pobrać użytkowników');
            }
        },
        methods:{
            showActivatingModal(user,index){
                this.activateUserModal = true;
                this.activateUser = user;
                this.activateUserId = index;
            },
            async activateAccount(){
                const response = await this.callApi('post','/activateUser',this.activateUser);
                if(response.status === 200){
                    this.users[this.activateUserId].active = true;
                    this.activateUserModal = false;
                    this.$toast.success('Konto zostało aktywowane');
                }else{
                    this.$toast.error('Aktywacja konta nie powiodła się');
                }
            },
            showActiveModal(userId,index){
                this.showDeactivateModal = true;
                this.deactivateUserId = userId;
                this.deactivateUserIndex = index;
            },
            async deactivateUser(){
                const response = await this.callApi('post', '/deactivateUser', {id: this.deactivateUserId});
                if (response.status === 200) {
                    this.users[this.deactivateUserIndex].active = false;
                    this.showDeactivateModal = false;
                    this.$toast.success('Pomyślnie dezaktywowano konto');
                } else {
                    this.$toast.error('Problem z dezaktywacją konta. Proszę spróbować później.')
                }
            },
            showMessageModal(userId){
                this.showSendMessageModal = true;
                this.message.userId = userId;
            },
            async sendUserMessage() {
                const response = await this.callApi('post', '/sendUserMessage', this.message);
                if (response.status === 201) {
                    this.showSendMessageModal = false;
                    this.$toast.success('Pomyślnie wysłano wiadomość');
                    const clearMessage = {
                        title: '',
                        message: '',
                        userId: null,
                    };
                    this.message = clearMessage;
                } else {
                    this.$toast.error('Problem z wysłaniem wiadomości. Proszę spróbować później.')
                }
            },
            showDeletingModal(user, index){
                const deleteModalData = {
                        showDeleteModal: true,
                        deleteUrl: "/deleteUser",
                        data: user,
                        deletingIndex: index,
                        isDeleted: false,
                };
                this.$store.commit('setDeletingModalData', deleteModalData);
            },
        },
        computed:{
            ...mapGetters(['getDeleteModalData'])
        },
        watch:{
            getDeleteModalData(obj){
                if(obj.isDeleted){
                    this.users.splice(obj.deletingIndex, 1);
                }
            }
        },
    }
</script>
