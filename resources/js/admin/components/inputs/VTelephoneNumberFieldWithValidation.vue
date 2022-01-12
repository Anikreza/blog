<template>
  <ValidationProvider :name="field" :rules="customRules" v-slot="{ errors, valid}"
                      class="phone-number-selector-wrapper">
    <VuePhoneNumberInput v-model="inner_value"
                         @update="isValid"
                         :class="{'input-success': !!errors.length || !is_not_valid_number}"
                         v-bind="$attrs"
                         v-on="$listeners"
                         :error="!!errors.length || is_not_valid_number"
                         :translations="{countrySelectorLabel: $t('Fields.country_code'),phoneNumberLabel: $t('Fields.phone_number'),example: `${$t('Fields.example')}: `}"
    />
    <span class="validation-error" v-if="errors.length || is_not_valid_number">
      {{ errors[0] || $t('Messages.invalid_phone_number') }}
    </span>
  </ValidationProvider>
</template>

<script>
import VuePhoneNumberInput from 'vue-phone-number-input'
import 'vue-phone-number-input/dist/vue-phone-number-input.css'
import { ValidationProvider } from 'vee-validate'

export default {
  components: {
    VuePhoneNumberInput, ValidationProvider
  },
  props: {
    rules: {
      type: [Object, String],
      default: ''
    },
    value: {
      type: null,
      required: true
    },
    field: {
      type: String,
      required: false,
      default: null
    },
  },
  data: () => {
    return {
      inner_value: '',
      country_code: '',
      is_not_valid_number: false
    }
  },
  async created () {
    if (this.value) {
      this.inner_value = this.value
    }
  },
  computed: {
    customRules () {
      return this.rules !== '' ? this.rules : ''
    }
  },
  methods: {
    isValid (input) {
      if (input.isValid) {
        this.country_code = input.countryCode + ';' + input.countryCallingCode // e.g DE;49
        this.$emit('setCountryCode', this.country_code)
      }
      this.is_not_valid_number = !input.isValid
    }
  },
  watch: {
    // Handles internal model changes.
    inner_value (newVal) {
      this.$emit('input', newVal)
    },
    // Handles external model changes.
    value (newVal) {
      this.inner_value = newVal
    }
  },
}
</script>

<style lang="scss">
$lightThemeColor: #f9f9f9;
$primaryColor: #3f51b5;
$errorColor: #f45252;

.phone-number-selector-wrapper {
  .validation-error {
    background: #1d2631 !important;
    font-size: 13px !important;
    color: $errorColor !important;
    position: relative;
    top: -10px !important;
  }
}

#MazPhoneNumberInput {
  padding: 10px 0;
  border: none;


  input {
    background-color: $lightThemeColor;
  }

  .select-country-container {
    border: none;
    min-width: 100px !important;
    max-width: 100px !important;
    width: 100px !important;
  }


  .country-selector {
    &.has-hint, &.has-value {
      .country-selector__input {
        border: none;
        border-bottom: 1px solid;
        padding-left: 30px;
        padding-top: 5px !important;
        border-radius: 0 !important;
      }
    }
  }

  .country-selector__country-flag {
    left: 0 !important;
    top: 16px !important;
  }

  label.country-selector__label {
    left: 0 !important;
    top: -5px !important;
  }

  .input-tel__input:not(.no-country-selector) {
    border: none;
    border-bottom: 1px solid;
    border-radius: 0 !important;
  }

  .input-tel.is-focused .input-tel__input, .country-selector.is-focused input {
    //border: none !important;
    border-bottom: 1px solid;
    border-color: $primaryColor !important;
    box-shadow: none !important;
    border-radius: 0 !important;
  }

  .is-focused {
    .country-selector__label {
      color: $primaryColor !important;
    }
  }

  .input-tel__label {
    top: -5px !important;
    left: 10px !important;
  }

  .input-phone-number {
    &.has-error {
      input {
        border-color: $errorColor !important;

        &::-webkit-input-placeholder {
          color: $errorColor !important;
        }
      }
    }

  }

}
</style>
