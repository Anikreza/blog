<template>
    <v-container>
        <v-layout justify-center wrap>
            <v-flex md12>
                <material-card
                    :color="$store.state.app.color"
                    :title="`System Settings`"
                >

                    <v-container>
                        <v-row>
                            <v-col cols="12" md="6">
                                <VTextFieldWithValidation v-model="form.app_name"
                                                          ref="app_name"
                                                          field="app_name"
                                                          :label="'App Name'"/>
                            </v-col>
                            <v-col cols="12" md="6">
                                <VTextFieldWithValidation v-model="form.app_version"
                                                          ref="app_version"
                                                          field="app_version"
                                                          :label="'App Version'"/>
                            </v-col>
                            <v-col cols="12" md="12">
                                <VTextFieldWithValidation v-model="form.ad_sense_script"
                                                          ref="ad_sense_script"
                                                          field="ad_sense_script"
                                                          :label="'Google Adsense Script'"/>
                            </v-col>
                            <v-col cols="12" md="4">
                                <VTextFieldWithValidation v-model="form.home_page_title"
                                                          ref="home_page_title"
                                                          field="home_page_title"
                                                          :label="'Home page title'"/>
                            </v-col>
                            <v-col cols="12" md="4">
                                <VTextAreaFieldWithValidation v-model="form.home_page_keywords"
                                                              rules="required"
                                                              rows="2"
                                                              ref="home_page_keywords"
                                                              field="home_page_keywords"
                                                              :label="'Home page keywords*'"
                                                              placeholder="seo keyword"
                                                              hint="comma (,) separated"/>
                            </v-col>
                            <v-col cols="12" md="4">
                                <VTextAreaFieldWithValidation v-model="form.home_page_description"
                                                              rules="required"
                                                              rows="2"
                                                              ref="home_page_description"
                                                              field="home_page_description"
                                                              :label="'Home page description*'"
                                                              placeholder="Home page description"/>
                            </v-col>


                            <v-col cols="12" md="12">
                                <VFileInputWithValidation v-model="form.home_page_image"
                                                          :image-url="form.home_page_image_url"
                                                          ref="image"
                                                          field="image"
                                                          :label="'Website Logo*'"/>
                            </v-col>

                        </v-row>
                    </v-container>
                    <v-card-actions style="text-align: center">
                        <v-btn depressed color="primary" @click="updateSettings">
                            Save
                        </v-btn>
                    </v-card-actions>
                </material-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
import VFileInputWithValidation from "@/components/inputs/VFileInputWithValidation";
import Api from "@/api/resources/settings";
import MaterialCard from '@/components/material/Card'
import VTextFieldWithValidation from "@/components/inputs/VTextFieldWithValidation";
import VTextAreaFieldWithValidation from "@/components/inputs/VTextAreaFieldWithValidation";

export default {
    components: {
        VTextAreaFieldWithValidation,
        VTextFieldWithValidation,
        VFileInputWithValidation,
        MaterialCard
    },
    data: () => ({
        loading: false,
        form: {
            app_name: '',
            app_version: '',
            ad_sense_script: '',
            home_page_title: '',
            home_page_description: '',
            home_page_keywords: '',
            home_page_image: '',
            home_page_image_url: '',
        }
    }),
    methods: {
        getSettings() {
            this.loading = true;
            Api.getSettings(this.form).then(res => {
                this.form = res.data;
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
        },
        updateSettings() {
            this.loading = true;
            Api.updateSettings(this.form).then(res => {
                this.$toastr.s('Settings update successful');
                // location.reload();
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
        }
    },
    created() {
        this.getSettings();
    }
}
</script>
