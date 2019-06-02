<template>
    <div class="search-content">
        <div class="sub-banner">
            <div class="container">
                <h6>
                    {{ $t('home.region') }}
                    <i class="fa fa-angle-right"></i> {{ regionName }}
                </h6>
            </div>
        </div>
        <div class="kode_content_wrap">
            <section>
                <div class="select-category container">
                    <label class="category-title">{{ $t('home.region') }}:</label>
                    <select class="form-control" name="region" v-model="region" @change="changeRegion">
                        <option value="all">{{ $t('home.all') }}</option>
                        <option v-for="region in allRegions" :value="region.id">{{ region.name }}</option>
                    </select>
                    <span class="error"></span>
                </div>
                <div class="container media-filter-element" v-if="mediaSearch">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3>{{ $t('album.name') }} <i class="fa fa-angle-right"></i></h3>
                            <p class="results">
                                {{ $t('search.number_result', {number: mediaSearch.total}) }}
                            </p>
                        </div>
                        <album-content v-if="mediaSearch.total" :data="mediaSearch.data"></album-content>
                        <div v-else class="data-content">
                            <div class="empty-data">
                                {{ $t('home.no_results') }}
                            </div>
                        </div>
                        <div class="clear"></div>
                        <br>
                        <pagination :pageData="mediaSearch" :loadPageFunc="loadAlbum"></pagination>
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

    import AlbumContent from '../../media/album/search/Content.vue'
    import Pagination from '../../layouts/partials/Pagination.vue'

    export default {
        data() {
            return {
                region: this.$route.params.id,
                type: window.Laravel.setting.album.media_type,
                size: 5,
            }
        },
        watch: {
            '$route'(to, from) {
                this.region = to.params.id != undefined ? to.params.id : 'all';

                this.searchMedia(this.getParamsSearch());
            }
        },
        components: {
            AlbumContent,
            Pagination
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
            loadAlbum(page) {
                let params = this.getParamsSearch();
                params.page = page;

                this.searchMedia(params);
            },
            getParamsSearch() {
                if (this.region == 'all') {
                    return {
                        type: this.type,
                        size: this.size
                    }
                }

                return {
                    region: this.region,
                    type: this.type,
                    size: this.size
                }
            }
        },
        created() {
            this.getAllCategories(window.Laravel.setting.category_type.region);

            this.searchMedia(this.getParamsSearch());
        }
    }
</script>
<style scoped>

</style>
