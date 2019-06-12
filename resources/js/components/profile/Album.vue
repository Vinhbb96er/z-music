<template>
    <div class="tab-pane active">
        <div class="artist-bio no-margin" v-if="mediaSearch">
            <div class="msl-black">
                <div class="heading3">
                    <h4>
                        <i class="fa fa-music"></i>{{ $t('album.list_album') }}
                    </h4>
                </div>
            </div>
            <div>
                <div class="tab-pane active" v-if="!mediaSearch.data.length">
                    {{ $t('home.no_results') }}
                </div>
                <div class="tab-pane active" v-for="album in mediaSearch.data" :key="album.id" v-else>
                    <div class="album-outer">
                        <!--Music Album List Thumb Start-->
                        <div class="album-list-thumb-outer">
                            <div class="album-list-thumb">
                                <div class="thumb backgroud-image-show" :style="{backgroundImage: `url(${album.cover_image})`}">
                                </div>
                                <div class="title">
                                    <div>
                                        <h5 class="album-name" @click.prevent="addMusicToPlaylist({id: album.id, type: type})" role="button">{{ album.name }}</h5>
                                        <a href="#" @click.prevent class="album-artist" v-if="album.user">{{ album.user.name }}</a>
                                    </div>
                                </div>
                                <div class="album-no">
                                    <div>
                                        <p>{{ album.kinds_text }}</p>
                                    </div>
                                </div>
                                <div class="clic-btn-wrap btn-block">
                                    <div class="music-icon-group">
                                        <router-link @click.stop tag="a" class="mp3-icon" :to="{name: 'albumDetail', params: {id: album.id}}" :title="$t('home.view_detail')">
                                            <i class="fa fa-info"></i>
                                        </router-link>
                                        <template v-if="checkIsAuthUser(id)">
                                            <a href="#" class="mp3-icon" :title="$t('playlist.like')" @click.stop.prevent>
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" class="mp3-icon" :title="$t('playlist.remove')" @click.stop.prevent>
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </template>
                                        <template v-else>
                                            <a href="#" class="mp3-icon" :title="$t('playlist.like')" @click.stop.prevent>
                                                <i class="fa fa-heart-o"></i>
                                            </a>
                                        </template>
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
                        </div>
                        <!--Music Album List Thumb End-->
                    </div>
                </div>
                <pagination :pageData="mediaSearch" :loadPageFunc="loadAlbum"></pagination>
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
                type: window.Laravel.setting.album.media_type,
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
                },
                id: this.$route.params.id,
                size: 5
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
            loadAlbum(page) {
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
    .user-detail .album-play-list {
        display: none;
    }

    .user-detail .album-name {
        width: 380px;
    }

    .user-detail .album-list-thumb > .album-no,
    .user-detail .album-list-thumb > .clic-btn-wrap {
        min-width: 45px;
    }

    .user-detail .btn-block {
        min-width: 115px;
    }
</style>


