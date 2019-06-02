<template>
    <div class="search-content">
        <div class="sub-banner">
            <div class="container">
                <h6>{{ $t('search.name') }}</h6>
            </div>
        </div>
        <div class="kode_content_wrap" v-if="mediaSearch">
            <section>
                <div class="container media-filter-element">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3>{{ $t('music.name') }} <i class="fa fa-angle-right"></i></h3>
                            <p class="results">
                                {{ $t('search.find_music_result', {number: mediaSearch.musics.total}) }}
                                "<span class="keyword">{{ keyword }}</span>"
                            </p>
                        </div>
                        <div class="data-content">
                            <music-search-content v-if="mediaSearch.musics.total" :data="mediaSearch.musics.data"></music-search-content>
                            <div class="empty-data" v-else>
                                {{ $t('home.no_results') }}
                            </div>
                            <div class="clear"></div>
                            <div class="text-center view-more" v-if="mediaSearch && mediaSearch.musics.total > 5">
                                <router-link class="link" tag="a" :to="{name: 'searchMusic', query: {keyword: keyword}}">
                                    {{ $t('home.view_all') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="container media-filter-element">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3>{{ $t('music_video.name') }} <i class="fa fa-angle-right"></i></h3>
                            <p class="results">
                                {{ $t('search.find_video_result', {number: mediaSearch.videos.total}) }}
                                "<span class="keyword">{{ keyword }}</span>"
                            </p>
                        </div>
                        <div class="data-content">
                            <video-search-content v-if="mediaSearch.videos.total" :data="mediaSearch.videos.data"></video-search-content>
                            <div class="empty-data" v-else>
                                {{ $t('home.no_results') }}
                            </div>
                            <div class="clear"></div>
                            <div class="text-center view-more" v-if="mediaSearch && mediaSearch.videos.total > 4">
                                <router-link class="link" tag="a" :to="{name: 'searchVideo', query: {keyword: keyword}}">
                                    {{ $t('home.view_all') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="container media-filter-element">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3>{{ $t('album.name') }} <i class="fa fa-angle-right"></i></h3>
                            <p class="results">
                                {{ $t('search.find_album_result', {number: mediaSearch.albums.total}) }}
                                "<span class="keyword">{{ keyword }}</span>"
                            </p>
                        </div>
                        <div class="data-content">
                            <album-search-content v-if="mediaSearch.albums.total" :data="mediaSearch.albums.data"></album-search-content>
                            <div class="empty-data" v-else>
                                {{ $t('home.no_results') }}
                            </div>
                            <div class="clear"></div>
                            <div class="text-center view-more" v-if="mediaSearch && mediaSearch.albums.total > 4">
                                <router-link class="link" tag="a" :to="{name: 'searchAlbum', query: {keyword: keyword}}">
                                    {{ $t('home.view_all') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="container">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3>{{ $t('artist.name') }} <i class="fa fa-angle-right"></i></h3>
                            <p class="results">
                                {{ $t('search.find_artist_result', {number: mediaSearch.artists.total}) }}
                                "<span class="keyword">{{ keyword }}</span>"
                            </p>
                        </div>
                        <div class="data-content">
                            <artist-search-content v-if="mediaSearch.artists.total" :data="mediaSearch.artists.data"></artist-search-content>
                            <div class="empty-data" v-else>
                                {{ $t('home.no_results') }}
                            </div>
                            <div class="clear"></div>
                            <div class="text-center view-more" v-if="mediaSearch && mediaSearch.artists.total > 4">
                                <router-link class="link" tag="a" :to="{name: 'searchArtist', query: {keyword: keyword}}">
                                    {{ $t('home.view_all') }}
                                </router-link>
                            </div>
                        </div>
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

    import MusicSearchContent from './music/search/Content.vue'
    import VideoSearchContent from './video/search/Content.vue'
    import AlbumSearchContent from './album/search/Content.vue'
    import ArtistSearchContent from '../profile/search/Content.vue'

    export default {
        data() {
            return {
                keyword: this.$route.query.keyword,
                type: 0
            }
        },
        watch: {
            '$route'(to, from) {
                this.keyword = to.query.keyword != undefined ? to.query.keyword : '';
                this.searchMedia({
                    keyword: this.keyword,
                    type: this.type
                })
            }
        },
        components: {
            MusicSearchContent,
            VideoSearchContent,
            AlbumSearchContent,
            ArtistSearchContent
        },
        computed: {
            ...mapGetters(['mediaSearch'])
        },
        methods: {
            ...mapActions(['searchMedia'])
        },
        created() {
            if (this.keyword == undefined) {
                this.keyword = '';
            }

            this.searchMedia({
                keyword: this.keyword,
                type: this.type
            })
        }
    }
</script>
<style scoped>

</style>
