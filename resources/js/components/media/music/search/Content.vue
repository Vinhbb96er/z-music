<template>
    <ul class="mp3-list-table music-search">
        <li v-for="music in data" :key="music.id" @click.prevent="playingMusic({id: music.id, type: type})">
            <div class="mp3-title">
                <div class="mp3-playlist-item-cover" :class="{playing: checkPlayingMusic(music.id)}">
                    <span class="img-holder" :style="{backgroundImage: `url(${music.cover_image})`}">
                        <span class="circle"></span>
                    </span>
                </div>
            </div>
            <div class="song-info">
                <h6 class="music-name">
                    <a href="#" @click.prevent>{{ music.name }}</a>
                </h6>
                <a href="#" @click.prevent class="artist-name">{{ music.user.name }}</a>
            </div>
            <div class="song-kind">
                <h6>
                    {{ music.kinds_text }}
                </h6>
            </div>
            <div class="song-region">
                <h6>
                    {{ music.region.name }}
                </h6>
            </div>
            <div class="music-icon-group">
                <i class="music-playing-icon icon-play-button" v-if="!checkPlayingMusic(music.id)"></i>
                <router-link @click.stop tag="a" class="mp3-icon" :to="{name: 'musicDetail', params: {id: music.id}}" :title="$t('home.view_detail')">
                    <i class="fa fa-info"></i>
                </router-link>
                <a href="#" class="mp3-icon" :title="$t('playlist.download')" @click.prevent="downloadMedia(music.id)">
                    <i class="fa fa-download"></i>
                </a>
            </div>
        </li>
    </ul>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                type: window.Laravel.setting.media.type.music
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
            ...mapActions(['downloadMedia', 'playingMusic'])
        }
    }
</script>
<style scoped>
    .music-search .mp3-list-table .song-info {
        width: 55%;
    }

    .music-search .mp3-list-table .song-kind {
        width: 15%;
    }

    .music-search .mp3-list-table .song-region {
        width: 10%;
    }
</style>
