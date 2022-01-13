<template>
    <v-container fill-height
                 fluid
                 grid-list-xl>
        <v-layout wrap>
            <v-flex>
                <material-card
                    :color="$store.state.app.color"
                    :title="`Article List`"
                    :text="`Use Filter options to filter from page list`"
                >
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="2" class="pr-0">
                                <v-btn :color="$store.state.app.color"
                                       class="float-left"
                                       :to="{ name: 'new-page' }">
                                    Create new
                                </v-btn>
                            </v-col>
                            <v-col cols="12" md="4" class="px-0">
                                <VSelectSearchWithValidation v-model="filter.is_published"
                                                             :options="statuses"
                                                             @change="getData"
                                                             ref="publication_status"
                                                             field="publication_status"
                                                             :label="`Publication status`"
                                                             item-text="name"/>
                            </v-col>
                            <v-col cols="12" md="6" class=" pl-0">
                                <VTextFieldWithValidation v-model="filter.search"
                                                          @keyup="getData"
                                                          ref="search"
                                                          field="search"
                                                          :label="'Type...'"/>
                            </v-col>
                        </v-row>

                        <v-simple-table>
                            <template v-slot:default v-if="pages">
                                <thead>
                                <tr>
                                    <th class="text-left">Title</th>
                                    <th class="text-left">Excerpt</th>
                                    <th class="text-left">Published</th>
                                    <th class="text-left">Viewed</th>
                                    <th class="text-left">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(page, index) in pages.data" :key="index">
                                    <td style="display: flex; align-items: center;">
                                        <span v-if="page.published">
                                            <a :href="`/${page.slug}`" target="_blank">{{ page.title }}</a>
                                        </span>
                                        <span v-else>
                                            {{ page.title }}
                                        </span>
                                    </td>
                                    <td> {{ page.excerpt ? page.excerpt.substr(0, 50) + '...' : '-' }}</td>
                                    <td>
                                        <v-chip
                                            small
                                            class="ma-2"
                                            text-color="white"
                                            :color="page.published ? 'success' : 'red'"
                                        >
                                            {{ page.published ? 'Published' : 'Pending' }}
                                        </v-chip>
                                    </td>
                                    <td>
                                        <v-chip
                                            small
                                            class="ma-2"
                                            :color="$store.state.app.color"
                                        >
                                            {{ page.viewed }}
                                        </v-chip>
                                    </td>
                                    <td>
                                        <v-icon small @click="edit(page.slug)">mdi-pencil</v-icon>
                                        <v-icon small @click="destroy(page.id)">mdi-delete</v-icon>
                                    </td>
                                </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                        <v-row justify="center">
                            <v-col cols="8">
                                <v-container class="max-width">
                                    <v-pagination
                                        v-model="pages.current_page"
                                        :length="pages.last_page"
                                        class="my-4"
                                        :total-visible="7"
                                        circle
                                        @input="paginate(pages.current_page)"
                                    ></v-pagination>
                                </v-container>
                            </v-col>
                        </v-row>
                    </v-container>
                </material-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
import draggable from 'vuedraggable';
import VTextFieldWithValidation from "@/components/inputs/VTextFieldWithValidation";
import MaterialCard from '@/components/material/Card'
import {ValidationObserver} from 'vee-validate'
import pageApi from "@/api/resources/page";
import VSelectSearchWithValidation from "@/components/inputs/VSelectSearchWithValidation";
import qs from "qs";

export default {
    components: {
        VSelectSearchWithValidation,
        VTextFieldWithValidation,
        ValidationObserver,
        draggable,
        MaterialCard
    },
    data() {
        return {
            loading: false,
            pages: {},
            editId: null,
            categories: [
                {name: 'All', id: null},
            ],
            statuses: [
                {name: 'All', id: null},
                {name: 'Published', id: 1},
                {name: 'Pending', id: 0},
            ],
            currentPage: 1,
            filter: {
                search: null,
                category: null,
                is_published: null
            }
        }
    },
    methods: {
        getData() {
            this.loading = true;
            const query = qs.stringify(this.filter, {encode: false, skipNulls: true});

            pageApi.list(this.currentPage, query).then(res => {
                this.pages = res.data.data;
                this.currentPage = res.data.data.current_page;
                this.loading = false;
            }).catch(err => {
                this.loading = false;
            })
        },
        paginate(current_page) {
            this.currentPage = current_page;
            this.getData()
        },
        edit(slug) {
            this.$router.push({name: 'edit-pages', params: {slug: slug}});
        },
        destroy(id) {
            if (confirm('Are you sure?')) {
                this.loading = true;
                pageApi.delete(id).then(res => {
                    this.loading = false;
                    this.getData();
                }).catch(err => {
                    this.loading = false;
                })
            }
        }
    },
    async created() {
        await this.getData();
    }
}
</script>
