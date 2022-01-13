<template>

    <material-card
        :color="$store.state.app.color"
        :title="title"
        :text="shortDescription"
    >
        <ValidationObserver ref="obs" v-slot="{ invalid, validated, handleSubmit, validate }">

            <v-form>
                <v-container>
                    <v-row>
                        <v-col cols="12" md="6">
                            <VTextFieldWithValidation v-model="form.title" rules="required" ref="title"
                                                      field="title"
                                                      :label="'Page Title*'"/>
                        </v-col>

                        <v-col cols="12" md="6">
                            <VTextFieldWithValidation v-model="form.meta_title"
                                                      rules="required"
                                                      ref="meta_title"
                                                      field="meta_title" :label="'Page Meta title'"/>
                        </v-col>


                        <v-col cols="12" md="4">
                            <VRadioInputWithValidation field="published"
                                                       :rules="'required'"
                                                       :options="[{label: 'Yes', value: 1}, {label: 'No', value: 0}]"
                                                       v-model="form.published"/>
                        </v-col>

                        <v-col cols="12" md="12">
                            <vue-editor id="editor"
                                        :editorOptions="editorConfig"
                                        v-model="form.description"/>
                        </v-col>

                        <v-col cols="12" md="6">
                            <VTextAreaFieldWithValidation v-model="form.excerpt"
                                                          rules="required"
                                                          ref="excerpt"
                                                          rows="2"
                                                          field="short_description"
                                                          :label="'Short Description*'"
                                                          hint="For SEO Meta description it will be displayed"/>
                        </v-col>

                        <v-col cols="12" sm="12" md="6">
                            <VTextAreaFieldWithValidation v-model="form.keywords"
                                                          rules="required"
                                                          rows="2"
                                                          ref="keywords"
                                                          field="keywords"
                                                          :label="'Article Keyword*'"
                                                          placeholder="seo keyword"
                                                          hint="comma (,) separated"/>

                        </v-col>

                    </v-row>
                    <v-row>
                        <v-col style="text-align: center">
                            <v-btn depressed color="primary" @click="handleSubmit(save)">
                                Save
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>

        </ValidationObserver>
    </material-card>


</template>
<script>
import MaterialCard from '@/components/material/Card'
import VTextAreaFieldWithValidation from "@/components/inputs/VTextAreaFieldWithValidation";
import VTextFieldWithValidation from "@/components/inputs/VTextFieldWithValidation";
import VSelectSearchWithValidation from "@/components/inputs/VSelectSearchWithValidation";
import VFileInputWithValidation from "@/components/inputs/VFileInputWithValidation";
import {ValidationObserver} from 'vee-validate'
import pageApi from "@/api/resources/page";
import VRadioInputWithValidation from "@/components/inputs/VRadioInputWithValidation";

import {Quill, VueEditor} from "vue2-editor";
import {ImageDrop} from 'quill-image-drop-module'
import ImageResize from 'quill-image-resize-module'

Quill.register('modules/imageResize', ImageResize)
Quill.register('modules/imageDrop', ImageDrop)

export default {
    components: {
        VRadioInputWithValidation,
        VTextAreaFieldWithValidation,
        VTextFieldWithValidation,
        VSelectSearchWithValidation,
        VFileInputWithValidation,
        ValidationObserver,
        MaterialCard,
        VueEditor
    },
    props: {
        title: {
            type: String,
            default: "Article Form"
        },
        shortDescription: {
            type: String,
            default: ""
        },
        pageKey: {
            type: String,
            required: false
        }
    },
    data() {
        return {
            loading: false,
            editorConfig: {
                modules: {
                    imageDrop: true,
                    imageResize: {}
                }
            },
            form: {
                title: '',
                excerpt: '',
                meta_title: '',
                published: 1,
                description: '',
                keywords: '',
            }
        }
    },
    async mounted() {

        if (this.pageKey) {
            await this.get();
        }
    },
    methods: {
        async get() {
            this.loading = true;
            pageApi.get(this.pageKey).then(res => {

                if (res.data.data.keywords.length) {
                    res.data.data.keywords = res.data.data.keywords.map(item => item.title).toString();
                }

                this.form = res.data.data;
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
        },
        save() {
            this.loading = true;
            let reqUrl;

            if (this.pageKey) {
                reqUrl = pageApi.update(this.form)
            } else {
                reqUrl = pageApi.save(this.form)
            }

            reqUrl.then(res => {
                this.$toastr.s('Data saved successful');
                this.$router.push({name: 'pages'});
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
        }
    }
}
</script>
<style>
#editor {
    min-height: 350px !important;
}

#editor p {
    margin: 0 0 10px 0;
}
</style>
