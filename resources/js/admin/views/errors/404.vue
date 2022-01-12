<template>
    <div class="c404">
        <h1 class="error-code">404</h1>
        <p class="message">Oops! The page you're looking for doesn't exists or removed.</p>

        <v-btn class="back-button" link color="warning">
            <a href="/">
                <v-icon>mdi-home</v-icon>
                Go back to home page
            </a>
        </v-btn>
    </div>
</template>

<script>
export default {
    props: {},
}
</script>

<style lang="scss">

.c404 {
    display: flex;
    flex-direction: column;
    align-content: center;
    align-items: center;
    justify-content: center;
    justify-items: center;
    height: 100vh;
    background-color: #04192f;
    color: #fff;
    font-size: 100%;
    line-height: 1.5;

    @media (max-width: 767px) {
        padding: 20px;
    }


    .message {
        display: block;
        font-size: 2em;
        text-align: center;
        font-weight: 100;
    }

    .error-code {
        text-align: center !important;
        font-size: 15em !important;
        font-weight: 100 !important;
        text-shadow: 1px 1px 1px #001f41, 10px 10px 10px #002247, 20px 20px 20px #012753, 30px 30px 30px #012e62;

        @media (max-width: 767px) {
            font-size: 8em !important;;
        }
    }

}


</style>
