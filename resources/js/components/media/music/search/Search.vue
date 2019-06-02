<template>
    <div class="search-content">
        <div class="sub-banner">
            <div class="container">
                <h6>{{ $t('search.search_music') }}</h6>
            </div>
        </div>
        <div class="kode_content_wrap">
            <section>
                <div class="container media-filter-element" v-if="mediaSearch">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3>{{ $t('music.name') }} <i class="fa fa-angle-right"></i></h3>
                            <p class="results">
                                {{ $t('search.find_music_result', {number: mediaSearch.total}) }}
                                "<span class="keyword">{{ keyword }}</span>"
                            </p>
                        </div>
                        <music-search-content v-if="mediaSearch.total" :data="mediaSearch.data"></music-search-content>
                        <div v-else class="data-content">
                            <div class="empty-data">
                                {{ $t('home.no_results') }}
                            </div>
                        </div>
                        <div class="clear"></div>
                        <br>
                        <pagination :pageData="mediaSearch" :loadPageFunc="loadMusic"></pagination>
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

    import MusicSearchContent from './Content.vue'
    import Pagination from '../../../layouts/partials/Pagination.vue'

    export default {
        data() {
            return {
                keyword: this.$route.query.keyword,
                type: window.Laravel.setting.media.type.music,
                size: 10,
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
            MusicSearchContent,
            Pagination
        },
        computed: {
            ...mapGetters(['mediaSearch'])
        },
        methods: {
            ...mapActions(['searchMedia']),
            loadMusic(page) {
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
<style scoped>

</style>
