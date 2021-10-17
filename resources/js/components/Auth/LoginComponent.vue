<template>
    <div class="container-fluid">
        <v-card style="margin: auto" :width="$vuetify.breakpoint.sm ? '100vw' : '40vw'">
            <v-card-title>Logowanie do systemu</v-card-title>
            <v-card-text>
                <v-text-field v-model="data.email" type="email" label="Login"
                              :error-messages="userEmailErrors"
                              @input="$v.data.email.$touch()"
                              @blur="$v.data.email.$touch()"
                ></v-text-field>
                <v-text-field v-model="data.password" type="password" label="Hasło"
                              :error-messages="userPasswordErrors"
                              @input="$v.data.password.$touch()"
                              @blur="$v.data.password.$touch()"
                ></v-text-field>
            </v-card-text>
            <v-card-actions class="justify-center">
                <v-btn @click="login" dark>Zaloguj</v-btn>
            </v-card-actions>
        </v-card>
        <v-dialog v-model="activateUserModal" persistent max-width="500px">
            <v-card>
                <v-card-title class="justify-center text-info">
                    <p>Próbujesz zalogować się na konto, które zostało dezaktywowane.</p>
                    <p>Czy chcesz aktywować swoje konto?</p>
                </v-card-title>
                <v-card-actions class="justify-center">
                    <v-btn color="primary" @click="closeActivateUserModal">Nie</v-btn>
                    <v-btn color="primary" @click="activateAccount">Tak</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
    import {required, minLength,email} from 'vuelidate/lib/validators';
    export default {
        name:'LoginComponent',
        data(){
            return{
                //Dane do logowania
                data:{
                    email:'',
                    password:'',
                },
                activateUserModal:false,
            }
        },
        validations:{
            data:{
                email:{
                    required,
                    email:email
                },
                password:{
                    required,
                    minLength:minLength(7)
                }
            }
        },
        methods:{
            async activateAccount(){
                const response = await this.callApi('post','/activateUser',this.data);
                if(response.status === 200){
                    this.activateUserModal = false;
                    this.$toast.success('Konto zostało aktywowane');
                    const res = await this.callApi('post','login',this.data);
                    if(res.status ===200){
                        this.$toast.success('Pomyślnie zalogowano');
                        window.location = "/";
                    }else{
                        if(res.status === 401){
                            this.$toast.error(res.data.msg);
                        }else if(res.status===422) {
                            for (let i in res.data.errors) {
                                this.$toast.error(res.data.errors[i][0]);
                            }
                        }else{
                            this.$toast.error('Niepoprawne dane logowania');
                        }
                    }
                }else{
                    this.$toast.error('Aktywacja konta nie powiodła się');
                }
            },
            closeActivateUserModal(){
                this.activateUserModal = false;
            },
            async login(){
                const response = await this.callApi('post','/checkActivity',this.data);
                if(response.status === 200 && response.data ==='active'){
                    const res = await this.callApi('post','login',this.data);
                    if(res.status ===200){
                        this.$toast.success('Pomyślnie zalogowano');
                        window.location = "/";
                    }else{
                        if(res.status === 401){
                            this.$toast.error(res.data.msg);
                        }else if(res.status===422) {
                            for (let i in res.data.errors) {
                                this.$toast.error(res.data.errors[i][0]);
                            }
                        }else{
                            this.$toast.error('Niepoprawne dane logowania');
                        }
                    }
                }else if(response.status === 200 && response.data ==='not active'){
                    this.activateUserModal = true;
                }else if(response.status === 200 && response.data ==='blank'){
                    this.$toast.error('Nie istnieje użytkownik o takim adresie e-mail!');
                }

            },
        },
        computed:{
            userEmailErrors(){
                const errors = [];
                if (!this.$v.data.email.$dirty) return errors;
                !this.$v.data.email.required && errors.push('Login jest wymagany.');
                !this.$v.data.email.email && errors.push('Adres e-mail nie poprawny.');
                return errors;
            },
            userPasswordErrors(){
                const errors = [];
                if (!this.$v.data.password.$dirty) return errors;
                !this.$v.data.password.required && errors.push('Hasło jest wymagane.');
                !this.$v.data.password.minLength && errors.push('Minimum 7 znaków.');
                return errors;
            },
        }
    }
</script>
