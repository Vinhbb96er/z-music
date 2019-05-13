<template>
    <div class="media-detail">
        <div class="msl-banner2" v-if="album" :style="{backgroundImage: `url('${album.cover_image}')`}">
            <div class="container">
                <div class="artist-banner">
                    <div class="artist-banner-thumb">
                        <figure class="backgroud-image-show" :style="{backgroundImage: `url('${album.cover_image}')`}">
                            <img :src="images.music_playing" class="playing-icon" v-if="checkPlayingMusicInAlbum(album.id)">
                        </figure>
                        <div class="text-overflow">
                            <h5>{{ album.name }}</h5>
                            <h6>
                                <a href="#">{{ album.user.name }}</a>
                            </h6>
                            <p v-if="album.kinds_text">{{ $t('home.kind') }}: {{ album.kinds_text }}</p>
                            <p v-if="album.region">{{ $t('home.region') }}: <a href="#">{{ album.region.name }}</a></p>
                        </div>
                    </div>
                    <div class="following-wrap">
                        <div class="music-view-like">
                            <span>
                                <i class="fa fa-play-circle-o play-icon"></i>
                                {{ album.views }}
                            </span>
                            <span>
                                <i class="fa fa-heart like-icon"></i>
                                {{ album.likes_count }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="action-group">
                    <a class="btn-1 theme-bg" href="#" @click.prevent="pauseMusic" v-if="checkPlayingMusicInAlbum(id)">
                        <i class="fa fa-pause"></i>{{ $t('playlist.pause') }}
                    </a>
                    <a class="btn-1 theme-bg" href="#" @click.prevent="playAlbum" v-else>
                        <i class="fa fa-play"></i>{{ $t('playlist.play') }}
                    </a>
                    <a class="btn-1 theme-bg" href="#"><i class="fa fa-heart-o"></i>{{ $t('playlist.like') }}</a>
                    <a class="btn-1 theme-bg" href="#"><i class="fa fa-plus"></i>{{ $t('playlist.add_my_favourite') }}</a>
                    <a class="btn-1 theme-bg" href="#"><i class="fa fa-flag-o"></i>{{ $t('playlist.report') }}</a>
                </div>
                <!--Music Album Wrap Start-->
            </div>
            <div class="music-album-wrap">
                <div class="container">
                    <ul class="nav-tabs music-album-nav">
                        <li @click.prevent="tabName = 'AlbumDescription'" :class="{active: tabName == 'AlbumDescription'}">
                            <a href="#" >{{ $t('media.description') }}</a>
                        </li>
                        <li @click.prevent="tabName = 'AlbumComment'" :class="{active: tabName == 'AlbumComment'}">
                            <a href="#">{{ $t('media.comments') }}</a>
                        </li>
                    </ul>
                </div>
                <!--Music Album Wrap End-->
            </div>
        </div>
        <div class="kode_content_wrap">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="tab-content">
                                <keep-alive>
                                    <components :is="tabName"></components>
                                </keep-alive>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <music-suggest></music-suggest>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    import AlbumDescription from './Description.vue'
    import AlbumComment from './Comment.vue'
    import MusicSuggest from './Suggest.vue'

    export default {
        data() {
            return {
                tabName: 'AlbumDescription',
                type: {
                    album: window.Laravel.setting.album.media_type,
                    music: window.Laravel.setting.media.type.music
                },
                id: this.$route.params.id,
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
                }
            }
        },
        components: {
            AlbumDescription,
            AlbumComment,
            MusicSuggest
        },
        watch: {
            '$route'(to, from) {
                this.id = to.params.id;

                this.getMediaDetail({
                    type: this.type.album,
                    id: this.id
                })
            }
        },
        computed: {
            ...mapGetters({
                album: 'mediaDetailData',
                checkPlayingMusic: 'checkPlayingMusic',
            })
        },
        methods: {
            ...mapActions(['getMediaDetail', 'pauseMusic', 'addMusicToPlaylist']),
            checkPlayingMusicInAlbum() {
                let check = false;

                this.album.media.forEach((music) => {
                    if (this.checkPlayingMusic(music.id)) {
                        check = true;

                        return;
                    }
                });

                return check;
            },
            playAlbum() {
                let musicIds = [];

                this.album.media.forEach((music) => {
                    musicIds.push(music.id);
                });

                this.addMusicToPlaylist({
                    type: this.type.music,
                    id: musicIds
                });
            }
        },
        created() {
            this.getMediaDetail({
                type: this.type.album,
                id: this.id
            })
        }
    }
</script>
<style scoped>

</style>
