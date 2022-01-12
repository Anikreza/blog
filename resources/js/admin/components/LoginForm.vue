<template>
    <v-main>
        <v-container
            style="height: 100vh"
            fill-height
            fluid>
            <v-layout
                align-center
                justify-center>
                <v-flex
                    xs12
                    sm8
                    md4>
                    <ValidationObserver ref="obs" v-slot="{ invalid, validated, handleSubmit, validate }">
                        <v-form>
                            <v-card
                                class="elevation-12">
                                <v-toolbar
                                    :color="color">
                                    <v-toolbar-title style="color: white">{{
                                            $t('Pages.Login.toolbarTitle')
                                        }}
                                    </v-toolbar-title>
                                    <v-spacer/>
                                </v-toolbar>
                                <v-card-text>
                                    <VTextFieldWithValidation
                                        v-model="form.email"
                                        prepend-icon="mdi-account"
                                        rules="required|email"
                                        ref="email"
                                        field="email"
                                        :label="$t('Fields.email')"
                                        placeholder="john-doe@email.com"/>
                                    <VTextFieldWithValidation
                                        v-model="form.password"
                                        prepend-icon="mdi-lock"
                                        :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                                        rules="required|min:6"
                                        ref="password"
                                        field="password"
                                        :label="$t('Fields.password')"
                                        placeholder="******"
                                        :type="showPassword ? 'text' : 'password'"
                                        counter
                                        @click:append="showPassword = !showPassword"
                                    />

                                </v-card-text>
                                <v-divider class="mt-5"/>
                                <v-card-actions>
                                    <v-spacer/>
                                    <v-btn
                                        @click="handleSubmit(login)" :disabled="invalid || !validated"
                                        align-center
                                        justify-center
                                        :color="color">{{ $t('Pages.Login.login') }}
                                    </v-btn>
                                </v-card-actions>

                            </v-card>
                        </v-form>
                    </ValidationObserver>
                </v-flex>
            </v-layout>

        </v-container>
    </v-main>
</template>

<script>
import {ValidationObserver} from 'vee-validate'
import VTextFieldWithValidation from '@/components/inputs/VTextFieldWithValidation'

export default {
    components: {
        VTextFieldWithValidation, ValidationObserver
    },
    data: function () {
        return {
            form: {
                email: '',
                password: '',
            },
            color: 'accent',
            showPassword: false
        }
    },

    // Sends action to Vuex that will log you in and redirect to the dash otherwise, error
    methods: {
        async login() {
            const result = await this.$refs.obs.validate()
            if (result) {
                await this.$store.dispatch('login', this.form)
                    .then(() => this.$router.push('/dashboard/admin/home'))
                    .catch(() => {
                        this.$store.dispatch('app/setSnackbarMessage', this.$t('Messages.login_failed'))
                    })
            }
        },
        reset() {
            this.$nextTick(() => {
                this.$refs.obs.reset()
            })
        }
    },
    metaInfo() {
        return {
            title: this.$t('Home.siteName', {siteName: process.env.MIX_APP_NAME}) + ' | ' + this.$t('Pages.Login.login')
        }
    }
}
</script>
