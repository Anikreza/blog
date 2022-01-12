<template>
  <div>
    <material-card
        :color="color"
        :title="title"
        :text="subTitle"
    >
      <v-simple-table>
        <template v-slot:default>
          <thead>
          <tr>
            <th v-for="header in headers" :class="[header.class || '']" :key="header.key">
              {{ $t('Common.' + header.key) }}
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in tableRows" :key="index">
            <td v-for="data in item">{{ data }}</td>
          </tr>
          </tbody>
        </template>
      </v-simple-table>
    </material-card>
  </div>
</template>

<script>
import MaterialCard from '@/components/material/Card'

export default {
  components: {
    MaterialCard
  },
  props: {
    color: {
      type: String,
      default: 'accent'
    },
    headers: {
      type: Array,
      default: () => {
        return [
          {
            sortable: false,
            key: 'company'
          },
          {
            sortable: false,
            key: 'candidate'
          },
          {
            sortable: false,
            key: 'total_screen_test'
          },
          {
            sortable: false,
            key: 'passed',
            align: 'right'
          }
        ]
      }
    },
    tableRows: {
      type: Array,
      default: () => {
        return [
          {
            name: 'Google',
            totalCandidate: '109',
            totalScreenTest: '151',
            passed: '51'
          },
          {
            name: 'Microsoft',
            totalCandidate: '111',
            totalScreenTest: '178',
            passed: '45'
          },
          {
            name: 'Twitter',
            totalCandidate: '187',
            totalScreenTest: '254',
            passed: '114'
          }
        ]
      }
    },
    title: {
      type: String,
      required: true
    },
    subTitle:{
      type: String,
      required: false
    }
  },
  data: () => ({}),
  mounted () {
    for (const item in this.tableRows) {

    }
  }
}
</script>
