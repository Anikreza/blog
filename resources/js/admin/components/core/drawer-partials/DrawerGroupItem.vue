<template>
  <div v-on="$listeners">
    <div v-if="linkInfo.subLinks !== undefined && linkInfo.subLinks.length">
      <v-list-group
          class="child-group-items"
          :to="linkInfo.to === '#' ? '': linkInfo.to"
          no-action
          sub-group
          dense
          link
      >
        <template v-slot:activator>
          <v-list-item-content>
            <v-list-item-title v-text="$t('Core.Nav.'+ linkInfo.slug)"/>
          </v-list-item-content>
        </template>

        <div v-for="(moreLinkInfo, k) in linkInfo.subLinks">
          <DrawerSingleItem :link-info="moreLinkInfo" :key="k"/>
        </div>
      </v-list-group>
    </div>
    <div v-else>
      <DrawerSingleItem :link-info="linkInfo"/>
    </div>
  </div>
</template>
<script>
import DrawerSingleItem from '@/components/core/drawer-partials/DrawerSingleItem'

export default {
  name: 'drawer-group-item',
  components: {
    DrawerSingleItem
  },
  props: {
    linkInfo: {
      type: Object,
      required: true
    }
  }
}
</script>
