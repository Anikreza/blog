<template>
  <ValidationProvider :name="field" :rules="rules" v-slot="{ errors, valid}">
    <v-textarea
        outlined
        v-model="inner_value"
        :error-messages="errors"
        :success="valid"
        v-bind="$attrs"
        v-on="$listeners"
    ></v-textarea>
  </ValidationProvider>
</template>

<script>
import { ValidationProvider } from 'vee-validate'

export default {
  components: {
    ValidationProvider
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
  data: () => ({
    inner_value: ''
  }),
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
  async created () {
    if (this.value) {
      this.inner_value = this.value
    }
  }
}
</script>
