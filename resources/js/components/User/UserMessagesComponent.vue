<template>
    <div class="container-fluid">
        <v-row>
            <v-col cols="12" lg="10" md="10" sm="10" offset-lg="1" offset-md="1" offset-sm="1">
                <v-card class="mx-auto">
                    <v-toolbar dark style="background: rgba(0, 0, 0, 0.7); color: white; ">
                        <v-toolbar-title>Wiadomości</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn-toggle v-model="messageType" class="hidden-sm-and-down">
                            <v-btn outlined value="Odebrane">Odebrane</v-btn>
                            <v-btn outlined value="Wysłane">Wysłane</v-btn>
                            <v-btn outlined value="Archiwum">Archiwum</v-btn>
                        </v-btn-toggle>
                        <v-menu
                            class="d-none"
                            bottom
                            left
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    dark
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                    class="d-flex d-md-none"
                                >
                                    <v-icon>mdi-dots-vertical</v-icon>
                                </v-btn>
                            </template>
                            <v-list>
                                <v-list-item>
                                    <v-btn-toggle v-model="messageType">
                                        <v-btn outlined value="Odebrane">Odebrane</v-btn>
                                        <v-btn outlined value="Wysłane">Wysłane</v-btn>
                                        <v-btn outlined value="Archiwum">Archiwum</v-btn>
                                    </v-btn-toggle>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </v-toolbar>
                    <v-expansion-panels popout>
                            <template v-for="(message, index) in messages">
                                    <v-expansion-panel v-if="messageType==='Odebrane' & getUser.id === message.receiver.id & !message.archive " @click="changeMessageStatus(message.id,index)">
                                        <v-expansion-panel-header>
                                            <v-row
                                                align="center"
                                                class="spacer"
                                                no-gutters
                                            >
                                                <v-col
                                                    lg="2"
                                                    sm="3"
                                                    md="1"
                                                    class="hidden-sm-and-down"
                                                >
                                                    <v-chip
                                                        v-if="!message.viewed"
                                                        :color="`${message.color} lighten-4`"
                                                        class="ml-0 mr-2 black--text"
                                                        label
                                                        small
                                                    >
                                                        Nie odczytano
                                                    </v-chip>
                                                    <v-chip
                                                        v-if="message.viewed"
                                                        :color="`${message.color} lighten-4`"
                                                        class="ml-0 mr-2 black--text"
                                                        label
                                                        small
                                                    >
                                                        Odczytano
                                                    </v-chip>
                                                </v-col>
                                                <v-col
                                                    class="hidden-xs-only"
                                                    sm="5"
                                                    md="3"
                                                >
                                                    <strong v-html="message.sender.name"></strong>
                                                </v-col>

                                                <v-col
                                                    class="text-no-wrap text-truncate"
                                                    lg="5"
                                                    sm="3"
                                                >
                                                    <strong v-html="message.title"></strong>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <p class="d-flex d-sm-none">Autor: {{message.sender.name}}</p>
                                            <v-divider></v-divider>
                                            <v-card-text v-text="message.content"></v-card-text>
                                            <v-card-actions>
                                                <v-btn outlined color="green" @click="answearMessage(message.sender.id)">Odpowiedz</v-btn>
                                                <v-btn outlined @click="showArchiveModal(message,index)">Archiwizuj</v-btn>
                                                <v-btn outlined color="red" @click="deleteMessage(message,index)">Usuń</v-btn>
                                            </v-card-actions>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <v-expansion-panel v-if="messageType==='Wysłane' & getUser.id === message.sender.id & !message.archive ">
                                        <v-expansion-panel-header>
                                            <v-row
                                                align="center"
                                                class="spacer"
                                                no-gutters
                                            >
                                                <v-col
                                                    lg="2"
                                                    sm="3"
                                                    md="1"
                                                    class="hidden-sm-and-down"
                                                >
                                                    <v-chip
                                                        v-if="!message.viewed"
                                                        :color="`${message.color} lighten-4`"
                                                        class="ml-0 mr-2 black--text"
                                                        label
                                                        small
                                                    >
                                                        Nie odczytano
                                                    </v-chip>
                                                    <v-chip
                                                        v-if="message.viewed"
                                                        :color="`${message.color} lighten-4`"
                                                        class="ml-0 mr-2 black--text"
                                                        label
                                                        small
                                                    >
                                                        Odczytano
                                                    </v-chip>
                                                </v-col>
                                                <v-col
                                                    class="hidden-xs-only"
                                                    sm="5"
                                                    md="3"
                                                >
                                                    <strong v-html="message.sender.name"></strong>
                                                </v-col>

                                                <v-col
                                                    class="text-no-wrap text-truncate"
                                                    lg="5"
                                                    sm="3"
                                                    xs="12"
                                                >
                                                    <strong v-html="message.title"></strong>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <p class="d-flex d-sm-none">Autor: {{message.sender.name}}</p>
                                            <v-divider></v-divider>
                                            <v-card-text v-text="message.content"></v-card-text>
                                            <v-card-actions>
                                                <v-btn outlined @click="showArchiveModal(message,index)">Archiwizuj</v-btn>
                                                <v-btn outlined color="red" @click="deleteMessage(message,index)">Usuń</v-btn>
                                            </v-card-actions>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <v-expansion-panel v-if="messageType==='Archiwum' & message.archive">
                                        <v-expansion-panel-header>
                                            <v-row
                                                align="center"
                                                class="spacer"
                                                no-gutters
                                            >
                                                <v-col
                                                    lg="2"
                                                    sm="3"
                                                    md="1"
                                                    class="hidden-sm-and-down"
                                                >
                                                    <v-chip
                                                        v-if="!message.viewed"
                                                        :color="`${message.color} lighten-4`"
                                                        class="ml-0 mr-2 black--text"
                                                        label
                                                        small
                                                    >
                                                        Nie odczytano
                                                    </v-chip>
                                                    <v-chip
                                                        v-if="message.viewed"
                                                        :color="`${message.color} lighten-4`"
                                                        class="ml-0 mr-2 black--text"
                                                        label
                                                        small
                                                    >
                                                        Odczytano
                                                    </v-chip>
                                                </v-col>
                                                <v-col
                                                    class="hidden-xs-only"
                                                    sm="5"
                                                    md="3"
                                                >
                                                    <strong v-html="message.sender.name"></strong>
                                                </v-col>

                                                <v-col
                                                    class="text-no-wrap text-truncate"
                                                    lg="5"
                                                    sm="3"
                                                >
                                                    <strong v-html="message.title"></strong>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <p class="d-flex d-sm-none">Autor: {{message.sender.name}}</p>
                                            <v-divider></v-divider>
                                            <v-card-text v-text="message.content"></v-card-text>
                                            <v-card-actions>
                                                <v-btn outlined color="green" @click="restoreMessage(message.id,index)">Przywróć</v-btn>
                                                <v-btn outlined color="red" @click="deleteMessage(message,index)">Usuń</v-btn>
                                            </v-card-actions>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                            </template>
                    </v-expansion-panels>
                </v-card>
                <delete-modal v-if="getDeleteModalData.showDeleteModal">
                        <h4 slot="header">Czy napewno chcesz usunąć wiadomość?</h4>
                </delete-modal>
                <v-dialog v-model="showArchiveMessageModal" persistent max-width="500px">
                    <v-card>
                        <v-card-title class="justify-center text-danger">
                            Zarchiwizować wiadomość?
                        </v-card-title>
                        <v-card-actions class="justify-center">
                            <v-btn text color="primary" @click="closeModal">Anuluj</v-btn>
                            <v-btn text color="primary" @click="archiveMessage">Archiwizuj</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="showSendMessageModal" persistent max-width="700px">
                    <v-card>
                        <v-card-title class="justify-center ">
                            <h4>Odpowiedz na wiadomość</h4>
                        </v-card-title>
                        <v-card-text>
                            <v-text-field v-model="sendMessage.title" label="Tytuł"></v-text-field>
                            <v-textarea
                                clearable
                                counter
                                clear-icon="mdi-close-circle"
                                label="Treść wiadomości"
                                v-model="sendMessage.message"
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
                <v-dialog v-model="restoreMessageModal" persistent max-width="500px">
                    <v-card>
                        <v-card-title class="justify-center text-danger">
                            Przywrócić wiadomość?
                        </v-card-title>
                        <v-card-actions class="justify-center">
                            <v-btn text color="primary" @click="closeRestoreModal">Anuluj</v-btn>
                            <v-btn text color="primary" @click="restoreUserMessage">Przywróć</v-btn>
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
    export default{
        components:{deleteModal},
        data(){
            return{
                messages: [],
                messageType:'Odebrane',
                showArchiveMessageModal:false,
                messageToArchive:null,
                indexOfArchivedMessage:0,
                showSendMessageModal:false,
                sendMessage:{
                    title:'',
                    message:'',
                    userId:0,
                },
                restoreMessageId:0,
                restoreMessageIndex:0,
                restoreMessageModal:false,
            }
        },
        methods:{
            show(){
                console.log(this.messageType)
            },
            async restoreUserMessage(){
                const response = await this.callApi('post','/restoreUserMessage',{id:this.restoreMessageId});
                if(response.status === 200){
                    this.$toast.success('Pomyślnie przywrócono wiadomość');
                    this.messages[this.restoreMessageIndex].archive = false;
                    this.restoreMessageModal = false;
                    this.restoreMessageIndex = 0;
                    this.restoreMessageId = 0;
                }
            },
            restoreMessage(messageId,index){
                this.restoreMessageId = messageId;
                this.restoreMessageIndex = index;
                this.restoreMessageModal = true;
            },
            closeRestoreModal(){
                this.restoreMessageModal = false;
                this.restoreMessageId = 0;
                this.restoreMessageIndex = 0;
            },
            answearMessage(senderId){
                this.showSendMessageModal = true;
                this.sendMessage.userId = senderId;
            },
            async sendUserMessage() {
                const response = await this.callApi('post', '/sendUserMessage', this.sendMessage);
                if (response.status === 201) {
                    this.showSendMessageModal = false;
                    this.$toast.success('Pomyślnie wysłano wiadomość');
                    const clearMessage = {
                        title: '',
                        message: '',
                        userId: null,
                    };
                    this.sendMessage = clearMessage;
                    const res = await this.callApi('get','/getUserMessages');
                    if(res.status === 200){
                        this.messages = res.data;
                    }
                } else {
                    this.$toast.error('Problem z wysłaniem wiadomości. Proszę spróbować później.')
                }
            },
            closeModal(){
                this.showArchiveModal = false;
                this.showArchiveMessageModal = null;
                this.indexOfArchivedMessage = 0;
            },
            showArchiveModal(message,index){
                this.messageToArchive = message;
                this.indexOfArchivedMessage = index;
                this.showArchiveMessageModal = true;
            },
            async archiveMessage(){
                const response = await this.callApi('post','/archiveUserMessage',this.messageToArchive);
                if(response.status === 200){
                    this.$toast.success('Pomyślnie zarchiwizowano wiadomość');
                    this.messages[this.indexOfArchivedMessage].archive = true;
                    this.showArchiveModal = false;
                    this.showArchiveMessageModal = null;
                    this.indexOfArchivedMessage = 0;
                }
            },
            async deleteMessage(message,index){
                const deleteModalData = {
                    showDeleteModal: true,
                    deleteUrl: "/deleteUserMessage",
                    data: message,
                    deletingIndex: index,
                    isDeleted: false,
                };
                this.$store.commit('setDeletingModalData', deleteModalData);
            },
            async changeMessageStatus(messageId,index){
                if(!this.messages[index].viewed){
                    const response = await this.callApi('post','/updateMessageView',{id: messageId});
                    if(response.status === 200){
                        this.messages[index].viewed = true;
                    }
                }
            },
        },
        async created() {
            const res = await this.callApi('get','/getUserMessages');
            if(res.status === 200){
                this.messages = res.data;
                console.log(res.data)
            }
        },
        computed:{
            ...mapGetters(['getUser','getDeleteModalData']),

        },
        watch:{
            getDeleteModalData(obj){
                if(obj.isDeleted){
                    this.messages.splice(obj.deletingIndex, 1);
                }
            }
        },
    }
</script>
