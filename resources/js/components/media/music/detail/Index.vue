<template>
    <div class="media-detail">
        <div class="msl-banner2" v-if="music" :style="{backgroundImage: `url('${music.cover_image}')`}">
            <div class="container">
                <div class="artist-banner">
                    <div class="artist-banner-thumb">
                        <figure class="backgroud-image-show" :style="{backgroundImage: `url('${music.cover_image}')`}">
                            <img :src="images.music_playing" class="playing-icon" v-if="checkPlayingMusic(music.id)">
                        </figure>
                        <div class="text-overflow">
                            <h5>{{ music.name }}</h5>
                            <h6>
                                <router-link tag="a" :to="{name: 'profileShow', params: {id: music.user.id}}">
                                    {{ music.user.name }}
                                </router-link>
                            </h6>
                            <p v-if="music.album">
                                {{ $t('album.name') }}:
                                <router-link tag="a" :to="{name: 'albumDetail', params: {id: music.album.id}}">{{ music.album.name }}</router-link>
                            </p>
                            <p v-if="music.kinds_text">{{ $t('home.kind') }}: {{ music.kinds_text }}</p>
                            <p v-if="music.region">{{ $t('home.region') }}: <a href="#">{{ music.region.name }}</a></p>
                        </div>
                    </div>
                    <div class="following-wrap">
                        <div class="music-view-like">
                            <span>
                                <i class="fa fa-play-circle-o play-icon"></i>
                                {{ music.views }}
                            </span>
                            <span>
                                <i class="fa fa-heart like-icon"></i>
                                {{ music.likes_count }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="action-group">
                    <a class="btn-1 theme-bg" href="#" @click.prevent="pauseMusic" v-if="checkPlayingMusic(id)">
                        <i class="fa fa-pause"></i>{{ $t('playlist.pause') }}
                    </a>
                    <a class="btn-1 theme-bg" href="#" @click.prevent="playingMusic({id: id, type: type})" v-else>
                        <i class="fa fa-play"></i>{{ $t('playlist.play') }}
                    </a>
                    <a class="btn-1 theme-bg" href="#" @click.prevent="likeMedia({id: id, type: type})" v-if="!user || !checkLiked(id, user.like_data.media)">
                        <i class="fa fa-heart-o"></i>{{ $t('playlist.like') }}
                    </a>
                    <a class="btn-1 btn-liked" v-else href="#" @click.prevent="likeMedia({id: id, type: type})">
                        <i class="fa fa-heart"></i>{{ $t('playlist.liked') }}
                    </a>
                    <a class="btn-1 theme-bg" href="#" @click.prevent="downloadMedia(id)">
                        <i class="fa fa-download"></i>{{ $t('playlist.download') }}
                    </a>
                    <a class="btn-1 theme-bg" href="#" @click.prevent="addFavouriteList(id)"><i class="fa fa-plus"></i>{{ $t('playlist.add_my_favourite') }}</a>
                    <a class="btn-1 theme-bg" role="button" data-toggle="modal" data-target="#report-form">
                        <i class="fa fa-flag-o"></i>{{ $t('playlist.report') }}</a>
                </div>
                <!--Music Album Wrap Start-->
            </div>
            <div class="music-album-wrap">
                <div class="container">
                    <ul class="nav-tabs music-album-nav">
                        <li @click.prevent="tabName = 'MusicDescription'" :class="{active: tabName == 'MusicDescription'}">
                            <a href="#" >{{ $t('media.description') }}</a>
                        </li>
                        <li @click.prevent="tabName = 'MusicComment'" :class="{active: tabName == 'MusicComment'}">
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
        <report-form :reportFunc="reportFunc"></report-form>
    </div>
</template>
<script>
    import MusicDescription from './Description.vue'
    import MusicComment from './Comment.vue'
    import MusicSuggest from './Suggest.vue'
    import ReportForm from './../../../layouts/partials/ReportForm.vue'

    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                tabName: 'MusicDescription',
                type: window.Laravel.setting.media.type.music,
                id: this.$route.params.id,
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
                },
            }
        },
        components: {
            MusicDescription,
            MusicComment,
            MusicSuggest,
            ReportForm
        },
        watch: {
            '$route'(to, from) {
                this.id = to.params.id;

                this.getMediaDetail({
                    type: this.type,
                    id: this.id
                })
            }
        },
        computed: {
            ...mapGetters({
                music: 'mediaDetailData',
                checkPlayingMusic: 'checkPlayingMusic',
                checkLiked: 'checkLiked',
                user: 'user'
            })
        },
        methods: {
            ...mapActions([
                'getMediaDetail',
                'playingMusic',
                'pauseMusic',
                'likeMedia',
                'downloadMedia',
                'addFavouriteList',
                'reportMedia'
            ]),
            reportFunc(content, callback) {
                this.reportMedia({
                    type: this.type,
                    id: this.id,
                    content: content
                }).then(callback);
            }
        },
        created() {
            this.getMediaDetail({
                type: this.type,
                id: this.id
            })
        }
    }
</script>
<style scoped>

</style>
