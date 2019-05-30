<template>
    <div class="tab-pane active">
        <!--Music Album Inner Wrap Start-->
        <div class="album-inner">
            <!--Music Album Inner Nav Start-->
            <h4 class="heading-2 media-header-title">
                <a href="#">
                    {{ $t('music_video.video_new') }} <i class="fa fa-angle-right"></i>
                </a>
            </h4>
            <ul class="nav-tabs msl-tab-nav">
                <li class="region-title" @click.prevent="region = 0" :class="{active: region == 0}">
                    <a href="#">{{ $t('home.selective') }}</a>
                </li>
                <li v-for="popularRegion in popularRegions" :key="popularRegion.id" class="region-title" @click.prevent="region = popularRegion.id"
                    :class="{active: region == popularRegion.id}">
                    <a href="#">{{ popularRegion.name }}</a>
                </li>
            </ul>
            <!--Music Album Inner Nav End-->
            <div class="grid-container">
                <router-link class="grid-item" v-for="video in mediaNewSlice.largeItem" tag="div" :to="{name: 'videoDetail', params: {id: video.id}}" :key="video.id">
                    <div class="msl-featured-thumb video-list-thumb">
                        <figure>
                            <img src="#" :style="{backgroundImage: `url(${video.cover_image})`}">
                            <a class="video-play" href="#"><i class="icon-multimedia-1"></i></a>
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
                            </div>
                        </figure>
                    </div>
                </router-link>
            </div>
            <div class="grid-container-small">
                <router-link class="grid-item" v-for="video in mediaNewSlice.smallItem" tag="div" :to="{name: 'videoDetail', params: {id: video.id}}" :key="video.id">
                    <div class="msl-featured-thumb video-list-thumb">
                        <figure>
                            <img src="#" :style="{backgroundImage: `url(${video.cover_image})`}">
                            <a class="video-play" href="#"><i class="icon-multimedia-1"></i></a>
                        </figure>
                        <div class="text">
                            <h4 class="featured-title" :title="video.name">
                                <router-link tag="a" :to="{name: 'videoDetail', params: {id: video.id}}">
                                    {{ video.name }}
                                </router-link>
                            </h4>
                            <div class="blog-info blog-admin" :title="video.user.name">
                                <router-link tag="a" :to="{name: 'profileShow', params: {id: video.user.id}}">
                                    {{ video.user.name }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                type: window.Laravel.setting.media.type.video,
                region: 0,
                size: window.Laravel.setting.media_filter_size.video
            }
        },
        computed: {
            ...mapGetters(['popularRegions', 'mediaNew']),
            mediaNewSlice() {
                return {
                    largeItem: this.mediaNew.slice(0, 2),
                    smallItem: this.mediaNew.slice(2)
                }
            }
        },
        watch: {
            region() {
                this.getMediaNew({
                    type: this.type,
                    region: this.region,
                    size: this.size
                });
            }
        },
        methods: {
            ...mapActions(['getMediaNew'])
        },
        created() {
            this.getMediaNew({
                type: this.type,
                region: this.region,
                size: this.size
            });
        }
    }
</script>
<style>

</style>
