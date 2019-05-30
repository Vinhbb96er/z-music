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
        <app-login-register></app-login-register>
        <app-playlist></app-playlist>
        <div class="clear"></div>
        <div id="block-message"></div>
        <div class="modal fade in" id="process-loader">
            <section>
                <div class="loading-spiner"></div>
            </section>
        </div>
    </div>
</template>
<script>
    import AppHeader from './partials/Header.vue'
    import AppFooter from './partials/Footer.vue'
    import AppPlaylist from '../playlist/Index.vue'
    import AppLoginRegister from './partials/LoginRegister.vue'

    export default {
        components: {
            AppHeader,
            AppFooter,
            AppPlaylist,
            AppLoginRegister
        }
    }
</script>
<style scoped>

</style>
