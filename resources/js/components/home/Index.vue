<template>
    <div>
        <home-slider></home-slider>
        <div>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <home-new-album></home-new-album>
                        </div>
                        <div class="col-md-4">
                            <aside>
                                <home-ranking></home-ranking>
                                <home-playlist></home-playlist>

                                <div class="widget widget-recent-post">
                                    <!--Heading Start-->
                                    <div class="msl-black">
                                        <div class="msl-heading light-color">
                                            <h5><span>Recent Post</span></h5>
                                        </div>
                                    </div>
                                    <!--Heading End-->
                                    <!--Featured Thumb List Start-->
                                    <div class="featured-thumb-list-wrap">
                                        <!--Featured Thumb Start-->
                                        <div class="msl-featured-thumb featured-thumb-list">
                                            <figure>
                                                <img alt="KODEFOREST" src="extra-images/smal-thumb6.jpg">
                                            </figure>
                                            <div class="text">
                                                <!--Featured Title Start-->
                                                <h4 class="featured-title">
                                                    <a href="#">Dolly Parton duets with Kesha for album</a>
                                                </h4>
                                                <!--Featured Title End-->
                                                <!--Featured Meta Start-->
                                                <div class="blog-post-meta">
                                                    <div class="blog-info">
                                                        <span>26 July, 2018</span>
                                                    </div>
                                                </div>
                                                <!--Featured Meta End-->
                                            </div>
                                        </div>
                                        <!--Featured Thumb End-->
                                        <!--Featured Thumb Start-->
                                        <div class="msl-featured-thumb featured-thumb-list">
                                            <figure>
                                                <img alt="KODEFOREST" src="extra-images/smal-thumb7.jpg">
                                            </figure>
                                            <div class="text">
                                                <!--Featured Title Start-->
                                                <h4 class="featured-title">
                                                    <a href="#">Dolly Parton duets with Kesha for album</a>
                                                </h4>
                                                <!--Featured Title End-->
                                                <!--Featured Meta Start-->
                                                <div class="blog-post-meta">
                                                    <div class="blog-info">
                                                        <span>26 July, 2018</span>
                                                    </div>
                                                </div>
                                                <!--Featured Meta End-->
                                            </div>
                                        </div>
                                        <!--Featured Thumb End-->
                                        <!--Featured Thumb Start-->
                                        <div class="msl-featured-thumb featured-thumb-list">
                                            <figure>
                                                <img alt="KODEFOREST" src="extra-images/smal-thumb8.jpg">
                                            </figure>
                                            <div class="text">
                                                <!--Featured Title Start-->
                                                <h4 class="featured-title">
                                                    <a href="#">Dolly Parton duets with Kesha for album</a>
                                                </h4>
                                                <!--Featured Title End-->
                                                <!--Featured Meta Start-->
                                                <div class="blog-post-meta">
                                                    <div class="blog-info">
                                                        <span>26 July, 2018</span>
                                                    </div>
                                                </div>
                                                <!--Featured Meta End-->
                                            </div>
                                        </div>
                                        <!--Featured Thumb End-->

                                    </div>
                                    <!--Featured Thumb List End-->
                                </div>
                                <!--Widget Social Start-->
                                <div class="widget widget-social">
                                    <!--Heading Start-->
                                    <div class="msl-black">
                                        <div class="msl-heading light-color">
                                            <h5><span>Get Connected</span></h5>
                                        </div>
                                    </div>
                                    <!--Heading End-->
                                    <ul class="msl-social">
                                        <li class="fb"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li class="tw"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li class="lkd"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                        <li class="yt"><a href="#"><i class="fa fa-youtube-play"></i></a></li>
                                        <li class="igm"><a href="#"><i class="fa fa-instagram"></i></a></li>
                                        <li class="pst"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                    </ul>
                                </div>
                                <!--Widget Social End-->
                            </aside>
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
    import HomeRanking from './rightbars/Ranking.vue'
    import HomePlaylist from './rightbars/Playlist.vue'

    export default {
        components: {
            HomeSlider,
            HomeNewAlbum,
            HomeRanking,
            HomePlaylist
        }
    }
</script>
<style scoped>

</style>
