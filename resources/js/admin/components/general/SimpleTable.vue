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
                            {{ header.key.toUpperCase() }}
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
                        key: 'title'
                    },
                    {
                        sortable: false,
                        key: 'view'
                    }
                ]
            }
        },
        tableRows: {
            type: Array,
            default: () => {
                return [
                    {
                        title: 'Mit Sanuslife macht Ewald Rieder ein gesundes Lebensgefühl zum',
                        view: '187'
                    },
                    {
                        title: 'Wir brauchen einen neuen Feminismus',
                        view: '111'
                    },
                    {
                        title: 'Thomas Oliver Müller erhält für Club-Deal Chicago einen Award',
                        view: '107'
                    }
                ]
            }
        },
        title: {
            type: String,
            required: true
        },
        subTitle: {
            type: String,
            required: false
        }
    },
    data: () => ({}),
    mounted() {
        for (const item in this.tableRows) {

        }
    }
}
</script>
