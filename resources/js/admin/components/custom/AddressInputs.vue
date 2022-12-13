<template>
    <v-container>
        <v-layout wrap>
            <v-flex v-if="streetEnabled" :class="streetClass">
                <VTextFieldWithValidation :label="$t('Fields.street')"
                                          field="street"
                                          :rules="streetRules"
                                          v-model="address.street"
                />
            </v-flex>
            <v-flex v-if="streetNumberEnabled" :class="streetNumberClass">
                <VTextFieldWithValidation :label="$t('Fields.street_number')"
                                          field="street_number"
                                          :rules="streetNumberRules"
                                          v-model="address.street_number"
                />
            </v-flex>
            <v-flex v-if="postCodeEnabled" :class="postCodeClass">
                <VTextFieldWithValidation :label="$t('Fields.postcode')"
                                          field="postcode"
                                          :rules="postCodeRules"
                                          v-model="address.postcode"
                />
            </v-flex>
            <v-flex v-if="cityEnabled" :class="cityClass">
                <VTextFieldWithValidation :label="$t('Fields.city')"
                                          field="city"
                                          :rules="cityRules"
                                          v-model="address.city"
                />
            </v-flex>
            <v-flex v-if="countryEnabled" :class="countryClass">
                <VSelectSearchWithValidation field="country"
                                             :rules="countryRules"
                                             v-model="address.country_id"
                                             item-text="nice_name"
                                             item-value="id"
                                             :options="countries"
                />
            </v-flex>
            <v-flex v-if="phoneNumberEnabled" :class="phoneNumberClass">
                <VTelephoneNumberFieldWithValidation v-model="address.mobile_number"
                                                     @setCountryCode="(val) => address.country_code =val"
                                                     field="phone_number"
                                                     :rules="phoneNumberRules"
                                                     clearable
                                                     :dark="$store.state.app.isDark"
                                                     dark-color="#1d2631"
                                                     light-color="#f9f9f9"
                                                     valid-color="#4caf50"
                                                     :default-country-code="getCountryCode"
                />
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import VTextFieldWithValidation from '@/components/inputs/VTextFieldWithValidation'
import VuePhoneNumberInput from 'vue-phone-number-input'
import 'vue-phone-number-input/dist/vue-phone-number-input.css'
import VTelephoneNumberFieldWithValidation from '@/components/inputs/VTelephoneNumberFieldWithValidation'
import VSelectSearchWithValidation from '@/components/inputs/VSelectSearchWithValidation'
const defaultClass = 'xs12 md4'
export default {
    components: {
        VTextFieldWithValidation,
        VuePhoneNumberInput,
        VTelephoneNumberFieldWithValidation,
        VSelectSearchWithValidation
    },
    props: {
        addressData: {
            type: Object,
            default: null
        },
        streetRules: {
            type: String,
            default: ''
        },
        streetEnabled: {
            type: Boolean,
            default: true
        },
        streetClass: {
            type: String,
            default: defaultClass
        },
        streetNumberRules: {
            type: String,
            default: ''
        },
        streetNumberEnabled: {
            type: Boolean,
            default: true
        },
        streetNumberClass: {
            type: String,
            default: defaultClass
        },
        postCodeRules: {
            type: String,
            default: ''
        },
        postCodeEnabled: {
            type: Boolean,
            default: true
        },
        postCodeClass: {
            type: String,
            default: defaultClass
        },
        cityRules: {
            type: String,
            default: ''
        },
        cityEnabled: {
            type: Boolean,
            default: true
        },
        cityClass: {
            type: String,
            default: defaultClass
        },
        countryRules: {
            type: String,
            default: ''
        },
        countryEnabled: {
            type: Boolean,
            default: true
        },
        countryClass: {
            type: String,
            default: defaultClass
        },
        phoneNumberRules: {
            type: String,
            default: ''
        },
        phoneNumberEnabled: {
            type: Boolean,
            default: true
        },
        phoneNumberClass: {
            type: String,
            default: defaultClass
        },
    },
    data: () => {
        return {
            address: {
                street: '',
                street_number: '',
                postcode: '',
                city: '',
                country_id: '',
                mobile_number: '',
                country_code: ''
            },
            countries: ['Bangladesh','India','Pakistan','Sri Lanka']
        }
    },
    computed: {
        getCountryCode () {
            if (this.address.country_code === '' || this.address.country_code === null) return 'DE'
            return this.address.country_code.split(';')[0]
        }
    },
    async created () {
        await this.$store.dispatch('app/getCountryList')
            .then(countries => this.countries = countries)
        if (this.addressData !== null) {
            this.address = this.addressData
        }
    },
    watch: {
        'address': {
            handler () {
                this.$emit('address', this.address)
                console.log('this.in handler',this.address)
            },
            deep: true        }
    }
}
</script>
