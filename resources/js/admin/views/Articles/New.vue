<template>
    <v-container fill-height fluid grid-list-xl>
        <v-layout justify-center wrap>
            <v-flex md12>
                <ArticleForm title="Create Article"
                             short-description="Selecting published will display the article in website"
                />
            </v-flex>
        </v-layout>
    </v-container>

</template>
<script>
import ArticleForm from "@/components/forms/ArticleForm";

export default {
    components: {
        ArticleForm
    },
}
</script>
