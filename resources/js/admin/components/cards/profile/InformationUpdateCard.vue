<template>
    <material-card
        :color="$store.state.app.color"
        :title="$t('Common.edit_profile')"
        :text="$t('Common.complete_your_profile')"
    >
        <ValidationObserver ref="profileForm" v-slot="{ handleSubmit }">
            <v-form @submit.prevent="handleSubmit(onSubmit)">
                <v-container py-0>
                    <v-layout wrap>
                        <v-flex xs12 md4>
                            <VRadioInputWithValidation field="gender"
                                                       :rules="'required'"
                                                       :options="[{label: $t('Fields.mr'), value: 0}, {label: $t('Fields.mrs'), value: 1}]"
                                                       v-model="profile.gender"/>
                        </v-flex>
                        <v-flex xs12 md4>
                            <VTextFieldWithValidation :label="$t('Fields.first_name')"
                                                      field="first_name"
                                                      rules="required|min:2"
                                                      v-model="profile.first_name"
                            />
                        </v-flex>
                        <v-flex xs12 md4>
                            <VTextFieldWithValidation :label="$t('Fields.last_name')"
                                                      field="last_name"
                                                      rules="required|min:2"
                                                      v-model="profile.last_name"
                            />
                        </v-flex>
                        <v-flex xs12 md6>
                            <VTextFieldWithValidation :label="$t('Fields.email')"
                                                      disabled
                                                      field="email"
                                                      rules="required|email"
                                                      v-model="profile.email"
                            />
                        </v-flex>
                        <v-flex xs12 md6>
                            <VTextFieldWithValidation :label="$t('Fields.address')"
                                                      field="address"
                                                      v-model="profile.address"
                            />
                        </v-flex>

                        <v-flex
                            xs12
                            text-xs-right
                        >
                            <v-btn :class="`mx-0 font-weight-bold bg-color-${$store.state.app.color}`"
                                   type="submit"
                                   v-text="$t('Common.save_profile')"/>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-form>
        </ValidationObserver>
    </material-card>
</template>

<script>
import {ValidationObserver} from 'vee-validate'
import MaterialCard from '@/components/material/Card'
import VTextFieldWithValidation from '@/components/inputs/VTextFieldWithValidation'
import DatePickerWithValidation from '@/components/inputs/DatePickerWithValidation'
import VRadioInputWithValidation from '@/components/inputs/VRadioInputWithValidation'
import VFileInputWithValidation from '@/components/inputs/VFileInputWithValidation'
export default {
    name: 'information-update-card',
    components: {
        ValidationObserver,
        MaterialCard,
        VTextFieldWithValidation,
        DatePickerWithValidation,
        VRadioInputWithValidation,
        VFileInputWithValidation
    },
    data: () => {
        return {
            profile: {
                gender: 0,
                first_name: '',
                last_name: '',
                email: '',
                address: '',
            },
        }
    },
    mounted() {
        const {user} = this.$store.state
        this.profile = {
            gender: parseInt(user.gender),
            first_name: user.first_name,
            last_name: user.last_name,
            email: user.email,
            d_o_b: user.d_o_b,
            address: ''
        }
    },
    methods: {
        async onSubmit() {
            const validated = await this.$refs.profileForm.validate()
            if (!validated) return
            const {address, ...profile} = this.profile
            const formData = {...profile, ...address}
            this.$store.dispatch('saveProfile', formData)
                .then(() => this.$store.dispatch('app/setSnackbarMessage', this.$t('Messages.saved_successfully')))
                .catch(() => this.$store.dispatch('app/setSnackbarMessage', this.$t('Messages.something_went_wrong')))
        },
    }
}
</script>
