<template>
    <v-container fill-height
                 fluid
                 grid-list-xl>
        <v-layout wrap>
            <v-flex>
                <material-card
                    :color="$store.state.app.color"
                    :title="`Article List`"
                    :text="`Use Filter options to filter from article list`"
                >
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="2" class="pr-0">
                                <v-btn :color="$store.state.app.color"
                                       class="float-left"
                                       :to="{ name: 'new-article' }">
                                    Create new
                                </v-btn>
                            </v-col>
                            <v-col cols="12" md="3" class="px-0">
                                <VSelectSearchWithValidation v-model="filter.category"
                                                             :options="categories"
                                                             @change="getData"
                                                             ref="category"
                                                             field="category"
                                                             :label="`Category`"
                                                             item-text="name"/>
                            </v-col>
                            <v-col cols="12" md="3" class="px-0">
                                <VSelectSearchWithValidation v-model="filter.is_published"
                                                             :options="statuses"
                                                             @change="getData"
                                                             ref="publication_status"
                                                             field="publication_status"
                                                             :label="`Publication status`"
                                                             item-text="name"/>
                            </v-col>
                            <v-col cols="12" md="4" class=" pl-0">
                                <VTextFieldWithValidation v-model="filter.search"
                                                          @keyup="getData"
                                                          ref="search"
                                                          field="search"
                                                          :label="'Type...'"/>
                            </v-col>
                        </v-row>

                        <v-simple-table>
                            <template v-slot:default v-if="articles">
                                <thead >
                                <tr>
                                    <th class="text-left">Category</th>
                                    <th class="text-left">Title</th>
                                    <th class="text-left">Excerpt</th>
                                    <th class="text-left">Published</th>
                                    <th class="text-left">Featured</th>
                                    <th class="text-left">Viewed</th>
                                    <th class="text-left">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(article, index) in articles.data" :key="index">
                                    <td>
                                        <v-chip
                                            v-for="category in article.categories"
                                            :key="category.id"
                                            @click="() => {
                                                filter.category = category.id;
                                                getData()
                                            }"
                                            small
                                            class="ma-2"
                                            :color="$store.state.app.color"
                                        >
                                            {{ category.name }}
                                        </v-chip>
                                    </td>
                                    <td style="display: flex; align-items: center; height: fit-content; padding: 30px">
                                        <span v-if="article.image" class="mr-4">
                                            <img v-bind:src="'/' + article.image"
                                                 :alt="article.title"
                                                 width="60"
                                                 style="border-radius: 10px">
                                        </span>
                                        <span v-if="article.published">
                                            <a  :href="`/articles/${article.slug}`" target="_blank">{{ article.title }}</a>
                                        </span>
                                        <span v-else>
                                            {{ article.title }}
                                        </span>
                                    </td>
                                    <td> {{ article.excerpt ? article.excerpt.substr(0, 50) + '...' : '-' }}</td>
                                    <td>
                                        <v-chip
                                            small
                                            class="ma-2"
                                            text-color="white"
                                            :color="article.published ? 'success' : 'red'"
                                        >
                                            {{ article.published ? 'Published' : 'Pending' }}
                                        </v-chip>
                                    </td>
                                    <td>
                                        <v-chip
                                            small
                                            class="ma-2"
                                            :color="article.featured ? 'success' : 'primary'"
                                        >
                                            {{ article.featured ? 'Featured' : 'Not Featured' }}
                                        </v-chip>
                                    </td>
                                    <td>
                                        <v-chip
                                            small
                                            class="ma-2"
                                            :color="$store.state.app.color"
                                        >
                                            {{ article.viewed }}
                                        </v-chip>
                                    </td>
                                    <td>
                                        <v-icon small @click="edit(article.slug)">mdi-pencil</v-icon>
                                        <v-icon small @click="destroy(article.id)">mdi-delete</v-icon>
                                    </td>
                                </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                        <v-row justify="center">
                            <v-col cols="8">
                                <v-container class="max-width">
                                    <v-pagination
                                        v-model="articles.current_page"
                                        :length="articles.last_page"
                                        class="my-4"
                                        :total-visible="7"
                                        circle
                                        @input="paginate(articles.current_page)"
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
import Api from "@/api/resources/article";
import VSelectSearchWithValidation from "@/components/inputs/VSelectSearchWithValidation";
import categoryApi from "@/api/resources/category";
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
            articles: {},
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
        async getCategories() {
            this.loading = true;
            await categoryApi.getCategories('*').then(res => {
                this.categories = [...this.categories, ...res.data.data];
                this.loading = false;
            });
        },
        getData() {
            this.loading = true;
            const query = qs.stringify(this.filter, {encode: false, skipNulls: true});

            Api.list(this.currentPage, query).then(res => {
                console.log('currentPage', res.data.all.original.data)
                this.articles = res.data.all.original.data;
                this.currentPage = res.data.all.original.data.current_page;
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
            this.$router.push({name: 'edit-articles', params: {slug: slug}});
        },
        destroy(id) {
            if (confirm('Are you sure?')) {
                this.loading = true;
                Api.delete(id).then(res => {
                    this.loading = false;
                    this.getData();
                }).catch(err => {
                    this.loading = false;
                })
            }
        }
    },
    async created() {
        await this.getCategories();
        await this.getData();
    }
}
</script>
