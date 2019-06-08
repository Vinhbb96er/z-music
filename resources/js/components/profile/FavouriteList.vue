<template>
    <div class="tab-pane active">
        <div class="artist-bio no-margin" v-if="favouriteList">
            <div class="msl-black">
                <div class="heading3">
                    <h4>
                        <i class="fa fa-music"></i>Danh sách bài hát yêu thích
                        <a href="#" @click.prevent="playAll" class="play-all">
                            <i class="icon-multimedia-1 icon" :title="$t('playlist.play_all')"></i>
                        </a>
                    </h4>
                </div>
            </div>
            <div v-if="favouriteList">
                <div class="album-list-thumb-outer">
                    <div class="album-play-list album-header">
                        <ul>
                            <li>
                                <div class="play-list-title">
                                    <i class="icon-multimedia-1"></i> <span class="index">#</span>
                                    <h6>{{ $t('media.song_name') }}</h6>
                                </div>
                                <div class="music-icon-group text-center">
                                    <h6>{{ $t('media.action') }}</h6>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="album-play-list">
                        <ul v-if="favouriteList.total">
                            <li v-for="(music, index) in favouriteList.data" :key="music.id"  @click.prevent="playingMusic({id: music.id, type: type})">
                                <div class="play-list-title">
                                    <img :src="images.music_playing" class="playing-icon" v-if="checkPlayingMusic(music.id)">
                                    <template v-else>
                                        <i class="icon-multimedia-1"></i>
                                        <span class="index">#{{ index + 1 }}</span>
                                    </template>
                                    <h6>
                                        {{ music.name }}
                                        <p>{{ music.user.name }}</p>
                                    </h6>

                                </div>
                                <div class="music-icon-group text-right">
                                    <router-link @click.stop tag="a" class="mp3-icon" :to="{name: 'musicDetail', params: {id: music.id}}" :title="$t('home.view_detail')">
                                        <i class="fa fa-info"></i>
                                    </router-link>
                                    <a href="#" class="mp3-icon" :title="$t('playlist.like')" @click.stop.prevent>
                                        <i class="fa fa-heart-o"></i>
                                    </a>
                                    <a href="#" class="mp3-icon" :title="$t('playlist.remove')" @click.stop.prevent="removeFavouriteList(music.id)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <div class="no-result" v-else>
                            {{ $t('home.no_results') }}
                        </div>
                    </div>
                    <pagination :pageData="favouriteList" :loadPageFunc="loadMusic"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    import Pagination from '../layouts/partials/Pagination.vue'

    export default {
        data() {
            return {
                type: window.Laravel.setting.media.type.music,
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
                },
                size: 10
            }
        },
        components: {
            Pagination
        },
        computed: {
            ...mapGetters([
                'profileData',
                'checkPlayingMusic',
                'favouriteList',
                'checkIsAuthUser'
            ])
        },
        methods: {
            ...mapActions(['playingMusic', 'getFavouriteList', 'addMusicToPlaylist', 'downloadMedia', 'removeFavouriteList']),
            loadMusic(page) {
                this.getFavouriteList({
                    size: this.size,
                    page: page
                });
            },
            playAll() {
                let musicIds = [];

                this.favouriteList.data.forEach((music) => {
                    musicIds.push(music.id);
                });

                this.addMusicToPlaylist({id: musicIds, type: this.type});
            }
        },
        created() {
            this.getFavouriteList({
                size: this.size
            });
        }
    }
</script>
<style scoped>
    .play-all .icon {
        font-size: 22px;
        font-weight: bold;
        color: #fff !important;
        line-height: 0;
        top: 2px;
        margin-left: 5px;
    }

    .play-all:hover .icon {
        color: #db152e !important;
    }

    .album-play-list:not(.album-header) .play-list-title .index,
    .play-list-title .icon-multimedia-1 {
        margin-top: 10px !important;
    }

    .play-list-title h6 p {
        margin-bottom: 0;
    }

    .no-result {
        padding: 30px;
        text-align: center;
    }
</style>
