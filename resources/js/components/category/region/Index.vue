<template>
    <div class="search-content video-search-element">
        <div class="sub-banner">
            <div class="container">
                <h6>
                    {{ $t('home.region') }}
                    <i class="fa fa-angle-right"></i> {{ regionName }}
                </h6>
            </div>
        </div>
        <div class="kode_content_wrap" v-if="mediaSearch">
            <section>
                <div class="select-category container">
                    <label class="category-title">{{ $t('home.region') }}:</label>
                    <select class="form-control" name="region" v-model="region" @change="changeRegion">
                        <option value="all">{{ $t('home.all') }}</option>
                        <option v-for="region in allRegions" :value="region.id">{{ region.name }}</option>
                    </select>
                    <span class="error"></span>
                </div>
                <div class="container media-filter-element" v-if="mediaSearch.musics">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3>{{ $t('music.name') }} <i class="fa fa-angle-right"></i></h3>
                        </div>
                        <div class="data-content">
                            <music-search-content v-if="mediaSearch.musics.total" :data="mediaSearch.musics.data"></music-search-content>
                            <div class="empty-data" v-else>
                                {{ $t('home.no_results') }}
                            </div>
                            <div class="clear"></div>
                            <div class="text-center view-more" v-if="mediaSearch && mediaSearch.musics.total > 5">
                                <router-link class="link" tag="a" :to="{name: 'categoryRegionMusic', params: {id: region}}">
                                    {{ $t('home.view_all') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="container media-filter-element" v-if="mediaSearch.videos">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3>{{ $t('music_video.name') }} <i class="fa fa-angle-right"></i></h3>
                        </div>
                        <div class="data-content">
                            <video-search-content v-if="mediaSearch.videos.total" :data="mediaSearch.videos.data"></video-search-content>
                            <div class="empty-data" v-else>
                                {{ $t('home.no_results') }}
                            </div>
                            <div class="clear"></div>
                            <div class="text-center view-more" v-if="mediaSearch && mediaSearch.videos.total > 4">
                                <router-link class="link" tag="a" :to="{name: 'categoryRegionVideo', params: {id: region}}">
                                    {{ $t('home.view_all') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="container media-filter-element" v-if="mediaSearch.albums">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3>{{ $t('album.name') }} <i class="fa fa-angle-right"></i></h3>
                        </div>
                        <div class="data-content">
                            <album-search-content v-if="mediaSearch.albums.total" :data="mediaSearch.albums.data"></album-search-content>
                            <div class="empty-data" v-else>
                                {{ $t('home.no_results') }}
                            </div>
                            <div class="clear"></div>
                            <div class="text-center view-more" v-if="mediaSearch && mediaSearch.albums.total > 4">
                                <router-link class="link" tag="a" :to="{name: 'categoryRegionAlbum', params: {id: region}}">
                                    {{ $t('home.view_all') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
            </section>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    import MusicSearchContent from '../../media/music/search/Content.vue'
    import VideoSearchContent from '../../media/video/search/Content.vue'
    import AlbumSearchContent from '../../media/album/search/Content.vue'

    export default {
        data() {
            return {
                region: this.$route.params.id,
                type: 0
            }
        },
        watch: {
            '$route'(to, from) {
                this.region = to.params.id != undefined ? to.params.id : 'all';

                this.searchMedia(this.getParamsSearch());
            }
        },
        components: {
            MusicSearchContent,
            VideoSearchContent,
            AlbumSearchContent
        },
        computed: {
            ...mapGetters(['mediaSearch', 'allRegions']),
            regionName() {
                let name = this.$t('home.all');

                this.allRegions.forEach((item) => {
                    if (this.region == item.id) {
                        name = item.name;
                    }
                });

                return name;
            }
        },
        methods: {
            ...mapActions(['searchMedia', 'getAllCategories']),
            changeRegion(e) {
                this.region = e.target.value;

                this.searchMedia(this.getParamsSearch());
            },
            getParamsSearch() {
                if (this.region == 'all') {
                    return {
                        type: this.type
                    }
                }

                return {
                    region: this.region,
                    type: this.type
                }
            }
        },
        created() {
            this.getAllCategories(window.Laravel.setting.category_type.region);

            this.searchMedia(this.getParamsSearch());
        }
    }
</script>
<style>

</style>
