<template>
    <div class="search-content" v-if="videoRanking">
        <div class="sub-banner">
            <div class="container">
                <h6>
                    {{ $t('music_video.video_ranking') }}
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
                        <div class="album-outer album-search">
                            <!--Music Album List Thumb Start-->
                            <div class="album-list-thumb-outer" v-for="(video, index) in videoRanking.data" :key="video.id">
                                <div class="album-list-thumb">
                                    <div class="rank-number">
                                        {{ (page - 1) * 10 + index + 1 }}
                                    </div>
                                    <div class="rank-different">
                                        <template v-if="video.differentRank > 0">
                                            <div class="fa fa-caret-up"></div>
                                            <div class="number rank-up">
                                                {{ video.differentRank }}
                                            </div>
                                        </template>
                                        <template v-else-if="video.differentRank < 0">
                                            <div class="fa fa-caret-down"></div>
                                            <div class="number rank-down">
                                                {{ video.differentRank }}
                                            </div>
                                        </template>
                                        <template v-else-if="video.differentRank == 0">
                                            <div class="fa fa-bars rank-normal"></div>
                                        </template>
                                        <template v-else>
                                            <div class="rank-new">{{ video.differentRank }}</div>
                                        </template>
                                    </div>
                                    <div class="thumb backgroud-image-show" :style="{backgroundImage: `url(${video.cover_image})`}">
                                    </div>
                                    <div class="title">
                                        <div>
                                            <router-link @click.stop tag="h5" class="album-name" :to="{name: 'videoDetail', params: {id: video.id}}" role="button" :title="video.name">
                                                {{ video.name }}
                                            </router-link>
                                            <router-link tag="a" :to="{name: 'profileShow', params: {id: 1}}" class="album-artist">
                                                {{ video.user.name }}
                                            </router-link>
                                        </div>
                                    </div>
                                    <div class="album-kind">
                                        <div>
                                            <p>{{ video.kinds_text }}</p>
                                        </div>
                                    </div>
                                    <div class="album-region" v-if="video.region">
                                        <div>
                                            <p>{{ video.region.name }}</p>
                                        </div>
                                    </div>
                                    <div class="clic-btn-wrap btn-block">
                                        <div class="music-icon-group">
                                            <router-link @click.stop tag="a" class="mp3-icon" :to="{name: 'videoDetail', params: {id: video.id}}" :title="$t('home.view_detail')">
                                                <i class="fa fa-info"></i>
                                            </router-link>
                                            <a href="#" class="mp3-icon" :title="$t('playlist.download')" @click.prevent="downloadMedia(video.id)">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <br>
                        <pagination :pageData="videoRanking" :loadPageFunc="loadVideo"></pagination>
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
                type: window.Laravel.setting.media.type.video,
                size: 10,
                page: 1,
                week: null
            }
        },
        components: {
            Pagination
        },
        computed: {
            ...mapGetters(['videoRanking', 'weekRankings']),
        },
        methods: {
            ...mapActions([
                'getVideoRanking',
                'getWeekRankings',
                'downloadMedia'
            ]),
            loadVideo(page) {
                this.page = page;
                this.week = this.week ? this.week : this.weekRankings[0].value;
                this.getVideoRanking({
                    type: this.type,
                    size: this.size,
                    week: this.week,
                    full_loading: true,
                    page: page,
                });
            },
            changeWeek(e) {
                this.week = e.target.value;

                this.getVideoRanking({
                    type: this.type,
                    size: this.size,
                    week: this.week,
                    full_loading: true
                });
            },
        },
        created() {
            this.getWeekRankings();

            this.getVideoRanking({
                type: this.type,
                size: this.size,
                full_loading: true
            });
        }
    }
</script>
<style scoped>
    .rank-number {
        width: 30px;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        color: #fff;
    }

    .rank-different {
        width: 50px;
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

    .rank-number, .rank-different {
        min-width: 30px;
    }

    .album-search {
        margin-bottom: 10px;
    }

    .album-search .album-list-thumb-outer:last-child {
        margin-bottom: 0;
    }

    .album-search .album-list-thumb .title {
        width: 48%;
    }

    .album-search .album-list-thumb .thumb {
        height: 75px;
        width: 120px;
    }

    .album-search .album-list-thumb .album-kind {
        width: 15%;
        text-align: center;
    }

    .album-search .album-list-thumb .album-region {
        width: 12%;
        text-align: center;
    }

    .album-search .album-list-thumb .btn-block {
        width: 70px;
        text-align: center;
    }
</style>
