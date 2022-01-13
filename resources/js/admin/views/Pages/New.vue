<template>
    <v-container fill-height fluid grid-list-xl>
        <v-layout justify-center wrap>
            <v-flex md12>
                <PageForm title="Create Page"
                          short-description="Selecting published will make available pages for selection"
                />
            </v-flex>
        </v-layout>
    </v-container>

</template>
<script>
import PageForm from "@/components/forms/PageForm";

export default {
    components: {
        PageForm,
    },
}
</script>
