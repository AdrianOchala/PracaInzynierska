<template>
    <div class="container-fluid">
        <v-row >
            <v-col>
            <v-row class="justify-content-center">
             <h2>Ostatnio dodane warsztaty</h2>
            </v-row>
            <v-row class="justify-content-center">
                <v-card v-for="(company,index) in newCompanies" :key="company.id" max-width="250px" class="m-2 card-outter">
                    <v-list-item>
                        <v-list-item-avatar color="grey"></v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title class="headline">{{company.name}}</v-list-item-title>
                            <v-list-item-subtitle>{{company.user.name}}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-img
                        src=""
                        height="150px"
                    ></v-img>

                    <v-card-text>
                        <span v-for="spec in company.specialization">{{ spec.name }}</span>
                    </v-card-text>

                    <v-card-actions class="card-actions">
                        <v-btn
                            text
                            color="deep-purple accent-4"
                            @click="$router.push(`/MechanicDetails/${company.id}`)"
                        >
                            Szczegóły
                        </v-btn>


                    </v-card-actions>
                </v-card>
<!--                <v-card v-if="newCompanies" v-for="(company, index) in newCompanies" :key="index"-->
<!--                    dark elevation="10" hover min-width="250px" min-height="250px" max-width="250px" max-height="250px"-->
<!--                    class="m-3">-->
<!--                <v-card-title>-->
<!--                    {{company.name}}-->
<!--                </v-card-title>-->
<!--                <v-card-subtitle>-->
<!--                    Właściciel: {{company.user.name}} {{company.user.surname}}-->
<!--                </v-card-subtitle>-->
<!--                <v-divider class="mt-1 mb-1"></v-divider>-->
<!--                <v-card-text>-->
<!--                    <ul>Specjalizacja:</ul>-->
<!--                    <li v-for="(spec, index) in company.specialization" v-if="index < 3">{{spec.name}}</li>-->
<!--                </v-card-text>-->
<!--                    <v-card-actions>-->
<!--                        <v-btn>-->
<!--                            Hali-->
<!--                        </v-btn>-->
<!--                    </v-card-actions>-->
<!--                </v-card>-->

            </v-row>
            </v-col>
        </v-row>
        <v-row>
            <h1>Dalsze informacje</h1>
        </v-row>
    </div>
</template>
<script>
    export default {
        name:'Home',
        data(){
            return{
                newCompanies:'',

            }
        },
        async created() {
            console.log('moj read',this.isRead)
            console.log('moj write',this.isWrite)
            console.log('moj delete',this.isDelete)
            const res = await this.callApi('get','/getNewMechanics')
            if(res.status === 200){
                this.newCompanies = res.data

            }else{
                this.$toast.error('Nie udało się pobrać nowych warsztatów, odśwież stronę')
            }
        }
    }
</script>
