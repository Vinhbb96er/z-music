<template>
    <div id="login-register1" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="ms-login-form">
                    <div class="form-content">
                        <div class="ms_width_off50">
                            <form @submit.prevent="submitLogin" data-vv-scope="form-login">
                                <div class="ms-heading2">
                                    <h3>{{ $t('auth.sign_in') }}</h3>
                                    <p>{{ $t('auth.sign_in_title') }}</p>
                                </div>
                                <div class="input-felid">
                                    <label>{{ $t('auth.email') }}</label>
                                    <input type="text" v-model="userLogin.email"
                                        :placeholder="$t('auth.email_placeholder')"
                                        v-validate="'required|email'" name="email"
                                        :class="{'box-error': errors.has('form-login.email')}"
                                        :data-vv-as="$t('auth.email')">
                                    <span class="error">{{ errors.first('form-login.email') }}</span>
                                </div>
                                <div class="input-felid">
                                    <label>{{ $t('auth.password') }}</label>
                                    <input type="password" v-model="userLogin.password"
                                        :placeholder="$t('auth.password')"
                                        v-validate="'required'" name="password"
                                        :class="{'box-error': errors.has('form-login.password')}"
                                        :data-vv-as="$t('auth.password')">
                                    <span class="error">{{ errors.first('form-login.password') }}</span>
                                </div>
                                <div class="pull-left">
                                    <input type="checkbox" v-model="userLogin.remmeber" name="remember" id="clik">
                                    <span class="box"></span>
                                    <label for="clik" class="ck-title">{{ $t('auth.remember_me') }}</label>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="fpw">{{ $t('auth.forgot_password') }}</a>
                                </div>
                                <div class="btn-submit">
                                    <button class="btn-normal2" type="submit">
                                        {{ $t('auth.login') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <sup>Or</sup>
                        <div class="ms_width_off50 bg-trans">
                            <form @submit.prevent="submitRegister" data-vv-scope="form-register">
                                <div class="ms-heading2">
                                    <h3>{{ $t('auth.create_account') }}</h3>
                                    <p>{{ $t('auth.create_account_title') }}</p>
                                </div>
                                <div class="input-felid">
                                    <label>{{ $t('auth.email') }}</label>
                                    <input type="text" name="email"
                                        :placeholder="$t('auth.email_placeholder')"
                                        v-model="userRegister.email"
                                        v-validate="'required|email'"
                                        :class="{'box-error': errors.has('form-register.email')}"
                                        :data-vv-as="$t('auth.email')">
                                    <span class="error">{{ errors.first('form-register.email') }}</span>
                                </div>
                                <div class="input-felid">
                                    <label>{{ $t('auth.password') }}</label>
                                    <input v-validate="'required|min:6'" name="password"
                                        type="password" ref="password"
                                        v-model="userRegister.password"
                                        :class="{'box-error': errors.has('form-register.password')}"
                                        :placeholder="$t('auth.password')"
                                        :data-vv-as="$t('auth.password')">
                                    <span class="error">{{ errors.first('form-register.password') }}</span>
                                </div>
                                <div class="input-felid">
                                    <label>{{ $t('auth.confirm_password') }}</label>
                                    <input v-validate="'required|confirmed:password'"
                                        name="password_confirmation" type="password"
                                        :class="{'box-error': errors.has('form-register.password_confirmation')}"
                                        v-model="userRegister.password_confirmation"
                                        :placeholder="$t('auth.confirm_password_placeholder')"
                                        :data-vv-as="$t('auth.confirm_password_placeholder')">
                                    <span class="error">{{ errors.first('form-register.password_confirmation') }}</span>
                                </div>
                                <div class="btn-submit margin-15">
                                    <button class="btn-normal2" type="submit" @click="">
                                        {{ $t('auth.register') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapActions} from 'vuex'
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                userLogin: {
                    email: null,
                    password: null,
                    remmeber: false
                },
                userRegister: {
                    email: null,
                    password: null,
                    password_confirmation: null
                }
            };
        },
        computed: {
            ...mapGetters(['authenticated'])
        },
        methods: {
            ...mapActions(['login', 'register']),
            submitLogin() {
                this.$validator.validateAll('form-login').then(valid => {
                    if (valid) {
                        this.login(this.userLogin).then((isSuccess) => {
                            if (isSuccess) {
                                this.userLogin = {
                                    email: null,
                                    password: null,
                                    remmeber: false
                                };

                                flashMessage(this.$t('message.login_success'));
                                $('#login-register1').modal('hide');
                                this.errors.clear();
                            } else {
                                flashMessage(this.$t('message.login_failed'), 'danger');
                            }
                        }).catch(() => {
                            flashMessage(this.$t('message.login_failed'), 'danger');
                        });
                    }
                });
            },
            submitRegister() {
                this.$validator.validateAll('form-register').then(valid => {
                    if (valid) {
                        this.register(this.userRegister).then((isSuccess) => {
                            if (isSuccess) {
                                this.userRegister = {
                                    email: null,
                                    password: null,
                                    password_confirmation: null
                                };

                                flashMessage(this.$t('message.register_success'));
                                $('#login-register1').modal('hide');
                                this.errors.clear();
                            } else {
                                flashMessage(this.$t('message.register_failed'), 'danger');
                            }
                        }).catch(() => {
                            flashMessage(this.$t('message.register_error'), 'danger');
                        });
                    }
                });
            }
        }
    }
</script>
<style>

</style>
