<template>
    <div class="tab-pane active">
        <!--Music Album Inner Wrap Start-->
        <div class="album-inner">
            <!--Music Album Inner Nav Start-->
            <h4 class="heading-2 media-header-title">
                <a href="#">
                    {{ $t('music.music_new') }} <i class="fa fa-angle-right"></i>
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
            <div class="mp3-list-wrap">
                <ul class="mp3-list-table">
                    <li v-for="music in mediaNew" :key="music.id" @click.prevent="playingMusic({id: music.id, type: type})">
                        <div class="mp3-title">
                            <div class="mp3-playlist-item-cover" :class="{playing: checkPlayingMusic(music.id)}">
                                <span class="img-holder" :style="{backgroundImage: `url(${music.cover_image})`}">
                                    <span class="circle"></span>
                                </span>
                            </div>
                        </div>
                        <div>
                            <h6 class="music-name">
                                <a href="#">{{ music.name }}</a>
                            </h6>
                            <a href="#" class="artist-name">{{ music.user.name }}</a>
                        </div>
                        <div class="music-icon-group">
                            <i class="music-playing-icon icon-play-button" v-if="!checkPlayingMusic(music.id)"></i>
                            <router-link @click.stop tag="a" class="mp3-icon" :to="{name: 'musicDetail', params: {id: music.id}}" :title="$t('home.view_detail')">
                                <i class="fa fa-info"></i>
                            </router-link>
                            <a href="#" class="mp3-icon" :title="$t('playlist.download')" @click.stop.prevent>
                                <i class="fa fa-download"></i>
                            </a>
                        </div>
                    </li>
                </ul>
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
                type: window.Laravel.setting.media.type.music,
                region: 0,
                size: window.Laravel.setting.media_filter_size.music,
            }
        },
        computed: {
            ...mapGetters(['popularRegions', 'mediaNew', 'checkPlayingMusic'])
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
            ...mapActions(['getMediaNew', 'playingMusic'])
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
