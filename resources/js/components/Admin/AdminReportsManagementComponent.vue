<template>
        <div class="container-fluid">
            <v-row>
                <v-col lg="6" md="12">
                    <v-card>
                        <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; ">Zgłoszone komentarze</v-card-title>
                            <v-simple-table>
                                <template v-slot:default>
                                    <thead>
                                    <tr>
                                        <th class="text-left">Zgłaszający</th>
                                        <th class="text-left">Powód</th>
                                        <th class="text-left">Data zgłoszenia</th>
                                        <th class="text-left">Szczegóły</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(comment,i) in comments" :key="i">
                                        <td v-if="comment.user">{{ comment.user.name }} {{comment.user.surname}}</td>
                                        <td v-if="!comment.user">Użytkownik usunięty</td>
                                        <td>{{ comment.reason }}</td>
                                        <td>{{ comment.created_at }}</td>
                                        <td>
<!--                                            pierwsze przesyłam id komentarza do pobrania, id zgłaszającego, index w tabeli,report do usuniecia-->
                                            <v-btn v-if="comment.user" @click="showComment(comment.target_id,comment.user.id,i,comment)">Szczegóły</v-btn>
<!--                                             pierwsze id komentarza do pobrania, zgłaszający usunięty wiec 0, index w tabeli-->
                                            <v-btn v-if="!comment.user" @click="showComment(comment.target_id,0,i,comment)">Szczegóły</v-btn>
                                        </td>
                                    </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                    </v-card>
                    <v-dialog v-if="singleComment !== null" v-model="showSingleComment" persistent width="700px">
                            <v-card>
                                <v-card-title>Komentarz:</v-card-title>
                                <v-list two-line v-if="singleComment">
                                    <v-list-item-group>
                                        <template>
                                            <v-list-item>
                                                <template>
                                                    <v-list-item-content>
                                                        <v-list-item-title v-if="singleComment.user">{{singleComment.user.name}} {{singleComment.user.surname}}</v-list-item-title>
                                                        <v-list-item-title v-if="!singleComment.user">Użytkownik usunięty</v-list-item-title>
                                                        <v-list-item-subtitle>{{singleComment.comment}}</v-list-item-subtitle>
                                                    </v-list-item-content>
                                                    <v-list-item-action>
                                                        <v-list-item-action-text></v-list-item-action-text>
                                                        <v-rating
                                                            v-model="singleComment.rating"
                                                            color="yellow darken-3"
                                                            background-color="grey darken-1"
                                                            empty-icon="$ratingFull"
                                                            half-increments
                                                            hover
                                                            medium
                                                            readonly
                                                        ></v-rating>
                                                        ({{singleComment.rating}})
                                                    </v-list-item-action>
                                                </template>
                                            </v-list-item>
                                        </template>
                                    </v-list-item-group>
                                </v-list><p v-else>Nie znaleziono komentarza.</p>
                                <v-btn v-if="singleComment && singleComment.user" outlined class="my-2 mx-1" @click="messageToCommentOwner">Wiadomość do komentującego</v-btn>
                                <v-btn outlined class="my-2 mx-1" @click="messageToApplicant">Wiadomość do zgłaszającego</v-btn>
                                <v-btn v-if="singleComment" outlined class="my-2 mx-1" @click="showDeletingCommentModal(singleComment)">Usuń komentarz</v-btn>
                                <v-divider></v-divider>
                                <v-card-actions>
                                    <v-btn @click="showSingleComment = false">Zamknij</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn @click="showDeletingReportModal">Usuń zgłoszenie</v-btn>
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
                                <v-btn text color="primary" @click="showSendMessageModal = false">Anuluj</v-btn>
                                <v-btn text color="primary" @click="sendUserMessage" >Wyślij</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <deleteModal v-if="getDeleteModalData.showDeleteModal">
                        <h4 slot="header">Czy na pewno chcesz usunąć zgłoszenie?</h4>
                    </deleteModal>
                </v-col>
                <v-col lg="6" md="12">
                    <v-card>
                        <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; ">Zgłoszone warsztaty</v-card-title>
                    </v-card>
                </v-col>
            </v-row>

        </div>
</template>
<script>
    import deleteModal from '../Modals/DeleteModalComponent';
    import {mapGetters} from 'vuex';
    export default {
        name: "AdminReportsManagement",
        components:{
            deleteModal,
        },
        data(){
            return{
                comments:[],
                companies:[],
                singleComment:null,
                deletingIndex:null,
                deletingObject:null,
                ownerOfReport:'',
                showSingleComment:false,
                showSendMessageModal:false,
                message:{
                    title:'',
                    message:'',
                    userId:0,
                },
                deletingComment:false,
                deletingReport:false,
            }
        },

        methods:{
            messageToCommentOwner(){
                this.showSendMessageModal = true;
                this.message.userId = this.singleComment.user.id;
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
            messageToApplicant(){
                this.showSendMessageModal = true;
                this.message.userId = this.ownerOfReport;
            },
            async showComment(commentId,userId,index,reportObj){
                this.ownerOfReport = userId;
                this.deletingIndex = index;
                this.showSingleComment = true;
                this.deletingObject = reportObj;
                const response = await this.callApi('post','/getSingleComment',{id:commentId});
                if(response.status === 200){
                    this.singleComment = response.data[0];
                }
            },
            showDeletingCommentModal(obj){
                const deleteModalData = {
                        showDeleteModal: true,
                        deleteUrl: "/deleteComment",
                        data: obj,
                        deletingIndex: this.deletingIndex,
                        isDeleted: false,
                };
                this.$store.commit('setDeletingModalData', deleteModalData);
            },
            showDeletingReportModal(){
                const deleteModalData = {
                    showDeleteModal: true,
                    deleteUrl: "/deleteReport",
                    data: this.deletingObject,
                    deletingIndex: this.deletingIndex,
                    isDeleted: false,
                };
                this.deletingReport = true;
                this.$store.commit('setDeletingModalData', deleteModalData);
            },
        },
        async created(){
            const res = await this.callApi('get','/getReports');
            if(res.status ===200){
                this.comments = res.data[0];
                this.companies = res.data[1];
            }else{
                this.$toast.warning('Nie udało się pobrać zgłoszeń');
            }
        },
        computed:{
            ...mapGetters(['getDeleteModalData'])
        },
        watch:{
            getDeleteModalData(obj){
                if(obj.isDeleted){
                    if(this.deletingReport){
                        this.comments.splice(obj.deletingIndex, 1);
                        this.showSingleComment=false;
                    }

                }
            }
        },
    }
</script>
