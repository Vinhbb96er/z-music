<template>
    <div class="widget widget-recent-post video-ranking-element">
        <!--Heading Start-->
        <div class="msl-black">
            <div class="msl-heading light-color ranking-header-title">
                <h5>
                    <span>
                        <a href="#">
                            {{ $t('music_video.video_ranking') }}
                        </a>
                    </span>
                </h5>
            </div>
        </div>
        <!--Heading End-->
        <!--Featured Thumb List Start-->
        <div class="msl-featured-thumb video-list-thumb" v-if="videoRanking.length">
            <figure>
                <img src="#" class="backgroud-image-show" :style="{backgroundImage: `url(${videoRanking[0].cover_image})`}">
                <a class="video-play" href="#"><i class="icon-multimedia-1"></i></a>
                <span class="number">1</span>
                <div class="text">
                    <!--Featured Title Start-->
                    <h4 class="featured-title">
                        <a href="#">{{ videoRanking[0].name }}</a>
                    </h4>
                    <!--Featured Title End-->
                    <!--Featured Meta Start-->
                    <div class="blog-post-meta">
                        <div class="blog-info blog-admin">
                            <a href="#">{{ videoRanking[0].user.name }}on</a>
                        </div>
                    </div>
                </div>
            </figure>
        </div>
        <div class="featured-thumb-list-wrap">
            <!--Featured Thumb Start-->
            <div class="msl-featured-thumb featured-thumb-list" v-for="(video, index) in videoRankingSlice">
                <figure>
                    <img src="#" class="backgroud-image-show" :style="{backgroundImage: `url(${video.cover_image})`}">
                    <a class="video-play" href="#"><i class="icon-multimedia-1"></i></a>
                    <span class="number">{{ index + 2 }}</span>
                </figure>
                <div class="text">
                    <!--Featured Title Start-->
                    <h4 class="featured-title">
                        <a href="#">{{ video.name }}</a>
                    </h4>
                    <!--Featured Title End-->
                    <!--Featured Meta Start-->
                    <div class="blog-post-meta">
                        <div class="blog-info blog-admin">
                            <a href="#">{{ video.user.name }}</a>
                        </div>
                    </div>
                    <!--Featured Meta End-->
                </div>
            </div>
            <!--Featured Thumb End-->
        </div>
        <!--Featured Thumb List End-->
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                type: window.Laravel.setting.media.type.video,
                size: 5
            };
        },
        computed: {
            ...mapGetters(['videoRanking']),
            videoRankingSlice() {
                return this.videoRanking.slice(1);
            }
        },
        methods: {
            ...mapActions(['getVideoRanking'])
        },
        created() {
            this.getVideoRanking({
                type: this.type,
                size: this.size
            });
        }
    }
</script>
<style scoped>

</style>
