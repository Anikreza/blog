<template>
    <v-container>
        <v-layout justify-center wrap>
            <v-flex md12>
                <v-row>
                    <v-col v-for="(widget, index) in widgets" :key="index" cols="6" md="6" sm="12">
                        <material-card
                            :color="$store.state.app.color"
                            :title="widget.title"
                        >

                            <v-container>
                                <v-row>
                                    <v-col cols="12" md="6">
                                        <VSelectSearchWithValidation v-model="page"
                                                                     :options="widget.availableData"
                                                                     @change="selectPage($event, widget.widgetName)"
                                                                     ref="page"
                                                                     field="page"
                                                                     :no-data-text="`No Page Available for selection`"
                                                                     :label="`Select Page`"
                                                                     item-text="title"/>
                                    </v-col>
                                </v-row>

                                <v-row v-if="widget.data.length">
                                    <v-simple-table>
                                        <template v-slot:default v-if="widget.data">
                                            <thead>
                                            <tr>
                                                <th>Reorder</th>
                                                <th class="text-left">
                                                    Footer Page Links
                                                </th>
                                                <th>
                                                    Remove
                                                </th>
                                            </tr>
                                            </thead>
                                            <draggable
                                                :list="widget.data"
                                                tag="tbody"
                                            >
                                                <tr
                                                    v-for="(page, wIndex) in widget.selectedPages"
                                                    :key="wIndex"
                                                >
                                                    <td>
                                                        <v-icon
                                                            small
                                                            class="page__grab-icon"
                                                        >
                                                            mdi-arrow-all
                                                        </v-icon>
                                                    </td>
                                                    <td> {{ page.title }}</td>
                                                    <td>
                                                        <v-icon
                                                            small
                                                            @click="removePage(wIndex, widget.widgetName)"
                                                        >
                                                            mdi-delete
                                                        </v-icon>
                                                    </td>
                                                </tr>
                                            </draggable>
                                        </template>
                                    </v-simple-table>
                                </v-row>

                                <v-row>
                                    <v-col>
                                        <v-btn :color="$store.state.app.color"
                                               @click="priorityChange(widget.widgetName)">Save
                                            Changes
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-container>

                        </material-card>
                    </v-col>
                </v-row>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
import VFileInputWithValidation from "@/components/inputs/VFileInputWithValidation";
import pageApi from "@/api/resources/page";
import MaterialCard from '@/components/material/Card'
import VTextFieldWithValidation from "@/components/inputs/VTextFieldWithValidation";
import VTextAreaFieldWithValidation from "@/components/inputs/VTextAreaFieldWithValidation";
import VSelectSearchWithValidation from "@/components/inputs/VSelectSearchWithValidation";
import draggable from 'vuedraggable';

export default {
    components: {
        VSelectSearchWithValidation,
        VTextAreaFieldWithValidation,
        VTextFieldWithValidation,
        VFileInputWithValidation,
        MaterialCard,
        draggable
    },
    data: () => ({
        loading: false,
        pages: [],
        page: '',
        footerSelectedPageId: [],
        mobileAppSelectedPageId: []
    }),
    computed: {
        availableFooterPages() {
            return this.pages.filter(page => !this.footerSelectedPageId.includes(page.id));
        },
        footerPages() {
            return this.footerSelectedPageId ? this.footerSelectedPageId.map(id => this.pages.find(p => p.id === id)) : []
        },
        availableAppNavPages() {
            return this.pages.filter(page => this.mobileAppSelectedPageId !== undefined ? !this.mobileAppSelectedPageId.includes(page.id) : []);
        },
        appNavigationPages() {
            return this.mobileAppSelectedPageId ? this.mobileAppSelectedPageId.map(id => this.pages.find(p => p.id === id)) : []
        },
        widgets() {
            return [
                {
                    title: 'Footer Links',
                    availableData: this.availableFooterPages,
                    selectedPages: this.footerPages,
                    data: this.footerSelectedPageId,
                    'widgetName': 'footer_pages'
                },
                {
                    title: 'Mobile App Sidebar Navigation Pages',
                    availableData: this.availableAppNavPages,
                    selectedPages: this.appNavigationPages,
                    data: this.mobileAppSelectedPageId,
                    'widgetName': 'app_navigation_pages'
                }
            ];
        }
    },
    methods: {
        getPages() {
            this.loading = true;
            pageApi.getAllPages(this.form).then(res => {
                this.pages = res.data.data.pages;
                this.footerSelectedPageId = res.data.data.footerPageIds;
                this.mobileAppSelectedPageId = res.data.data.appNavigationPageIds;
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
        },

        selectPage(pageId, type) {
            if (type === 'footer_pages') {
                this.footerSelectedPageId.push(pageId);
            } else {
                this.mobileAppSelectedPageId.push(pageId);
            }
        },

        removePage(index, type) {
            if (type === 'footer_pages') {
                this.footerSelectedPageId.splice(index);
            } else {
                this.mobileAppSelectedPageId.splice(index);
            }
        },

        priorityChange(widget_name = 'footer_pages') {
            this.loading = true;

            pageApi.savePageIds({ids: this.footerSelectedPageId, widget_name}).then(res => {
                this.loading = false;
                this.$toastr.s('Saved successful');
            }).catch(err => {
                this.loading = false;
                this.$toastr.e('Something went wrong');
            })
        }
    },
    async created() {
        await this.getPages();
    }
}
</script>
