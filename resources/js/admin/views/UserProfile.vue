<template>
  <v-container fill-height fluid grid-list-xl>
    <v-layout justify-center wrap>

      <v-flex xs12 md8>
        <InformationUpdateCard/>
      </v-flex>

      <v-flex xs12 md4>
        <PasswordUpdateCard/>
      </v-flex>

    </v-layout>
  </v-container>
</template>

<script>

import MaterialCard from '@/components/material/Card'
import InformationUpdateCard from '@/components/cards/profile/InformationUpdateCard'
import PasswordUpdateCard from '@/components/cards/profile/PasswordUpdateCard'

export default {
  components: {
    MaterialCard,
    InformationUpdateCard,
    PasswordUpdateCard
  }
}
</script>
