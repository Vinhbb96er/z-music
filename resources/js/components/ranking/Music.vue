<template>
    <div class="search-content" v-if="musicRanking">
        <div class="sub-banner">
            <div class="container">
                <h6>
                    {{ $t('music.music_ranking') }}
                </h6>
            </div>
        </div>
        <div class="kode_content_wrap">
            <section>
                <div class="select-category container">
                    <select class="form-control" @change="changeWeek">
                        <option v-for="week in weekRankings" :value="week.value">{{ week.show }}</option>
                    </select>
                    <span class="error"></span>
                </div>
                <div class="container media-filter-element">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3 class="link" role="button" @click.prevent="playAll">
                                {{ $t('playlist.play_all') }} <i class="fa fa-angle-right"></i>
                            </h3>
                        </div>
                        <ul class="mp3-list-table music-search">
                            <li v-for="(music, index) in musicRanking.data" :key="music.id" @click.prevent="playingMusic({id: music.id, type: type})">
                                <div class="rank-number">
                                    {{ (page - 1) * 10 + index + 1 }}
                                </div>
                                <div class="rank-different">
                                    <template v-if="music.differentRank > 0">
                                        <div class="fa fa-caret-up"></div>
                                        <div class="number rank-up">
                                            {{ music.differentRank }}
                                        </div>
                                    </template>
                                    <template v-else-if="music.differentRank < 0">
                                        <div class="fa fa-caret-down"></div>
                                        <div class="number rank-down">
                                            {{ music.differentRank }}
                                        </div>
                                    </template>
                                    <template v-else-if="music.differentRank == 0">
                                        <div class="fa fa-bars rank-normal"></div>
                                    </template>
                                    <template v-else>
                                        <div class="rank-new">{{ music.differentRank }}</div>
                                    </template>
                                </div>
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
                                <div class="song-region" v-if="music.region">
                                    <h6>
                                        {{ music.region.name }}
                                    </h6>
                                </div>
                                <div class="music-icon-group">
                                    <i class="music-playing-icon icon-play-button" v-if="!checkPlayingMusic(music.id)"></i>
                                    <router-link @click.stop tag="a" class="mp3-icon" :to="{name: 'musicDetail', params: {id: music.id}}" :title="$t('home.view_detail')">
                                        <i class="fa fa-info"></i>
                                    </router-link>
                                    <a href="#" class="mp3-icon" :title="$t('playlist.download')" @click.stop.prevent="downloadMedia(music.id)">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <div class="clear"></div>
                        <br>
                        <pagination :pageData="musicRanking" :loadPageFunc="loadMusic"></pagination>
                    </div>
                </div>
                <br>
            </section>
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
                size: 10,
                page: 1,
                week: null
            }
        },
        components: {
            Pagination
        },
        computed: {
            ...mapGetters(['musicRanking', 'checkPlayingMusic', 'weekRankings']),
        },
        methods: {
            ...mapActions([
                'getMusicRanking',
                'playingMusic',
                'addMusicToPlaylist',
                'getWeekRankings',
                'downloadMedia'
            ]),
            playAll() {
                let musicIds = [];

                this.musicRanking.data.forEach((music) => {
                    musicIds.push(music.id);
                });

                this.addMusicToPlaylist({id: musicIds, type: this.type});
            },
            loadMusic(page) {
                this.page = page;
                this.week = this.week ? this.week : this.weekRankings[0].value;
                this.getMusicRanking({
                    type: this.type,
                    size: this.size,
                    week: this.week,
                    full_loading: true,
                    page: page
                });
            },
            changeWeek(e) {
                this.week = e.target.value;

                this.getMusicRanking({
                    type: this.type,
                    size: this.size,
                    week: this.week,
                    full_loading: true
                });
            },
        },
        created() {
            this.getWeekRankings();

            this.getMusicRanking({
                type: this.type,
                size: this.size,
                full_loading: true
            });
        }
    }
</script>
<style scoped>
    .rank-number {
        width: 50px;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        color: #fff;
    }

    .rank-different {
        width: 45px;
        text-align: center;
    }

    .rank-different .fa {
        font-size: 20px;
    }

    .rank-different .number {
        font-size: 13px;
    }

    .fa-caret-up, .rank-up {
        color: #00CC33 !important;
    }

    .fa-caret-down, .rank-down {
        color: #ff0000 !important;
    }

    .rank-normal {
        font-size: 14px !important;
        color: #9c9c9c !important;
    }

    .rank-new {
        font-size: 10px;
        border: 1px solid;
        border-radius: 10px;
        width: 28px;
        padding: 2px 3px;
        color: #f9de03 !important;
        font-weight: bold;
        margin: 0 auto;
    }
</style>
