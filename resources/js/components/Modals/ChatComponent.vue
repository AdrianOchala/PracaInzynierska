<template>
    <div v-if="messages" >
        <Chat
            style="max-height: 60vh"
            :participants="participants"
            :myself="myself"
            :messages="messages"
            :colors="colors"
            :display-header="false"
            :send-images="false"
            :placeholder="placeholder"
            :timestamp-config="timestampConfig"
            :async-mode="asyncMode"
            @onMessageSubmit="onMessageSubmit"
            :profile-picture-config="profilePictureConfig"
            >

        </Chat>
    </div>
</template>
<script>
    import { Chat } from 'vue-quick-chat'
    import 'vue-quick-chat/dist/vue-quick-chat.css';
    import {mapGetters} from 'vuex'
    export default{
        props:['me','otherPerson'],
        components: {
            Chat
        },
        data() {
            return {
                repairId:0,
                asyncMode: true,
                visible: true,
                participants: [
                    this.me,
                    this.otherPerson
                ],
                myself:this.me
                ,
                messages:null,
                colors: {
                    message: {
                        myself: {
                            bg: '#fff',
                            text: '#000000'
                        },
                        others: {
                            bg: '#666666',
                            text: '#fff'
                        },
                        messagesDisplay: {
                            bg: '#f7f3ff'
                        }
                    },
                    submitIcon: '#b91010',
                },
                placeholder: 'Twoja wiadomość...',
                timestampConfig: {
                    format: 'f',
                    relative: false
                },
                profilePictureConfig:{ others: false, myself: false, },
            }
        },
        methods: {
            onType: function (event) {
                //here you can set any behavior
            },
            loadMoreMessages(resolve) {
                setTimeout(() => {
                    resolve(this.toLoad); //We end the loading state and add the messages
                    //Make sure the loaded messages are also added to our local messages copy or they will be lost
                    this.messages.unshift(...this.toLoad);
                    this.toLoad = [];
                }, 1000);
            },
            async onMessageSubmit(message)
            {
                const singleMessage = {
                    'participantId' : message.participantId,
                    'repairId':this.repairId,
                    'message':message.content,
                    'timestamp':message.timestamp
                };
                const mes = await this.callApi('post','/addMessage',singleMessage);
                if(mes.status === 201){
                    this.messages.push(message);
                    message.uploaded = true;
                }else{
                    this.$toast.error('Nie udało się wysłać wiadomości.')
                }
                // setTimeout(() => {
                //     message.uploaded = true
                // }, 2000)
            },
        },
        computed:{
            ...mapGetters(['getReportComponent']),
        },
        async created() {
            this.repairId = parseInt(this.$route.params.id);
            const [userMessages] = await Promise.all([
                this.callApi('get',`/getRepairMessages/${this.repairId}`),
            ]);
            if(userMessages.status === 200){
                this.messages = userMessages.data;

            }else{
                this.$toast.error('Błąd');
            }
        },
    }
</script>
