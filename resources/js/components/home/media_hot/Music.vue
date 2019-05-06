<template>
    <div class="tab-pane active">
        <!--Music Album Inner Wrap Start-->
        <div class="album-inner">
            <!--Music Album Inner Nav Start-->
            <h4 class="heading-2 media-header-title">
                <a href="#">
                    {{ $t('music.music_hot') }} <i class="fa fa-angle-right"></i>
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
                    <li v-for="music in mediaHot" :key="music.id">
                        <div class="mp3-title">
                            <div class="mp3-playlist-item-cover">
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
                            <a class="mp3-icon" href="#" @click.prevent="addMusicToPlaylist({id: music.id, type: type})">
                                <i class="icon-play-button"></i>
                            </a>
                            <a class="mp3-icon" href="#"><i class="fa fa-info"></i></a>
                            <a class="mp3-icon" href="#"><i class="icon-music-1"></i></a>
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
            ...mapGetters(['popularRegions', 'mediaHot'])
        },
        watch: {
            region() {
                this.getMediaHot({
                    type: this.type,
                    region: this.region,
                    size: this.size
                });
            }
        },
        methods: {
            ...mapActions(['getMediaHot', 'addMusicToPlaylist'])
        },
        created() {
            this.getMediaHot({
                type: this.type,
                region: this.region,
                size: this.size
            });
        }
    }
</script>
<style>

</style>
