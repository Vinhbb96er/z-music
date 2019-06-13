<template>
    <div class="media-detail video-detail" v-if="video">
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
                                        <h6 class="video-title">
                                            <div>{{ video.name }}</div>
                                            <a href="#" title="Karaoke" class="btn-karaoke" :class="{'btn-active': karaokeMode}" @click.prevent="changeKaraokeMode">
                                                <i class="fa fa-microphone"></i>
                                            </a>
                                        </h6>
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
                                            <div class="content">
                                                <div class="lyrics" v-if="karaokeMode && video.karaoke_lyrics">
                                                    <div v-for="item in video.karaoke_lyrics">
                                                        {{ item.line }}
                                                    </div>
                                                </div>
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
                                                <a href="#" @click.prevent="showReportForm"><i class="fa fa-flag"></i>
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
        <report-form :reportFunc="reportFunc"></report-form>
    </div>
</template>
<script>
    import VideoDescription from './Description.vue'
    import VideoComment from './Comment.vue'
    import VideoSuggest from './Suggest.vue'
    import ReportForm from './../../../layouts/partials/ReportForm.vue'

    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'
    import {mapMutations} from 'vuex'

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
                startPlay: 0,
                karaokeMode: false
            }
        },
        components: {
            VideoDescription,
            VideoComment,
            VideoSuggest,
            ReportForm
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
                user: 'user',
                authenticated: 'authenticated'
            })
        },
        methods: {
            ...mapMutations(['setListVideoView']),
            ...mapActions(['getMediaDetail', 'upViewMedia', 'likeMedia', 'downloadMedia', 'reportMedia']),
            loadVideo() {
                this.videoPlayer.src = this.video.url;
                this.videoPlayer.poster = this.video.cover_image;
                this.karaokeMode = this.video.karaoke_lyrics ? true : false;
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

                    var karaokeList = this.video.karaoke_lyrics;
                    var currentLine = '';

                    this.videoPlayer = $('#video-player').on('play', () => {
                        this.isView = true;
                        this.startPlay = this.videoPlayer.currentTime;
                    }).on('timeupdate', () => {
                        let totalTimePlay = ((this.videoPlayer.currentTime - this.startPlay) / this.videoPlayer.duration) * 100;

                        if (this.isView && totalTimePlay > 1) {
                            this.isView = false;

                            this.upViewMedia({id: this.id}).then(function (value) {
                                $('#total-views').text(value.media);
                            });
                        }

                        if (!karaokeList || !this.karaokeMode) {
                            return;
                        }

                        var currentTime = this.videoPlayer.currentTime;
                        var past = karaokeList.filter(function (item) {
                            return item.time < currentTime;
                        });

                        if (past.length != currentLine) {
                            currentLine = past.length;
                            $('.video-detail .lyrics div').removeClass('highlighted');
                            $(`.video-detail .lyrics div:nth-child(${past.length})`).addClass('highlighted');
                            alignKaraokeLyrics($('.video-detail .content'));
                        }
                    }).on('ended', () => {
                        if (this.autoNext) {
                            this.setListVideoView(this.id);

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
            },
            showReportForm() {
                if (!this.authenticated) {
                    $('#login-register1').modal('show');

                    return;
                }

                $('#report-form').modal('show');
            },
            reportFunc(content, callback) {
                this.reportMedia({
                    type: this.type,
                    id: this.id,
                    content: content
                }).then(callback);
            },
            changeKaraokeMode() {
                if (!this.video.karaoke_lyrics) {
                    flashMessage('Video này chưa có Karaoke', 'info');

                    return;
                }

                this.karaokeMode = !this.karaokeMode;
            }
        },
        created() {
            this.getMediaDetail({
                type: this.type,
                id: this.id
            }).then(() => {
                this.initPlayer();
                this.karaokeMode = this.video.karaoke_lyrics ? true : false;
            });
        }
    }
</script>
<style scoped>
    .liked {
        color: #db152e !important;
    }

    .video-title {
        display: flex;
    }

    .btn-karaoke {
        width: 28px;
        height: 28px;
        border: 1px solid #ffff;
        border-radius: 50%;
        display: inline-block;
        text-align: center;
        font-size: 16px;
        padding: 3px;
        margin: 2px 0 2px 10px;
    }

    .btn-karaoke:hover, .btn-active {
        border-color: #f5253f !important;
        color: #f5253f !important;
    }

    .content {
        text-align: center;
        overflow: hidden;
        max-height: 40px;
        position: absolute;
        right: 21%;
        top: 58%;
    }

    .content::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(255, 255, 255, 0.3);
        background-color: #a0a0a0;
    }

    .content::-webkit-scrollbar {
        width: 2px;
        background-color: #F5F5F5;
    }

    .content::-webkit-scrollbar-thumb {
        background-color: #f5253f;
        border-radius: 10px;
    }

    .content .lyrics {
        min-height: 100px;
        width: calc(100% - 40px);
        margin: 0 20px;
        text-align: center;
        transition: all .25s;
        position: relative;
    }

    .content .lyrics > div {
        position: relative;
        font-size: 15px;
        line-height: 35px;
        color: #fff;
        transition: all .25s;
    }

    .content .lyrics > div:before {
        content: attr(note);
        position: absolute;
        top: 0px;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        font-size: 18px;
    }

    .content .lyrics > div.highlighted {
        color: #ecdb0c;
        font-size: 17px;
        font-weight: bold;
    }
</style>
