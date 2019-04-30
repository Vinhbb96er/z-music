<template>
    <div>
        <home-slider></home-slider>
        <div>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <home-new-album></home-new-album>
                            <home-media-hot></home-media-hot>
                            <home-media-new></home-media-new>
                            <home-region-and-kind></home-region-and-kind>
                        </div>
                        <div class="col-md-4">
                            <home-rightbar></home-rightbar>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <home-highlight-artist></home-highlight-artist>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
    import HomeSlider from './Slider.vue'
    import HomeNewAlbum from './NewAlbum.vue'
    import HomeRightbar from './rightbars/Index.vue'
    import HomeMediaHot from './media_hot/Index.vue'
    import HomeMediaNew from './media_new/Index.vue'
    import HomeRegionAndKind from './RegionAndKind.vue'
    import HomeHighlightArtist from './HighlightArtist.vue'

    export default {
        components: {
            HomeSlider,
            HomeNewAlbum,
            HomeRightbar,
            HomeMediaHot,
            HomeMediaNew,
            HomeRegionAndKind,
            HomeHighlightArtist
        }
    }
</script>
<style scoped>

</style>
