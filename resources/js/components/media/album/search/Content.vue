<template>
    <div class="album-outer album-search">
        <!--Music Album List Thumb Start-->
        <div class="album-list-thumb-outer" v-for="album in data" :key="album.id">
            <div class="album-list-thumb">
                <div class="thumb backgroud-image-show" :style="{backgroundImage: `url(${album.cover_image})`}">
                </div>
                <div class="title">
                    <div>
                        <h5 class="album-name" @click.prevent="addMusicToPlaylist({id: album.id, type: type})" role="button">{{ album.name }}</h5>
                        <router-link tag="a" :to="{name: 'profileShow', params: {id: album.user.id}}" class="album-artist">
                            {{ album.user.name }}
                        </router-link>
                    </div>
                </div>
                <div class="album-kind">
                    <div>
                        <p>{{ album.kinds_text }}</p>
                    </div>
                </div>
                <div class="album-region">
                    <div>
                        <p>{{ album.region.name }}</p>
                    </div>
                </div>
                <div class="clic-btn-wrap btn-block">
                    <div class="music-icon-group">
                        <router-link @click.stop tag="a" class="mp3-icon" :to="{name: 'albumDetail', params: {id: album.id}}" :title="$t('home.view_detail')">
                            <i class="fa fa-info"></i>
                        </router-link>
                        <a href="#" class="mp3-icon" :title="$t('playlist.like')" @click.stop.prevent>
                            <i class="fa fa-heart-o"></i>
                        </a>
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
                            <a href="#" class="mp3-icon" :title="$t('playlist.like')" @click.stop.prevent>
                                <i class="fa fa-heart-o"></i>
                            </a>
                            <a href="#" class="mp3-icon" :title="$t('playlist.download')" @click.prevent="downloadMedia(music.id)">
                                <i class="fa fa-download"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!--Music Album List Thumb End-->
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                type: window.Laravel.setting.album.media_type,
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
                }
            }
        },
        props: {
            data: {
                required: true,
                type: Array
            },
        },
        computed: {
            ...mapGetters(['checkPlayingMusic'])
        },
        methods: {
            ...mapActions(['downloadMedia', 'playingMusic', 'addMusicToPlaylist'])
        }
    }
</script>
<style scoped>
    .album-search {
        margin-bottom: 10px;
    }

    .album-search .album-list-thumb-outer:last-child {
        margin-bottom: 0;
    }

    .album-search .album-list-thumb .title {
        width: 50%;
    }

    .album-search .album-list-thumb .album-kind {
        width: 15%;
        text-align: center;
    }

    .album-search .album-list-thumb .album-region {
        width: 12%;
        text-align: center;
    }

    .album-search .album-list-thumb .clic-btn-wrap {
        min-width: 25px !important;
        width: 25px;
    }

    .album-search .album-list-thumb .btn-block {
        width: 70px;
        text-align: center;
    }

    .album-search .album-play-list {
        height: 236px;
    }
</style>
