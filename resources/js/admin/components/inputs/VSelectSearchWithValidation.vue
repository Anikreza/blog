<template>
  <ValidationProvider :name="field" :rules="rules" v-slot="{ errors, valid}">
    <v-autocomplete v-model="inner_value"
                    v-bind="$attrs"
                    v-on="$listeners"
                    :items="options"
                    :filter="customFilter"
                    :item-text="itemText"
                    :item-value="itemValue"
                    :label="$t('Fields.' + field)"
                    clearable
                    :error="!!errors.length"
                    :error-messages="errors"
                    :success="valid"
                    :no-data-text="$t('Messages.nothing_matched_your_search_criteria')"
    />
  </ValidationProvider>
</template>

<script>
import { ValidationProvider } from 'vee-validate'

export default {
  name: 'VSelectSearchWithValidation',
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
      required: false
    },
    field: {
      type: String,
      required: true
    },
    options: {
      type: Array,
      required: true
    },
    itemText: {
      type: String,
      required: true,
      default: 'name'
    },
    itemValue: {
      type: String,
      default: 'id'
    }
  },
  data: () => {
    return {
      inner_value: '',
    }
  },
  async created () {
    this.inner_value = this.value
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
  methods: {
    customFilter (item, queryText, itemText) {
      const textOne = item[this.itemText].toLowerCase()
      const searchText = queryText.toLowerCase()
      return textOne.indexOf(searchText) > -1
    },
  }
}
</script>

<style scoped>

</style>
