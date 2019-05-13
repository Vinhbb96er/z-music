<template>
    <div class="tab-pane active">
        <!--Music Album Inner Wrap Start-->
        <div class="album-inner">
            <!--Music Album Inner Nav Start-->
            <h4 class="heading-2 media-header-title">
                <a href="#">
                    {{ $t('album.album_new') }} <i class="fa fa-angle-right"></i>
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
            <div class="tab-content">
                <div class="tab-pane active" v-for="album in mediaNew" :key="album.id">
                    <div class="album-outer">
                        <!--Music Album List Thumb Start-->
                        <div class="album-list-thumb-outer">
                            <div class="album-list-thumb">
                                <div class="thumb" :style="{backgroundImage: `url(${album.cover_image})`}">
                                </div>
                                <div class="title">
                                    <div>
                                        <h5 class="album-name" @click.prevent="addMusicToPlaylist({id: album.id, type: type})" role="button">{{ album.name }}</h5>
                                        <a href="#" class="album-artist">{{ album.user.name }}</a>
                                    </div>
                                </div>
                                <div class="album-no">
                                    <div>
                                        <p>{{ album.kinds_text }}</p>
                                    </div>
                                </div>
                                <div class="clic-btn-wrap">
                                    <div class="music-icon-group">
                                        <router-link @click.stop tag="a" class="mp3-icon" :to="{name: 'albumDetail', params: {id: album.id}}" :title="$t('home.view_detail')">
                                            <i class="fa fa-info"></i>
                                        </router-link>
                                    </div>
                                </div>
                                <div class="clic-btn-wrap">
                                    <div class="clic-btn">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="album-play-list">
                                <ul>
                                    <li v-for="(music, index) in album.media" :key="music.id"  @click.prevent="playingMusic({id: music.id, type: music_type})">
                                        <div class="play-list-title">
                                            <img :src="images.music_playing" class="playing-icon" v-if="checkPlayingMusic(music.id)">
                                            <template v-else>
                                                <i class="icon-multimedia-1"></i>
                                                <span class="index">#{{ index + 1 }}</span>
                                            </template>
                                            <h6>{{ music.name }}</h6>
                                        </div>
                                        <div class="music-icon-group text-right">
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
                        <!--Music Album List Thumb End-->
                    </div>
                </div>
            </div>
        </div>
        <!--Music Album Inner Wrap End-->
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                type: window.Laravel.setting.album.media_type,
                music_type: window.Laravel.setting.media.type.music,
                region: 0,
                size: window.Laravel.setting.media_filter_size.album,
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
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
        computed: {
            ...mapGetters(['popularRegions', 'mediaNew', 'checkPlayingMusic'])
        },
        methods: {
            ...mapActions(['getMediaNew', 'addMusicToPlaylist', 'playingMusic'])
        },
        created() {
            this.getMediaNew({
                type: this.type,
                region: this.region,
                size: this.size
            });
        },
    }
</script>
<style>

</style>
