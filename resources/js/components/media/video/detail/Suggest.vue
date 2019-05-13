<template>
    <div class="widget widget-recent-post video-ranking-element no-padding no-border">
        <!--Heading Start-->
        <div class="msl-black">
            <div class="msl-heading light-color ranking-header-title">
                <h5>
                    <span>{{ $t('home.maybe_you_interested') }}</span>
                </h5>
            </div>
        </div>
        <!--Heading End-->
        <!--Featured Thumb List Start-->
        <div class="featured-thumb-list-wrap">
            <!--Featured Thumb Start-->
            <router-link class="msl-featured-thumb featured-thumb-list" v-for="video in mediaSuggest" :key="video.id" tag="a" :to="{name: 'videoDetail', params: {id: video.id}}">
                <figure>
                    <img src="#" class="backgroud-image-show" :style="{backgroundImage: `url(${video.cover_image})`}">
                    <a class="video-play" href="#" @click.prevent>
                        <i class="icon-multimedia-1"></i>
                    </a>
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
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
                }
            };
        },
        computed: {
            ...mapGetters(['mediaSuggest'])
        },
        methods: {
            ...mapActions(['playingMusic'])
        }
    }
</script>
<style scoped>

</style>
