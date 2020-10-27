<template>
    <div class="container-fluid">
        <v-card style="width: 40vw; margin: auto">
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
