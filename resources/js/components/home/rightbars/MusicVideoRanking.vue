<template>
    <div class="widget widget-recent-post video-ranking-element" v-if="videoRanking.data">
        <!--Heading Start-->
        <div class="msl-black">
            <div class="msl-heading light-color ranking-header-title">
                <h5>
                    <span>
                        <router-link tag="a" :to="{name: 'videoRanking'}">{{ $t('music_video.video_ranking') }}</router-link>
                    </span>
                </h5>
            </div>
        </div>
        <!--Heading End-->
        <!--Featured Thumb List Start-->
        <router-link class="msl-featured-thumb video-list-thumb" tag="div" :to="{name: 'videoDetail', params: {id: videoRanking.data[0].id}}">
            <figure>
                <img src="#" class="backgroud-image-show" :style="{backgroundImage: `url(${videoRanking.data[0].cover_image})`}">
                <a class="video-play" href="#"><i class="icon-multimedia-1"></i></a>
                <span class="number">1</span>
                <div class="text">
                    <!--Featured Title Start-->
                    <h4 class="featured-title">
                        <router-link tag="a" :to="{name: 'videoDetail', params: {id: videoRanking.data[0].id}}">
                            {{ videoRanking.data[0].name }}
                        </router-link>
                    </h4>
                    <!--Featured Title End-->
                    <!--Featured Meta Start-->
                    <div class="blog-post-meta">
                        <div class="blog-info blog-admin">
                            <router-link tag="a" :to="{name: 'profileShow', params: {id: videoRanking.data[0].user.id}}">
                                {{ videoRanking.data[0].user.name }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </figure>
        </router-link>
        <div class="featured-thumb-list-wrap">
            <!--Featured Thumb Start-->
            <router-link class="msl-featured-thumb featured-thumb-list" v-for="(video, index) in videoRankingSlice" tag="div" :to="{name: 'videoDetail', params: {id: video.id}}" :key="video.id">
                <figure>
                    <img src="#" class="backgroud-image-show" :style="{backgroundImage: `url(${video.cover_image})`}">
                    <a class="video-play" href="#"><i class="icon-multimedia-1"></i></a>
                    <span class="number">{{ index + 2 }}</span>
                </figure>
                <div class="text">
                    <!--Featured Title Start-->
                    <h4 class="featured-title">
                        <router-link tag="a" :to="{name: 'videoDetail', params: {id: video.id}}">
                            {{ video.name }}
                        </router-link>
                    </h4>
                    <!--Featured Title End-->
                    <!--Featured Meta Start-->
                    <div class="blog-post-meta">
                        <div class="blog-info blog-admin">
                            <router-link tag="a" :to="{name: 'profileShow', params: {id: video.user.id}}">
                                {{ video.user.name }}
                            </router-link>
                        </div>
                    </div>
                    <!--Featured Meta End-->
                </div>
            </router-link>
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
                return this.videoRanking.data.slice(1);
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
