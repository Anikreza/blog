<template>
  <v-menu
      ref="menu"
      v-model="menu"
      :close-on-content-click="false"
      transition="scale-transition"
      offset-y
      min-width="290px"
  >
    <template v-slot:activator="{ on, attrs }">

      <VTextFieldWithValidation :rules="rules"
                                outlined
                                v-model="date"
                                :label="$t(`Fields.${fieldKey}`)"
                                :field="fieldKey"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                append-icon="event"
      />
    </template>
    <v-date-picker
        ref="picker"
        v-model="date"
        :max="new Date().toISOString().substr(0, 10)"
        min="1950-01-01"
        @input="menu = false"
        :locale="$store.state.app.locale"
    ></v-date-picker>
  </v-menu>
</template>

<script>
import VTextFieldWithValidation from '@/components/inputs/VTextFieldWithValidation'

export default {
  components: {
    VTextFieldWithValidation
  },
  props: {
    fieldKey: {
      type: String,
      required: true
    },
    rules: {
      type: String,
      default: ''
    },
    value: {
      type: String,
      required: false
    },
  },
  async created () {
    this.date = this.value ? new Date(this.value) : null
  },
  data: () => ({
    date: null,
    menu: false,
  }),
  watch: {
    menu (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    },
    date (newVal) {
      this.$emit('input', newVal)
    },
    value (newVal) {
      this.date = newVal
    }
  },
  methods: {
    save (date) {
      this.$refs.menu.save(date)
    },
  },
}
</script>
