<template>
    <b-container>
        <b-row class="justify-content-md-center mt-5">
            <b-col cols="6" align-self="center">
                <b-alert variant="danger" dismissible :show="errors != null && Object.keys(errors).length > 0">
                    <h4><i class="fas fa-exclamation-circle"></i> Error</h4>
                    <span v-html="errorsMessage"></span>
                </b-alert>
                <b-card no-body>
                    <b-form @submit.prevent="submitLogin">
                        <b-card-header>
                            <h3>Authorization</h3>
                        </b-card-header>

                        <b-card-body>
                            <b-form-group
                                label="Email"
                                label-for="email"
                            >
                                <b-form-input
                                    type="email"
                                    id="email"
                                    v-model="fields.email"
                                    :state="inputValidationState"
                                    :disabled="in_process"
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
                                    :state="inputValidationState"
                                    :disabled="in_process"
                                    required
                                ></b-form-input>
                            </b-form-group>
                        </b-card-body>

                        <b-card-footer align="right">
                            <b-button
                                type="submit"
                                class="btn-success"
                                :disabled="in_process"
                            >
                                <i v-if="in_process" class="fas fa-spinner fa-spin "></i>
                                <i v-else class="fas fa-sign-in-alt"></i>

                                Sign in
                            </b-button>
                        </b-card-footer>
                    </b-form>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    export default {
        name: 'Login',
        data: () => {
            return {
                fields: {
                    email: '',
                    password: ''
                },
                in_process: false,
                errors: null
            }
        },

        methods: {
            submitLogin: function () {
                const app = this;
                this.in_process = true;
                this.$auth.login({
                    params: app.fields,
                    success: (response) => {
                        console.log(response);
                        if (response.data.result && response.headers.authorization.length > 0) {
                            console.log('success');
                            this.errors = [];
                        } else {
                            this.errors = ['An error occurred while trying to login, please reload the page and try again.'];
                            return false;
                        }
                    },
                    error: (error) => {
                        this.errors = [error.response.data.message];
                        this.in_process = false;
                        console.log(error.response);
                    },
                    rememberMe: true,
                    redirect: '/',
                    fetchUser: true,
                })
            }
        },

        computed: {
            inputValidationState: function () {
                if (this.errors !== null)
                    return !this.errors.length > 0;
                else
                    return null;
            },

            errorsMessage: function () {
                let text = '';

                if (this.errors !== null) {
                    for (let i in this.errors) {
                        text += '<div>' + this.errors[i] + '</div>'
                    }
                }

                return text;
            }
        }
    }
</script>

<style scoped>

</style>
