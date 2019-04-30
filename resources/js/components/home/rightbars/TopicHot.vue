<template>
    <div class="widget widget-artist">
        <!--Heading Start-->
        <div class="msl-black">
            <div class="msl-heading light-color ranking-header-title">
                <h5>
                    <span>
                        <a href="#">
                            {{ $t('home.topic_hot') }}
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </span>
                </h5>
            </div>
        </div>
        <!--Heading End-->
        <!--Artist Rank List Start-->
        <div class="topic-hot-element">
            <div class="card-group">
                <div class="card-item">
                    <a href="#">
                        <figure class="backgroud-image-show" style="background-image: url(/frontend/images/region_kind/rock_bg.jpg);">
                            <span class="card-gradient-background gradient-background-1"></span>
                        </figure>
                        <h4 class="card-title">Hôm nay nghe gì</h4>
                    </a>
                </div>
                <div class="card-item no-padding">
                    <a href="#">
                        <figure class="backgroud-image-show" style="background-image: url(/frontend/images/region_kind/rock_bg.jpg);">
                            <span class="card-gradient-background gradient-background-2"></span>
                        </figure>
                        <h4 class="card-title">Acoustic</h4>
                    </a>
                </div>
                <div class="card-item no-padding">
                    <a href="#">
                        <figure class="backgroud-image-show" style="background-image: url(/frontend/images/region_kind/rock_bg.jpg);">
                            <span class="card-gradient-background gradient-background-3"></span>
                        </figure>
                        <h4 class="card-title">Nhạc vàng bất hủ</h4>
                    </a>
                </div>
                <div class="card-item no-padding">
                    <a href="#">
                        <figure class="backgroud-image-show" style="background-image: url(/frontend/images/region_kind/rock_bg.jpg);">
                            <span class="card-gradient-background gradient-background-4"></span>
                        </figure>
                        <h4 class="card-title">EDM</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {

    }
</script>
<style>

</style>
