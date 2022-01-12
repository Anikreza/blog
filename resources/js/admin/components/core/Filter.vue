<template>
  <v-menu
      :close-on-content-click="false"
      top
      min-width="300"
      max-width="300"
      :offset-y="true"
      transition="slide-x-transition"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-btn
          class="elevation-0 filter-button"
          :color="$store.state.app.color"
          fixed
          top
          v-bind="attrs" v-on="on"
      >
        <v-icon>settings</v-icon>
      </v-btn>
    </template>

    <v-card>
      <v-container grid-list-xl>
        <v-layout wrap class="pb-5">
          <v-divider class="mt-3"/>
          <v-flex xs12>
            <div class="text-center body-2 text-uppercase filter-menu-item-label">Active Language</div>
            <v-layout justify-center class="theme-changer">
              <v-avatar
                  v-for="t in $i18n.availableLocales"
                  :key="t"
                  :class="[t === $i18n.locale ? 'color-active bg-color-success' : 'bg-color-'+color]"
                  v-text="t.toUpperCase()"
                  size="50"
                  @click="setLocale(t)"
              />
            </v-layout>
          </v-flex>
          <v-divider class="mt-3"/>
          <v-flex xs12>
            <div class="text-center body-2 text-uppercase filter-menu-item-label">Active Theme</div>
            <v-layout justify-center class="theme-changer">
              <v-avatar
                  v-for="t in themes"
                  :key="t.name"
                  :class="[t.isDark === isDark ? 'color-active' : '', t.name === 'Light' ? 'theme--light' : 'theme--dark']"
                  size="50"
                  @click="setTheme(t.isDark)"
              />
            </v-layout>
          </v-flex>
          <v-divider class="mt-3"/>

          <v-flex xs12>
            <div class="text-center body-2 text-uppercase filter-menu-item-label">Active Theme Color</div>
            <v-layout justify-center>
              <v-avatar
                  v-for="c in colors"
                  :key="c"
                  :class="[c === color ? 'color-active bg-color-' + c: 'bg-color-' + c]"
                  size="23"

                  @click="setColor(c)"
              />
            </v-layout>
          </v-flex>
          <v-divider class="mt-3"/>
        </v-layout>
      </v-container>
    </v-card>
  </v-menu>
</template>

<script>
// Utilities
import { mapState } from 'vuex'

export default {
  data: () => ({
    colors: [
      'primary', 'secondary', 'tertiary', 'accent', 'error', 'info', 'success', 'warning', 'general'
    ],
    themes: [{ name: 'Light', isDark: false }, { name: 'Dark', isDark: true }]
  }),

  computed: {
    ...mapState('app', ['isDark', 'color']),
  },

  methods: {
    setColor (color) {
      this.$store.state.app.color = color
      this.$store.dispatch('app/setColor', color)
    },
    setTheme (isDark) {
      this.$store.dispatch('app/setIfDark', isDark)
      this.$vuetify.theme.isDark = isDark
    },
    setLocale (slug) {
      this.$store.dispatch('app/setLocale', slug)
      this.$i18n.locale = slug
    }
  }
}
</script>

<style lang="scss">
.v-avatar,
.v-responsive {
  cursor: pointer;
}
</style>
