<template>
    <v-container fill-height fluid grid-list-xl>
        <v-layout justify-center wrap>
            <v-flex md12>
                <ArticleForm title="Edit Article"
                             short-description="Selecting published will display the article in website"
                             :article-key="$route.params.slug"/>
            </v-flex>
        </v-layout>
    </v-container>

</template>
<script>
import articleApi from "@/api/resources/article";
import ArticleForm from "@/components/forms/ArticleForm";

export default {
    components: {
        ArticleForm
    },
    data() {
        return {
            loading: false,
            slug: ''
        }
    },
    methods: {
        get() {
            this.loading = true;
            articleApi.get(this.$route.params.slug).then(res => {
                res.data.data.read_time = parseInt(res.data.data.read_time)
                res.data.data.image = null;
                this.article = res.data.data;
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
        },
        update() {
            this.loading = true;

            this.form._method = 'PUT';
            articleApi.update(this.form).then(res => {
                this.$toastr.s('Data update successful');
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
        }
    },
    created() {
        this.get();
    }
}
</script>
<style>
.ck-editor__editable {
    min-height: 300px !important;
}
</style>
