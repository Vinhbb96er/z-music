<template>
    <div class="media-detail" v-if="video">
        <div class="clear"></div>
        <div class="header-tail"></div>
        <div class="kode_content_wrap">
            <section class="single-video">
                <div class="container video-container">
                    <div class="row">
                        <div class="col-md-8 video-content">
                            <div class="video-wrap">
                                <video id="video-player" preload controls>{{ $t('media.video_not_support') }}</video>
                                <div class="video-player-contant">
                                    <div class="text">
                                        <h6 class="video-title">{{ video.name }}</h6>
                                        <div class="video-admin-wrap">
                                            <div class="text-overflow">
                                                <h5>
                                                   <router-link tag="a" :to="{name: 'profileShow', params: {id: video.user.id}}">
                                                        {{ video.user.name }}
                                                    </router-link>
                                                </h5>
                                                <p v-if="video.kinds_text">{{ $t('home.kind') }}: {{ video.kinds_text }}</p>
                                                <p v-if="video.region">
                                                    {{ $t('home.region') }}:
                                                    <a href="#">{{ video.region.name }}</a>
                                                </p>
                                            </div>
                                            <div class="music-view-like">
                                                <span>
                                                    <i class="fa fa-play-circle-o play-icon"></i>
                                                    <span id="total-views">{{ video.views }}</span>
                                                </span>
                                                <span>
                                                    <i class="fa fa-heart like-icon"></i>
                                                    {{ video.likes_count }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="video-player-links">
                                        <li>
                                            <div class="tab-name action-btn" @click.prevent="tabName = 'VideoDescription'" :class="{active: tabName == 'VideoDescription'}">
                                                <a href="#"><span>{{ $t('media.description') }}</span></a>
                                            </div>
                                            <div class="tab-name action-btn" @click.prevent="tabName = 'VideoComment'" :class="{active: tabName == 'VideoComment'}">
                                                <a href="#">
                                                    <i class="fa fa-comment-o"></i><span>{{ $t('media.comments') }}</span>
                                                </a>
                                            </div>
                                            <div class="action-btn">
                                                <a href="#" @click.prevent="likeMedia({id: id, type: type})" v-if="!user || !checkLiked(id, user.like_data.media)"><i class="fa fa-heart-o"></i>
                                                    <span>{{ $t('playlist.like') }}</span>
                                                </a>
                                                <a href="#" @click.prevent="likeMedia({id: id, type: type})" v-else class="liked"><i class="fa fa-heart"></i>
                                                    <span>{{ $t('playlist.liked') }}</span>
                                                </a>
                                            </div>
                                            <div class="action-btn">
                                                <a href="#" @click.prevent="downloadMedia(id)">
                                                    <i class="fa fa-download"></i><span>{{ $t('playlist.download') }}</span>
                                                </a>
                                            </div>
                                            <div class="action-btn">
                                                <a href="#"><i class="fa fa-flag"></i>
                                                    <span>{{ $t('playlist.report') }}</span>
                                                </a>
                                            </div>
                                            <div class="video-toggle">
                                                <label>{{ $t('media.auto_next') }}</label>
                                                <div class="autoplay-btn">
                                                    <div class="checkboxThree" :class="{'checked': autoNext}">
                                                        <input type="checkbox" value="1" id="checkboxThreeInput" :checked="autoNext" @click="autoNext = !autoNext"/>
                                                        <label for="checkboxThreeInput"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="kode_content_wrap">
                                <section>
                                    <components :is="tabName"></components>
                                </section>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <video-suggest></video-suggest>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
    import VideoDescription from './Description.vue'
    import VideoComment from './Comment.vue'
    import VideoSuggest from './Suggest.vue'

    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                tabName: 'VideoDescription',
                type: window.Laravel.setting.media.type.video,
                id: this.$route.params.id,
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
                },
                videoPlayer: null,
                autoNext: false,
                isView: false,
                startPlay: 0
            }
        },
        components: {
            VideoDescription,
            VideoComment,
            VideoSuggest
        },
        watch: {
            '$route'(to, from) {
                this.id = to.params.id;

                this.getMediaDetail({
                    type: this.type,
                    id: this.id
                }).then(() => {
                    this.initPlayer();
                    if (to.params.autoPlay) {
                        this.playVideo();
                    }
                });
            }
        },
        computed: {
            ...mapGetters({
                video: 'mediaDetailData',
                videoSuggest: 'mediaSuggest',
                checkLiked: 'checkLiked',
                user: 'user'
            })
        },
        methods: {
            ...mapActions(['getMediaDetail', 'upViewMedia', 'likeMedia', 'downloadMedia']),
            loadVideo() {
                this.videoPlayer.src = this.video.url;
                this.videoPlayer.poster = this.video.cover_image;
            },
            playVideo() {
                this.loadVideo();
                this.videoPlayer.play();
            },
            initPlayer() {
                var supportsAudio = !!document.createElement('audio').canPlayType;

                if (supportsAudio) {
                    new Plyr('#video-player', {
                        controls: [
                            'play-large',
                            'rewind',
                            'play',
                            'fast-forward',
                            'progress',
                            'current-time',
                            'duration',
                            'mute',
                            'volume',
                            'settings',
                            'pip',
                            'fullscreen'
                        ]
                    });

                    this.videoPlayer = $('#video-player').on('play', () => {
                        this.isView = true;
                        this.startPlay = this.videoPlayer.currentTime;
                    }).on('timeupdate', () => {
                        let totalTimePlay = ((this.videoPlayer.currentTime - this.startPlay) / this.videoPlayer.duration) * 100;

                        if (this.isView && totalTimePlay > 70) {
                            this.isView = false;

                            this.upViewMedia(this.id).then(function (value) {
                                $('#total-views').text(value);
                            });
                        }
                    }).on('ended', () => {
                        if (this.autoNext) {
                            this.$router.push({
                                name: 'videoDetail',
                                params: {
                                    id: this.videoSuggest[0].id,
                                    autoPlay: true
                                }
                            })
                        }
                    }).get(0);

                    this.loadVideo();
                } else {
                    $('#media-detail .container').append(`<p class="no-support">${$('#video-player').text()}</p>`);
                }
            }
        },
        created() {
            this.getMediaDetail({
                type: this.type,
                id: this.id
            }).then(() => {
                this.initPlayer();
            });
        }
    }
</script>
<style scoped>
    .liked {
        color: #db152e !important;
    }
</style>
