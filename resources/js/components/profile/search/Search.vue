<template>
    <div class="search-content">
        <div class="sub-banner">
            <div class="container">
                <h6 v-if="keyword">{{ $t('search.search_artist') }}</h6>
                <h6 v-else>{{ $t('artist.name') }}</h6>
            </div>
        </div>
        <div class="kode_content_wrap">
            <section>
                <div class="container" v-if="mediaSearch">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3>{{ $t('artist.name') }} <i class="fa fa-angle-right"></i></h3>
                            <p class="results" v-if="keyword">
                                {{ $t('search.find_artist_result', {number: mediaSearch.total}) }}
                                "<span class="keyword">{{ keyword }}</span>"
                            </p>
                        </div>
                        <div class="data-content">
                            <artist-search-content v-if="mediaSearch.total" :data="mediaSearch.data"></artist-search-content>
                            <div class="empty-data" v-else>
                                {{ $t('home.no_results') }}
                            </div>
                        </div>
                        <br>
                        <pagination :pageData="mediaSearch" :loadPageFunc="loadArtist"></pagination>
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

    import ArtistSearchContent from './Content.vue'
    import Pagination from '../../layouts/partials/Pagination.vue'

    export default {
        data() {
            return {
                keyword: this.$route.query.keyword,
                type: 4,
                size: 12,
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
            ArtistSearchContent,
            Pagination
        },
        computed: {
            ...mapGetters(['mediaSearch'])
        },
        methods: {
            ...mapActions(['searchMedia']),
            loadArtist(page) {
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
