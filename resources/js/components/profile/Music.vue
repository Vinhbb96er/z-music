<template>
    <div class="tab-pane active">
        <div class="artist-bio no-margin" v-if="mediaSearch">
            <div class="msl-black">
                <div class="heading3">
                    <h4>
                        <i class="fa fa-music"></i>{{ $t('album.list_song') }}
                        <a href="#" @click.prevent="playAll" class="play-all">
                            <i class="icon-multimedia-1 icon" :title="$t('playlist.play_all')"></i>
                        </a>
                    </h4>
                </div>
            </div>
            <div v-if="mediaSearch">
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
                        <ul>
                            <li v-for="(music, index) in mediaSearch.data" :key="music.id"  @click.prevent="playingMusic({id: music.id, type: type})">
                                <div class="play-list-title">
                                    <img :src="images.music_playing" class="playing-icon" v-if="checkPlayingMusic(music.id)">
                                    <template v-else>
                                        <i class="icon-multimedia-1"></i>
                                        <span class="index">#{{ index + 1 }}</span>
                                    </template>
                                    <h6>{{ music.name }}</h6>
                                </div>
                                <div class="music-icon-group text-right" v-if="checkIsAuthUser(id)">
                                    <router-link @click.stop tag="a" class="mp3-icon" :to="{name: 'musicDetail', params: {id: music.id}}" :title="$t('home.view_detail')">
                                        <i class="fa fa-info"></i>
                                    </router-link>
                                    <a href="#" class="mp3-icon" :title="$t('button.edit')" @click.stop.prevent>
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="#" class="mp3-icon" :title="$t('playlist.remove')" @click.stop.prevent>
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                                <div class="music-icon-group text-right" v-else>
                                    <router-link @click.stop tag="a" class="mp3-icon" :to="{name: 'musicDetail', params: {id: music.id}}" :title="$t('home.view_detail')">
                                        <i class="fa fa-info"></i>
                                    </router-link>
                                    <a href="#" class="mp3-icon" :title="$t('playlist.like')" @click.stop.prevent>
                                        <i class="fa fa-heart-o"></i>
                                    </a>
                                    <a href="#" class="mp3-icon" :title="$t('playlist.download')" @click.stop.prevent>
                                        <i class="fa fa-download"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <pagination :pageData="mediaSearch" :loadPageFunc="loadMusic"></pagination>
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
                id: this.$route.params.id,
                size: 10
            }
        },
        components: {
            Pagination
        },
        watch: {
            '$route'(to, from) {
                this.id = to.params.id ? to.params.id : this.profileData.id;
                this.searchMedia({
                    type: this.type,
                    user: this.id,
                    size: this.size
                });
            }
        },
        computed: {
            ...mapGetters([
                'profileData',
                'checkPlayingMusic',
                'mediaSearch',
                'checkIsAuthUser'
            ])
        },
        methods: {
            ...mapActions(['playingMusic', 'searchMedia', 'addMusicToPlaylist']),
            loadMusic(page) {
                this.searchMedia({
                    type: this.type,
                    user: this.id,
                    size: this.size,
                    page: page
                });
            },
            playAll() {
                let musicIds = [];

                this.mediaSearch.data.forEach((music) => {
                    musicIds.push(music.id);
                });

                this.addMusicToPlaylist({id: musicIds, type: this.type});
            }
        },
        created() {
            if (this.id == undefined) {
                this.id = this.profileData.id;
            }

            this.searchMedia({
                type: this.type,
                user: this.id,
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
</style>
