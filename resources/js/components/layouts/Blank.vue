<template>
    <div>
        <!--Loader Wrapper Start-->
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <div class="kode_wrapper">
            <app-header></app-header>
            <router-view></router-view>
            <app-footer></app-footer>
        </div>
    </div>
</template>
<script>
    import AppHeader from './partials/Header.vue'
    import AppFooter from './partials/Footer.vue'

    export default {
        components: {
            AppHeader,
            AppFooter,
        }
    }
</script>
<style scoped>

</style>
