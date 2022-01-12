<template>
  <div v-on="$listeners">
    <v-list-item
        :to="linkInfo.to === '#' ? '': linkInfo.to"
        :active-class="`bg-color-${$store.state.app.color}`"
        class="v-list-item single-item"
        link
    >
      <v-list-item-icon v-if="iconEnabled">
        <v-icon v-text="linkInfo.icon"/>
      </v-list-item-icon>

      <v-list-item-title v-text="$t('Core.Nav.'+ linkInfo.slug)"/>

    </v-list-item>
  </div>
</template>

<script>
export default {
  name: 'drawer-single-item',
  props: {
    linkInfo: {
      type: Object,
      required: true
    },

  },
  computed: {
    iconEnabled () {
      return (this.linkInfo.subLinks === undefined || !this.linkInfo.subLinks.length)
    }
  }
}
</script>
