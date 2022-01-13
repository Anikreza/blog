<template>
    <v-container>
        <v-row>
            <v-col cols="12" sm="6">
                <v-btn color="primary" dark class="mb-2" :loading="loading" @click="updatePriority">
                    Update priority
                </v-btn>
            </v-col>
            <v-col cols="12" sm="6">
                <v-btn color="primary" class="float-right" dark @click="openForm">
                    Create new
                </v-btn>
            </v-col>
        </v-row>

        <v-row justify="center">
            <v-dialog
                v-model="dialog"
                :persistent="true"
                max-width="600px"
                hide-overlay
                transition="dialog-top-transition"
            >
                <ValidationObserver ref="obs" v-slot="{ invalid, validated, handleSubmit, validate }">
                    <v-form>
                        <v-card>
                            <v-card-title>
                                <span class="headline">New Category</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="12" md="12">
                                            <VTextFieldWithValidation
                                                v-model="form.name"
                                                rules="required"
                                                ref="name"
                                                field="name"
                                                :label="'Category Name*'"
                                                placeholder="Tourism"/>

                                        </v-col>

                                        <v-col cols="12" sm="12" md="12">
                                            <VTextFieldWithValidation
                                                v-model="form.meta_title"
                                                rules="required"
                                                ref="meta_title"
                                                field="meta_title"
                                                :label="'Meta Title*'"
                                                placeholder="Tourism"/>

                                        </v-col>

                                        <v-col cols="12" sm="12" md="12">
                                            <VTextFieldWithValidation
                                                v-model="form.excerpt"
                                                rules="required"
                                                ref="excerpt"
                                                field="excerpt"
                                                :label="'Category Description*'"
                                                placeholder="lorem ipsum..."/>

                                        </v-col>
                                        <v-col cols="12" sm="12" md="12">
                                            <VTextFieldWithValidation
                                                v-model="form.keywords"
                                                rules="required"
                                                ref="keywords"
                                                field="keywords"
                                                :label="'Category Keyword*'"
                                                placeholder="seo keyword"
                                                hint="comma (,) separated"/>

                                        </v-col>
                                        <v-col cols="12" sm="12" md="12">
                                            <VRadioInputWithValidation field="is_video_cat"
                                                                       :rules="'required'"
                                                                       :options="[{label: 'Yes', value: 1}, {label: 'No', value: 0}]"
                                                                       v-model="form.is_video"/>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="12">
                                            <VRadioInputWithValidation field="published"
                                                                       :rules="'required'"
                                                                       :options="[{label: 'Yes', value: 1}, {label: 'No', value: 0}]"
                                                                       v-model="form.is_published"/>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="12">
                                            <VRadioInputWithValidation field="display_in_navigation"
                                                                       :rules="'required'"
                                                                       :options="[{label: 'Yes', value: 1}, {label: 'No', value: 0}]"
                                                                       v-model="form.display_in_navigation"/>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="12">
                                            <VRadioInputWithValidation field="display_in_home_page"
                                                                       :rules="'required'"
                                                                       :options="[{label: 'Yes', value: 1}, {label: 'No', value: 0}]"
                                                                       v-model="form.display_in_home_page"/>
                                        </v-col>
                                    </v-row>

                                </v-container>
                                <small>*indicates required field</small>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="dialog = false"
                                >
                                    Close
                                </v-btn>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="handleSubmit(save)"
                                >
                                    Save
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-form>
                </ValidationObserver>
            </v-dialog>
        </v-row>


        <v-simple-table>
            <template v-slot:default v-if="categories">
                <thead>
                <tr>
                    <th class="text-left"></th>
                    <th class="text-left">
                        Order
                    </th>
                    <th class="text-left">
                        Name
                    </th>
                    <th class="text-left">
                        Meta Description
                    </th>
                    <th class="text-left">
                        Published
                    </th>
                    <th class="text-left">
                        Navigation Display
                    </th>
                    <th class="text-left">
                        Homepage Display
                    </th>
                    <th class="text-left">
                        Actions
                    </th>
                </tr>
                </thead>
                <draggable
                    :list="categories.data"
                    tag="tbody"
                    @change="priorityChange"
                >
                    <tr
                        v-for="(category, index) in categories.data"
                        :key="index"
                    >
                        <td>
                            <v-icon
                                small
                                class="page__grab-icon"
                            >
                                mdi-arrow-all
                            </v-icon>
                        </td>
                        <td> {{ category.position }}</td>
                        <td> {{ category.name }}</td>
                        <td> {{ category.excerpt || '-' }}</td>
                        <td>
                            <v-chip
                                small
                                class="ma-2"
                                text-color="white"
                                :color="category.is_published ? 'success' : 'red'"
                            >
                                {{ category.is_published ? 'Published' : 'Disabled' }}
                            </v-chip>

                        </td>
                        <td>
                            <v-chip
                                small
                                class="ma-2"
                                text-color="white"
                                :color="category.display_in_navigation ? 'success' : 'red'"
                            >
                                {{ category.display_in_navigation ? 'Displayed' : 'Hidden' }}
                            </v-chip>
                        </td>
                        <td>
                            <v-chip
                                small
                                class="ma-2"
                                text-color="white"
                                :color="category.display_in_home_page ? 'success' : 'red'"
                            >
                                {{ category.display_in_home_page ? 'Displayed' : 'Hidden' }}
                            </v-chip>
                        </td>
                        <td>
                            <v-icon
                                small
                                @click="edit(category.id)"
                            >
                                mdi-pencil
                            </v-icon>

                            <v-icon
                                v-if="category.articles_count === 0"
                                small
                                @click="destroy(category.id)"
                            >
                                mdi-delete
                            </v-icon>
                        </td>
                    </tr>
                </draggable>
            </template>
        </v-simple-table>
    </v-container>
</template>
<script>
import draggable from 'vuedraggable';
import VTextFieldWithValidation from "@/components/inputs/VTextFieldWithValidation";
import {ValidationObserver} from 'vee-validate'
import categoryApi from "@/api/resources/category";
import VRadioInputWithValidation from "@/components/inputs/VRadioInputWithValidation";

export default {
    components: {
        VRadioInputWithValidation,
        VTextFieldWithValidation,
        ValidationObserver,
        draggable,
    },
    data() {
        return {
            dialog: false,
            loading: false,
            categories: {},
            editId: null,
            form: {
                name: '',
                meta_title: '',
                excerpt: '',
                keywords: '',
                is_video: 0,
                display_in_navigation: 1,
                display_in_home_page: 1,
                is_published: 1
            }
        }
    },
    methods: {
        priorityChange(data) {
            console.log(data);
        },
        updatePriority() {
            this.loading = true;
            let ids = this.categories.data.map(o => (o.id));

            categoryApi.updatePriority({ids: ids}).then(res => {
                this.index();
                this.loading = false;
            }).catch(err => {
                this.loading = false;
            })
        },
        index(page = 1) {
            this.loading = true;
            categoryApi.getCategories(page).then(res => {
                this.categories = res.data.data;
                this.loading = false;
            }).catch(err => {
                this.loading = false;
            })
        },
        openForm() {
            this.form = {
                name: '',
                meta_title: '',
                excerpt: '',
                keywords: '',
                is_video: 0,
                display_in_navigation: 1,
                display_in_home_page: 1,
                is_published: 1
            };
            this.dialog = true
        },
        edit(id) {
            this.loading = true;
            categoryApi.getCategoryDetails(id).then(res => {
                for (const key of Object.keys(this.form)) {
                    this.form[key] = res.data.data[key];
                    console.log(key)
                }
                this.dialog = true;
                this.loading = false;
                this.editId = id;
            }).catch(err => {
                this.loading = false;
            })
        },
        save() {
            this.loading = true;
            let url;

            if (this.editId === null) {
                url = categoryApi.saveCategory(this.form);
            } else {
                url = categoryApi.updateCategory(this.form, this.editId);
            }

            url.then(res => {
                this.index();
                this.loading = false;
                this.dialog = false;
            }).catch(err => {
                this.loading = false;
            })
        },
        destroy(id) {
            if (confirm('Are you sure?')) {
                this.loading = true;
                categoryApi.deleteCategory(id).then(res => {
                    this.loading = false;
                    this.index();
                }).catch(err => {
                    this.loading = false;
                })
            }
        }
    },
    created() {
        this.index();
    }
}
</script>
