<template>
  <v-snackbar
      v-model="displaySnackbar"
      :color="color"
      :top="true"
      :timeout="-1"
  >
    {{ snackbarMessage }}
    <v-btn dark text @click="closeSnackbar">
      {{ $t('Common.close') }}
    </v-btn>
  </v-snackbar>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name: 'notification',
  data () {
    return {
      color: 'accent',
    }
  },
  computed: {
    ...mapState('app', ['snackbarMessage', 'displaySnackbar'])
  },
  methods: {
    closeSnackbar () {
      this.$store.dispatch('app/closeSnackbar')
    }
  }
}
</script>
