<template>
    <div class="playlist-container" v-show="playlist.length">
        <div id="music-player-element">
            <div class="player-content">
                <audio id="music-player" preload controls>{{ $t('playlist.audio_not_support') }}</audio>
            </div>
            <div class="playlist-button-element">
                <button class="btn btn-playlist">
                    <i class="fa fa-headphones" aria-hidden="true"></i>
                    {{ $t('playlist.name') }}  ({{ playlistLength }})
                </button>
            </div>
        </div>
        <div id="music-playlist-element" v-if="playlist.length">
            <div class="btn-close-playlist-content" role="button">
                <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </div>
            <div class="playlist-content">
                <div class="playlist-title">
                    <h3>{{ $t('playlist.name') }} ({{ playlistLength }})</h3>
                    <ul class="action-group-icon">
                        <li class="plyr-random">
                            <a href="#" :title="$t('playlist.play_random')">
                                <i role="button" class="fa fa-random"></i>
                            </a>
                        </li>
                        <li class="plyr-repeat" :title="$t('playlist.repeat')">
                            <a href="#">
                                <i role="button" class="fa fa-retweet"></i>
                            </a>
                        </li>
                        <li @click.prevent="removeAll">
                            <a href="#" :title="$t('playlist.search')">
                                <i role="button" class="fa fa-trash"></i>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="#" :title="$t('playlist.search')">
                                <i role="button" class="fa fa-search"></i>
                            </a>
                        </li> -->
                    </ul>
                </div>
                <hr />
                <div id="music-playlist">
                    <table>
                        <tbody>
                            <tr v-for="(music, index) in playlist" :key="music.id" :class="{selected: playingIndex == index}">
                                <td width="3%" class="index text-left">{{ index + 1 }}</td>
                                <td width="3%" class="icon-playing">
                                    <img :src="images.music_playing"
                                        :class="{hidden: (!isPlaying || playingIndex != index)}">
                                </td>
                                <td width="54%" class="title">
                                    <a href="#" :title="music.name">{{ music.name }}</a>
                                </td>
                                <td width="30%" class="artist">
                                    <router-link tag="a" :to="{name: 'profileShow', params: {id: music.user.id}}" :title="music.user.name">
                                        {{ music.user.name }}
                                    </router-link>
                                </td>
                                <td width="10%" class="btn-action-group text-right">
                                    <div class="popup-menu">
                                        <router-link tag="span" :to="{name: 'musicDetail', params: {id: music.id}}" class="btn-action">
                                            <i role="button" class="fa fa-info-circle"></i>
                                        </router-link>
                                        <span class="btn-open-menu btn-action"><i role="button" class="fa fa-bars"></i></span>
                                        <ul class="menu-content text-left">
                                            <li @click.prevent="addFavouriteList(music.id)">
                                                <a class="" @click.prevent>
                                                    <i class="fa fa-plus"></i>
                                                    {{ $t('playlist.add_my_favourite') }}
                                                </a>
                                            </li>
                                            <li @click.prevent="downloadMedia(music.id)">
                                                <a class="" @click.prevent>
                                                   <i class="fa fa-download"></i> {{ $t('playlist.download') }}
                                                </a>
                                            </li>
                                            <li v-if="!isPlaying || playingIndex != index" @click="removeMusicFromPlaylist(index)">
                                                <a href="#">
                                                    <i class="fa fa-trash"></i>
                                                    {{ $t('playlist.remove') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="music-content">
                <div class="item-inner">
                    <h3 class="album-title">
                        {{ playlist[playingIndex].name }}
                    </h3>
                    <div class="cover-holder">
                        <a class="cover-figure" href="#">
                            <div class="record-holder" :class="{playing: isPlaying}">
                                <img class="img-fluid" :src="images.track" alt="">
                            </div>
                            <img class="cover-image img-fluid backgroud-image-show" src="#" :style="{backgroundImage: `url(${playlist[playingIndex].cover_image})`}">
                        </a>
                    </div>
                    <div class="music-view-like">
                        <span>
                            <i class="fa fa-play-circle-o play-icon"></i>
                            {{ playlist[playingIndex].views }}
                        </span>
                        <span>
                            <i class="fa fa-heart like-icon"></i>
                            {{ playlist[playingIndex].likes_count }}
                        </span>
                    </div>
                </div>
                <div class="clear"></div>
                <ul class="action-group-icon">
                    <router-link tag="li" :to="{name: 'musicDetail', params: {id: playlist[playingIndex].id}}">
                        <a class="liked" @click.prevent>
                            <i role="button" class="fa fa-info"></i>
                        </a>
                    </router-link>
                    <li>
                        <a class="liked">
                            <i role="button" class="fa fa-heart-o"></i>
                        </a>
                    </li>
                    <li>
                        <a class="">
                            <i role="button" class="fa fa-plus"></i>
                        </a>
                    </li>
                    <li @click.prevent="downloadMedia(music.id)">
                        <a role="button">
                            <i role="button" class="fa fa-download"></i>
                        </a>
                    </li>
                </ul>
                <div class="music-info-block">
                    <div class="music-name">
                        <a role="button" class="" href="#">{{ playlist[playingIndex].name }}</a>
                    </div>
                    <div class="music-artist">
                        <router-link tag="a" :to="{name: 'profileShow', params: {id: playlist[playingIndex].user.id}}" role="button">
                            {{ playlist[playingIndex].user.name }}
                        </router-link>
                    </div>
                    <div class="music-info">
                        <div class="music-album" v-if="playlist[playingIndex].album">
                            {{ $t('album.name') }}:
                            <router-link tag="a" :to="{name: 'albumDetail', params: {id: playlist[playingIndex].album.id}}" role="button">
                                {{ playlist[playingIndex].album.name }}
                            </router-link>
                        </div>
                        <div class="music-kind">
                            {{ $t('home.kind') }}:
                            <a role="button" class="" href="#">
                                {{ playlist[playingIndex].kinds_text }}
                            </a>
                        </div>
                        <div class="music-lyrics">
                            <p>{{ playlist[playingIndex].lyrics }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                images: {
                    track: window.Laravel.setting.images.track,
                    music_playing: window.Laravel.setting.images.music_playing
                }
            }
        },
        computed: {
            ...mapGetters([
                'playlist',
                'repeatMode',
                'randomMode',
                'playingIndex',
                'playlistLength',
                'isPlaying'
            ])
        },
        methods: {
            ...mapActions([
                'changeRepeatMode',
                'changeRandomMode',
                'initPlayer',
                'playMusic',
                'nextMusic',
                'prevMusic',
                'removeMusicFromPlaylist',
                'downloadMedia',
                'addFavouriteList',
                'removeAll'
            ]),
            clickPlayMusic(index) {
                if (index !== this.playingIndex) {
                    this.playMusic(index);
                }
            },
            initSupportElementPlayer() {
                $(`<button type="button" class="plyr__control plyr-prev" title="${this.$t('playlist.prev')}"><i class="fa fa-step-backward fa-lg"></i></button>`).insertBefore('.plyr__controls [data-plyr="play"]');
                $(`<button type="button" class="plyr__control plyr-next" title="${this.$t('playlist.next')}"><i class="fa fa-step-forward fa-lg"></i></button>`).insertAfter('.plyr__controls [data-plyr="play"]');
                $(`<button type="button" class="plyr__control plyr-random"  title="${this.$t('playlist.play_random')}"><i class="fa fa-random fa-lg"></i></button>`).insertAfter('.plyr-next');
                $(`<button type="button" class="plyr__control plyr-repeat"  title="${this.$t('playlist.repeat')}"><i class="fa fa-retweet fa-lg"></i></button>`).insertAfter('.plyr__control.plyr-random');
                $('<div id="music-title" class="text-center"></div>').insertBefore('.plyr__controls .plyr__progress');

                $(document).on('click', '.plyr-prev', () => {
                    this.prevMusic();
                });

                $(document).on('click', '.plyr-next', () => {
                    this.nextMusic();
                });

                $(document).on('click', '.plyr-random', () => {
                    this.changeRandomMode();

                    if (this.randomMode) {
                        $('.plyr-random').addClass('on');
                    } else {
                        $('.plyr-random').removeClass('on');
                    }
                });

                $(document).on('click', '.plyr-repeat', () => {
                    this.changeRepeatMode();

                    if (this.repeatMode) {
                        $('.plyr-repeat').addClass('on');
                    } else {
                        $('.plyr-repeat').removeClass('on');
                    }
                });

                $(document).on('click', '.btn-playlist, .btn-close-playlist-content', function (e) {
                    e.stopPropagation();
                    $('#music-playlist-element #music-playlist tr.selected').get(0).scrollIntoView();
                    $('#music-playlist-element').slideToggle('fast');
                });

                $(document).on('click', '.playlist-container', function (e) {
                    e.stopPropagation();
                    $('.popup-menu .menu-content').fadeOut(400);
                });

                $(document).on('click', function() {
                    if ($('#music-playlist-element').is(':visible')) {
                        $('#music-playlist-element').slideUp();
                    }
                });

                var clickPlayMusicFunc = this.clickPlayMusic;

                $(document).on('click', '#music-playlist table tbody tr', function () {
                    clickPlayMusicFunc(parseInt($(this).index()));
                });
            }
        },
        mounted() {
            var supportsAudio = !!document.createElement('audio').canPlayType;

            if (supportsAudio) {
                this.initPlayer();
                this.initSupportElementPlayer();
            } else {
                $('.music-player-element, music-playlist-element').addClass('hidden');
                $('.playlist-container').append(`<p class="no-support">${$('#music-player').text()}</p>`);
            }
        }
    }
</script>
<style scoped>

</style>
