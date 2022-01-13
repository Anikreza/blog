<template>
    <v-container>
        <v-row>
            <v-col cols="12" sm="6">
                <v-btn color="primary" class="float-right" dark @click="openForm">
                    Create new ad space
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
                                <span class="headline">New Ad Space</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="12" md="12">
                                            <VSelectSearchWithValidation :rules="`required`"
                                                                         :options="adTitles"
                                                                         v-model="form.name"
                                                                         ref="name"
                                                                         field="name"
                                                                         item-text="value"
                                                                         item-id="id"
                                                                         :label="'Ad Space Name*'"/>

                                        </v-col>

                                        <v-col cols="12" sm="12" md="12">
                                            <VRadioInputWithValidation field="is_google"
                                                                       @change="onTypeChange"
                                                                       :rules="'required'"
                                                                       :options="[{label: 'Yes', value: 1}, {label: 'No', value: 0}]"
                                                                       v-model="form.is_google"/>
                                        </v-col>

                                        <v-col cols="12" sm="12" md="12" v-if="form.is_google">
                                            <VTextAreaFieldWithValidation v-model="form.content"
                                                                          rules="required"
                                                                          ref="content"
                                                                          rows="5"
                                                                          field="content"
                                                                          :label="'Ad Script*'"
                                                                          placeholder="paste your script here"
                                                                          hint="it should be google script"/>

                                        </v-col>

                                        <v-col cols="12" md="12" v-if="!form.is_google">
                                            <VFileInputWithValidation v-model="form.image"
                                                                      class="pl-md-15"
                                                                      :image-url="form.image_url"
                                                                      rules="required"
                                                                      is-row
                                                                      ref="image"
                                                                      field="image"
                                                                      :label="form.is_video ? 'Poster*' : 'Image*'"/>
                                        </v-col>

                                        <v-col cols="12" md="12" v-if="!form.is_google">
                                            <VTextFieldWithValidation v-model="form.location"
                                                                      rules="required"
                                                                      ref="location"
                                                                      field="location"
                                                                      :label="'Advertisement Target URL'"/>
                                        </v-col>

                                        <v-col cols="12" sm="12" md="12">
                                            <VRadioInputWithValidation field="published"
                                                                       :rules="'required'"
                                                                       :options="[{label: 'Yes', value: 1}, {label: 'No', value: 0}]"
                                                                       v-model="form.published"/>
                                        </v-col>

                                        <v-col cols="12">
                                            <small>*indicates required field</small>
                                        </v-col>

                                        <v-col cols="12">
                                            <div v-for="(error, i) in vErrors" :key="i">
                                                <small style="color: orangered">*{{ error }}</small>
                                            </div>
                                        </v-col>
                                    </v-row>

                                </v-container>
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
            <template v-slot:default v-if="adSpaces">
                <thead>
                <tr>
                    <th class="text-left">
                        Is it google Ad?
                    </th>
                    <th class="text-left">
                        Name
                    </th>
                    <th class="text-left">
                        Is Published?
                    </th>
                    <th class="text-left">
                        Actions
                    </th>
                </tr>
                </thead>
                <tr
                    v-for="(adSpace, index) in adSpaces"
                    :key="index"
                >
                    <td>
                        <v-chip
                            small
                            class="ma-2"
                            text-color="white"
                            :color="adSpace.is_google ? 'success' : 'red'"
                        >
                            {{ adSpace.is_google ? 'Google Ad' : 'Custom Ad' }}
                        </v-chip>

                    </td>
                    <td> {{ adSpace.formatted_name }}</td>

                    <td>
                        <v-chip
                            small
                            class="ma-2"
                            text-color="white"
                            :color="adSpace.published ? 'success' : 'red'"
                        >
                            {{ adSpace.published ? 'Displayed' : 'Hidden' }}
                        </v-chip>
                    </td>
                    <td>
                        <v-icon
                            small
                            @click="edit(index)"
                        >
                            mdi-pencil
                        </v-icon>

                        <v-icon
                            v-if="!adSpace.is_google"
                            small
                            @click="destroy(adSpace.id)"
                        >
                            mdi-delete
                        </v-icon>
                    </td>
                </tr>
            </template>
        </v-simple-table>
    </v-container>
</template>
<script>
import VSelectSearchWithValidation from "@/components/inputs/VSelectSearchWithValidation";
import VTextFieldWithValidation from "@/components/inputs/VTextFieldWithValidation";
import {ValidationObserver} from 'vee-validate'
import settingsApi from "@/api/resources/settings";
import VRadioInputWithValidation from "@/components/inputs/VRadioInputWithValidation";
import VTextAreaFieldWithValidation from "@/components/inputs/VTextAreaFieldWithValidation";
import VFileInputWithValidation from "@/components/inputs/VFileInputWithValidation";

export default {
    components: {
        VSelectSearchWithValidation,
        VFileInputWithValidation,
        VTextAreaFieldWithValidation,
        VRadioInputWithValidation,
        VTextFieldWithValidation,
        ValidationObserver,
    },
    data() {
        return {
            dialog: false,
            loading: false,
            adSpaces: [],
            editId: null,
            adTitles: [
                {id: 'home_page_full_width_ad', value: 'Home page full width ad'},
                {id: 'sidebar_square_size_ad', value: 'Sidebar square size ad'},
                {id: 'in_article_responsive_ad', value: 'In article responsive ad'},
                {id: 'home_page_popular_article_section_ad', value: 'Home page popular article section ad'},
                {id: 'home_page_category_section_full_width_ad', value: 'Home page category section full width ad'},
            ],
            form: {
                name: null,
                content: null,
                is_google: 1,
                published: 1,
                location: null,
                image_url: null,
                image: null
            },
            vErrors: [] // validation errors
        }
    },
    methods: {
        index() {
            this.loading = true;
            settingsApi.getAdSpaces().then(res => {
                this.adSpaces = res.data.data;
                this.loading = false;
            }).catch(err => {
                this.loading = false;
            })
        },
        onTypeChange() {
            this.form.content = null
            this.form.image = null
        },
        openForm() {
            this.form = {
                name: null,
                content: null,
                is_google: 1,
                published: 1,
                location: null,
                image_url: null,
                image: null
            };
            this.dialog = true
            this.editId = null
        },
        edit(index) {
            this.form = this.adSpaces[index]
            this.form.image = null
            this.editId = this.adSpaces[index].id;
            this.dialog = true
        },
        save() {
            this.loading = true;
            let url;

            if (this.editId === null) {
                url = settingsApi.saveAdSpace(this.form);
            } else {
                url = settingsApi.updateAdSpace(this.form, this.editId);
            }

            url.then(res => {
                this.index();
                this.loading = false;
                this.dialog = false;
                this.vErrors = []

            }).catch(err => {
                this.loading = false;

                if (err.errors) {
                    this.vErrors = err.errors;
                } else {
                    this.vErrors = []
                }
            })
        },
        destroy(id) {
            if (confirm('Are you sure?')) {
                this.loading = true;
                settingsApi.deleteAdSpace(id).then(res => {
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
