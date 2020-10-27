<template>
    <div class="container-fluid">
        <v-row>
            <v-col cols="12" lg="6">
                Tutaj będą wiadomości nomanie
            </v-col>
            <v-col lg="6">
                <send></send>
            </v-col>
        </v-row>
    </div>
</template>
<style scoped>
    .commentButton{
        text-align: right;
    }
</style>
<script>
    import send from '../Modals/SendMessageComponent';
    import {mapGetters} from 'vuex';
    export default{
        components:{send},
        data(){
            return{

            }
        },
        methods:{

        },
        async created() {

        },
        computed:{
            ...mapGetters(['getShowAskForRepair','getReportComponent']),

        },

    }
</script>
