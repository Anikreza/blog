<template>
  <div>
    <Notification/>
    <transition mode="out-in">
      <router-view/>
    </transition>
  </div>
</template>

<style lang="scss">
//@import "@/styles/index.scss";

/* Remove in 1.2 */
.v-datatable thead th.column.sortable i {
  vertical-align: unset;
}
</style>
<script>
import Notification from '@/components/core/Notification'

export default {
  components: {
    Notification
  },
  mounted () {
    this.$vuetify.theme.isDark = this.$store.state.app.isDark
    this.$i18n.locale = this.$store.state.app.locale
  },
}
</script>
