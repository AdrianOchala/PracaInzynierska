<template>

            <v-card>
              <v-card-title class="justify-center text-danger">
                  <h4>Tytuł</h4>

              </v-card-title>
                <v-card-text>
                    <v-textarea
                        clearable
                        counter
                        clear-icon="mdi-close-circle"
                        label="Powód zgłoszenia"
                        v-model="message"
                        hint="Max 250 znaków"
                        filled
                        auto-grow
                        background-color="#CFD8DC"
                        rows="1"
                    ></v-textarea>
                </v-card-text>
                <v-card-actions class="justify-center">
                    <v-btn text color="primary" >Anuluj</v-btn>
                    <v-btn text color="primary" >Zgłoś</v-btn>
                </v-card-actions>
            </v-card>

</template>
<script>
    import {mapGetters} from 'vuex'
    export default{
        name:'SendMessageComponent',
        data(){
            return{
                message:'',
            }
        },
        methods:{

        },
        computed:{
            ...mapGetters(['getReportComponent']),
        },
    }
</script>
