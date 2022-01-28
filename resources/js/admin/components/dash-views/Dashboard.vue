<template>
    <v-container
        fill-height
        fluid
        grid-list-xl
    >
        <v-layout wrap>
            <v-flex
                md12
                sm12
                lg4
            >
                <material-chart-card
                    :data="dailySalesChart.data"
                    :options="dailySalesChart.options"
                    :color="$store.state.app.color"
                    type="Line"
                >
                    <h4 class="title font-weight-light">Last 7 Days Visit</h4>
                    <p class="category d-inline-flex font-weight-light">
                        <v-icon
                            color="green"
                            small
                        >
                            mdi-arrow-up
                        </v-icon>
                        <span class="green--text">55%</span>&nbsp;
                        Visitor increased in last week
                    </p>

                    <template slot="actions">
                        <v-icon
                            class="mr-2"
                            small
                        >
                            mdi-clock-outline
                        </v-icon>
                        <span class="caption grey-lighten-1--text font-weight-light">
                            {{ $t('Common.updated_ago', {time: '4 ' + $t('Common.minute')}) }}
                        </span>
                    </template>
                </material-chart-card>
            </v-flex>
            <v-flex
                md12
                sm12
                lg4
            >
                <material-chart-card
                    :data="emailsSubscriptionChart.data"
                    :options="emailsSubscriptionChart.options"
                    :responsive-options="emailsSubscriptionChart.responsiveOptions"
                    :color="$store.state.app.color"
                    type="Bar"
                >
                    <h4 class="title font-weight-light">
                        {{ $t('Pages.Dashboard.email_campaign') }}
                    </h4>
                    <p class="category d-inline-flex font-weight-light">
                        {{ $t('Pages.Dashboard.last_campaign_performance') }}
                    </p>

                    <template slot="actions">
                        <v-icon
                            class="mr-2"
                            small
                        >
                            mdi-clock-outline
                        </v-icon>
                        <span class="caption blue-grey--text font-weight-light">
                            {{ $t('Common.updated_ago', {time: '10 ' + $t('Common.hour')}) }}
                        </span>
                    </template>
                </material-chart-card>
            </v-flex>
            <v-flex
                md12
                sm12
                lg4
            >
                <material-chart-card
                    :data="dataCompletedTasksChart.data"
                    :options="dataCompletedTasksChart.options"
                    :color="$store.state.app.color"
                    type="Line"
                >
                    <h3 class="title font-weight-light">Push Notification</h3>
                    <p class="category d-inline-flex font-weight-light">
                        Sent by every 3 hours
                    </p>

                    <template slot="actions">
                        <v-icon
                            class="mr-2"
                            small
                        >
                            mdi-clock-outline
                        </v-icon>
                        <span class="caption grey--text font-weight-light">
                            Sent 10 minute ago
                        </span>
                    </template>
                </material-chart-card>
            </v-flex>
            <v-flex
                sm6
                xs12
                md6
                lg3
            >
                <material-stats-card
                    :color="$store.state.app.color"
                    icon="mdi-book-multiple"
                    :title="`Total Articles`"
                    :value=allArticleCount
                    sub-icon="mdi-calendar"
                    :sub-text= "articleCountInLastDay+' Articles Added In Last 24 Hours'"
                />
            </v-flex>
            <v-flex
                sm6
                xs12
                md6
                lg3
            >
                <material-stats-card
                    :color="$store.state.app.color"
                    icon="mdi-account-group"
                    :title="`  Total Visits`"
                    :value=totalVisitsAllTime
                    sub-icon="mdi-account-check"
                    sub-icon-color="success"
                    :sub-text= "totalVisitsInLastDay+'  Visits in last 24 hours'"
                />
            </v-flex>
            <v-flex
                sm6
                xs12
                md6
                lg3
            >
                <material-stats-card
                    :color="$store.state.app.color"
                    icon="mdi-tag-multiple"
                    :title="`Total Categories`"
                    :value=categories
                    sub-icon="mdi-video"
                    :sub-text="`0 Video published`"
                />
            </v-flex>
            <v-flex
                sm6
                xs12
                md6
                lg3
            >
                <material-stats-card
                    :color="$store.state.app.color"
                    icon="mdi-account-multiple-check "
                    :title="`Unique User Visited`"
                    :value=visitors
                    sub-icon="mdi-update"
                    :sub-text= "visitorsInLastWeek+' Unique users in last week'"
                />
            </v-flex>
            <v-flex
                md12
                lg6
            >
                <SimpleTable :color="$store.state.app.color"
                             :title="`Most Popular Articles`"
                             :sub-title="`Last Updated at ${new Date().toDateString()}`"/>
            </v-flex>
            <v-flex
                md12
                lg6
            >
                <material-card
                    class="card-tabs"
                    :color="$store.state.app.color">
                    <v-flex slot="header">
                        <v-tabs v-model="tabs" align-with-title>
                            <v-tabs-slider color="yellow"></v-tabs-slider>
                            <v-tab class="mr-3">
                                <v-icon class="mr-2">mdi-bug</v-icon>
                                Bugs
                            </v-tab>
                            <v-tab class="mr-3">
                                <v-icon class="mr-2">mdi-code-tags</v-icon>
                                Website
                            </v-tab>
                            <v-tab>
                                <v-icon class="mr-2">mdi-cloud</v-icon>
                                Server
                            </v-tab>
                        </v-tabs>
                    </v-flex>

                    <v-tabs-items v-model="tabs">
                        <v-tab-item
                            v-for="n in 3"
                            :key="n"
                        >
                            <v-list>
                                <v-list-item @click="complete(0)">
                                    <v-list-item-action>
                                        <v-checkbox
                                            :value="list[0]"
                                            color="green"
                                        />
                                    </v-list-item-action>
                                    <v-list-item-content>
                                        <v-list-item-title>
                                            Sign contract for "What are conference organized afraid of?"
                                        </v-list-item-title>
                                    </v-list-item-content>
                                    <div class="d-flex">
                                        <v-btn

                                            class="v-btn--simple"
                                            color="success"
                                            icon
                                        >
                                            <v-icon color="primary">mdi-pencil</v-icon>
                                        </v-btn>
                                        <v-btn
                                            class="v-btn--simple"
                                            color="danger"
                                            icon
                                        >
                                            <v-icon color="error">mdi-close</v-icon>
                                        </v-btn>

                                    </div>
                                </v-list-item>
                                <v-divider/>
                                <v-list-item @click="complete(1)">
                                    <v-list-item-action>
                                        <v-checkbox
                                            :value="list[1]"
                                            color="success"
                                        />
                                    </v-list-item-action>
                                    <v-list-item-content>
                                        <v-list-item-title>
                                            Lines From Great Russian Literature? Or E-mails From My Boss?
                                        </v-list-item-title>
                                    </v-list-item-content>
                                    <div class="d-flex">
                                        <v-btn
                                            class="v-btn--simple"
                                            color="success"
                                            icon
                                        >
                                            <v-icon color="primary">mdi-pencil</v-icon>
                                        </v-btn>
                                        <v-btn

                                            class="v-btn--simple"
                                            color="danger"
                                            icon>
                                            <v-icon color="error">mdi-close</v-icon>
                                        </v-btn>
                                    </div>
                                </v-list-item>
                                <v-divider/>
                                <v-list-item @click="complete(2)">
                                    <v-list-item-action>
                                        <v-checkbox
                                            :value="list[2]"
                                            color="success"
                                        />
                                    </v-list-item-action>
                                    <v-list-item-content>
                                        <v-list-item-title>
                                            Flooded: One year later, assessing what was lost and what was found when a
                                            ravaging rain swept
                                            through metro Detroit
                                        </v-list-item-title>
                                    </v-list-item-content>
                                    <div class="d-flex">
                                        <v-btn

                                            class="v-btn--simple"
                                            color="success"
                                            icon
                                        >
                                            <v-icon color="primary">mdi-pencil</v-icon>
                                        </v-btn>
                                        <v-btn

                                            class="v-btn--simple"
                                            color="danger"
                                            icon>
                                            <v-icon color="error">mdi-close</v-icon>
                                        </v-btn>

                                    </div>
                                </v-list-item>
                            </v-list>
                        </v-tab-item>
                    </v-tabs-items>
                </material-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
// Plugins
import '@/plugins/chartist'
import MaterialCard from '@/components/material/Card'
import MaterialChartCard from '@/components/material/ChartCard'
import MaterialStatsCard from '@/components/material/StatsCard'
import SimpleTable from '@/components/general/SimpleTable'
import Api from "@/api/resources/article";

export default {
    name: 'Dashboard',
    components: {
        MaterialCard, MaterialChartCard, MaterialStatsCard, SimpleTable
    },
     data() {
        return {
            dailySalesChart: {
                data: {
                    labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
                    series: [
                        [
                            this.dailyData
                        ]
                    ]
                },
                options: {
                    lineSmooth: this.$chartist.Interpolation.cardinal({
                        tension: 0
                    }),
                    low: 0,
                    high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                    chartPadding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    }
                }
            },
            dataCompletedTasksChart: {
                data: {
                    labels: ['12am', '3pm', '6pm', '9pm', '12pm', '3am', '6am', '9am'],
                    series: [
                        [230, 750, 450, 300, 280, 240, 200, 190]
                    ]
                },
                options: {
                    lineSmooth: this.$chartist.Interpolation.cardinal({
                        tension: 0
                    }),
                    low: 0,
                    high: 1000, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                    chartPadding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    }
                }
            },
            emailsSubscriptionChart: {
                data: {
                    labels: ['Ja', 'Fe', 'Ma', 'Ap', 'Mai', 'Ju', 'Jul', 'Au', 'Se', 'Oc', 'No', 'De'],
                    series: [
                        [542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895]
                    ]
                },
                options: {
                    axisX: {
                        showGrid: false
                    },
                    low: 0,
                    high: 1000,
                    chartPadding: {
                        top: 0,
                        right: 5,
                        bottom: 0,
                        left: 0
                    }
                },
                responsiveOptions: [
                    ['screen and (max-width: 768x)', {
                        seriesBarDistance: 5,
                        axisX: {
                            labelInterpolationFnc: function (value) {
                                return value[0]
                            }
                        }
                    }]
                ]
            },
            tabs: 0,
            list: {
                0: false,
                1: false,
                2: false
            },
            articleCountInLastDay: 0,
            allArticleCount: 0,
            visitors: 0,
            visitorsInLastWeek: 0,
            totalVisitsInLastDay: 0,
            totalVisitsAllTime: 0,
            categories: 0,
            dailyData: [],
        }
    },

    methods: {
        complete(index) {
            this.list[index] = !this.list[index]
        },
        getCount(){
            this.loading = true;
            Api.ArticleCount().then(res=>{
                console.log('count',res.data.hitsPerDayLastWeek.original.data)
                this.articleCountInLastDay=res.data.countInLastDay.original.data;
                this.allArticleCount=res.data.allArticleCount.original.data;
                this.visitors=res.data.allTimeUniqueVisitors.original.data;
                this.visitorsInLastWeek=res.data.LastWeeksUniqueVisitors.original.data;
                this.totalVisitsAllTime=res.data.totalVisits.original.data;
                this.totalVisitsInLastDay=res.data.totalVisitsLastDay.original.data;
                this.categories=res.data.categoryCount.original.data;
                this.dailyData=res.data.hitsPerDayLastWeek.original.data;
                this.loading=false;
            }).catch(err => {
                this.loading = false;
            }).finally(()=>{
                console.log('again',this.dailyData[0].visits)
            })
        },
    },

    async created() {
        await this.getCount();
    }
}
</script>
