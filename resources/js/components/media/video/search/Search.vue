<template>
    <div class="search-content video-search-element">
        <div class="sub-banner">
            <div class="container">
                <h6>{{ $t('search.search_video') }}</h6>
            </div>
        </div>
        <div class="kode_content_wrap">
            <section>
                <div class="container media-filter-element" v-if="mediaSearch">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3>{{ $t('music_video.name') }} <i class="fa fa-angle-right"></i></h3>
                            <p class="results">
                                {{ $t('search.find_video_result', {number: mediaSearch.total}) }}
                                "<span class="keyword">{{ keyword }}</span>"
                            </p>
                        </div>
                        <video-search-content v-if="mediaSearch.total" :data="mediaSearch.data"></video-search-content>
                        <div v-else class="data-content">
                            <div class="empty-data">
                                {{ $t('home.no_results') }}
                            </div>
                        </div>
                        <div class="clear"></div>
                        <br>
                        <pagination :pageData="mediaSearch" :loadPageFunc="loadVideo"></pagination>
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

    import VideoSearchContent from './Content.vue'
    import Pagination from '../../../layouts/partials/Pagination.vue'

    export default {
        data() {
            return {
                keyword: this.$route.query.keyword,
                type: window.Laravel.setting.media.type.video,
                size: 12
            }
        },
        watch: {
            '$route'(to, from) {
                this.keyword = to.query.keyword != undefined ? to.query.keyword : '';
                this.searchMedia({
                    keyword: this.keyword,
                    type: this.type,
                    size: this.size
                });
            }
        },
        components: {
            VideoSearchContent,
            Pagination
        },
        computed: {
            ...mapGetters(['mediaSearch'])
        },
        methods: {
            ...mapActions(['searchMedia']),
            loadVideo(page) {
                this.searchMedia({
                    keyword: this.keyword,
                    type: this.type,
                    size: this.size,
                    page: page
                });
            }
        },
        created() {
            if (this.keyword == undefined) {
                this.keyword = '';
            }

            this.searchMedia({
                keyword: this.keyword,
                type: this.type,
                size: this.size
            })
        }
    }
</script>
<style>
    .video-search-element .grid-container-small .grid-item {
        margin: 0 5px 10px 5px;
    }
</style>
