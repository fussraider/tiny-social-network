<template>
    <b-container>
        <b-row class="justify-content-md-center mt-5">
            <b-col cols="6" align-self="center">
                <b-card no-body>
                    <b-form @submit.prevent="submitRegister">
                        <b-card-header>
                            <h3>Registration</h3>
                        </b-card-header>

                        <b-card-body>
                            <b-form-group
                                label="Name"
                                label-for="name"
                            >
                                <b-form-input
                                    type="text"
                                    id="name"
                                    v-model="fields.name"
                                    required
                                ></b-form-input>
                            </b-form-group>


                            <b-form-group
                                label="Email"
                                label-for="email"
                            >
                                <b-form-input
                                    type="email"
                                    id="email"
                                    v-model="fields.email"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group
                                label="Password"
                                label-for="password"
                            >
                                <b-form-input
                                    type="password"
                                    id="password"
                                    v-model="fields.password"
                                    required
                                ></b-form-input>
                            </b-form-group>


                            <b-form-group
                                label="Confirm password"
                                label-for="password-confirmation"
                            >
                                <b-form-input
                                    type="password"
                                    id="password-confirmation"
                                    v-model="fields.password_confirmation"
                                    required
                                ></b-form-input>
                            </b-form-group>
                        </b-card-body>

                        <b-card-footer align="right">
                            <b-button type="submit" class="btn-success">Register</b-button>
                        </b-card-footer>
                    </b-form>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    export default {
        name: 'Register',

        data: () => {
            return {
                fields: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
                errors: {}
            }
        },
        methods: {
            submitRegister: function() {
                const app = this;

                this.$auth.register({
                    data: app.fields,
                    success: (r) => {
                        console.log(r);
                    },
                    error: (r) => {
                        console.log(r)
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
