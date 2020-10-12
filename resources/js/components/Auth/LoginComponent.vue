<template>
    <div class="container-fluid">
        <v-card style="width: 40vw; margin: auto">
            <v-card-title>Logowanie do systemu</v-card-title>
            <v-card-text>
                <v-text-field v-model="data.email" type="email" label="Login"></v-text-field>
                <v-text-field v-model="data.password" type="password" label="Hasło"></v-text-field>
            </v-card-text>
            <v-card-actions class="justify-center">
                <v-btn @click="login" dark>Zaloguj</v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>
<script>
    export default {
        name:'LoginComponent',
        data(){
            return{
                //Dane do logowania
                data:{
                    email:'',
                    password:'',
                },
            }
        },
        methods:{
            async login(){
                const res = await this.callApi('post','login',this.data);
                if(res.status ===200){
                    this.$toast.success('Pomyślnie zalogowano');
                    window.location = "/"
                }else{
                    if(res.status === 401){
                        this.$toast.error(res.data.msg)
                    }else if(res.status===422) {
                        for (let i in res.data.errors) {
                            this.$toast.error(res.data.errors[i][0])
                        }
                    }else{
                        this.$toast.error('Niepoprawne dane logowania')
                    }
                }
            },
        },
    }
</script>
