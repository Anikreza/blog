<template>
    <material-card :color="$store.state.app.color"
                   :title="$t('Common.manage_password')"
                   :text="$t('Common.update_your_password')"
    >
        <ValidationObserver ref="passwordForm" v-slot="{ handleSubmit }">
            <v-form @submit.prevent="handleSubmit(onUpdate)">
                <v-flex xs12 md12>
                    <VTextFieldWithValidation :label="$t('Fields.current_password')"
                                              field="current_password"
                                              rules="required|string"
                                              v-model="password.current_password"
                    />
                </v-flex>
                <v-flex xs12 md12>
                    <VTextFieldWithValidation :label="$t('Fields.new_password')"
                                              ref="new_password"
                                              field="new_password"
                                              rules="required|min:8"
                                              v-model="password.new_password"
                    />
                </v-flex>
                <v-flex xs12 md12>
                    <VTextFieldWithValidation :label="$t('Fields.confirm_password')"
                                              field="confirm_password"
                                              rules="required|confirmed:new_password"
                                              v-model="password.confirm_password"
                    />
                </v-flex>
                <v-flex xs12 text-xs-right>
                    <v-btn :class="`mx-0 font-weight-bold bg-color-${$store.state.app.color}`"
                           type="submit"
                           v-text="$t('Common.update')"/>
                </v-flex>
            </v-form>
        </ValidationObserver>
    </material-card>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import MaterialCard from '@/components/material/Card'
import VTextFieldWithValidation from '@/components/inputs/VTextFieldWithValidation'
export default {
    components: {
        ValidationObserver,
        MaterialCard,
        VTextFieldWithValidation,
    },
    data: () => {
        return {
            password: {
                current_password: '',
                new_password: '',
                confirm_password: ''
            }
        }
    },
    methods: {
        onUpdate () {
            this.$refs.passwordForm.validate()
                .then(success => {
                    if (!success) {
                        return
                    } else {
                        console.log(success)
                    }
                    this.$nextTick(() => {
                        this.$refs.passwordForm.reset()
                    })
                })
        }
    }
}
</script>
