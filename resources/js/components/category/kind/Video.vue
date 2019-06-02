<template>
    <div class="search-content video-search-element">
        <div class="sub-banner">
            <div class="container">
                <h6>
                    {{ $t('home.kind') }}
                    <i class="fa fa-angle-right"></i> {{ kindName }}
                </h6>
            </div>
        </div>
        <div class="kode_content_wrap">
            <section>
                <div class="select-category container">
                    <label class="category-title">{{ $t('home.kind') }}:</label>
                    <select class="form-control" name="kind" v-model="kind" @change="changeKind">
                        <option value="all">{{ $t('home.all') }}</option>
                        <option v-for="kind in allKinds" :value="kind.id">{{ kind.name }}</option>
                    </select>
                    <span class="error"></span>
                </div>
                <div class="container media-filter-element" v-if="mediaSearch">
                    <div class="mp3-list-wrap">
                        <div class="heading-2">
                            <h3>{{ $t('music_video.name') }} <i class="fa fa-angle-right"></i></h3>
                            <p class="results">
                                {{ $t('search.number_result', {number: mediaSearch.total}) }}
                            </p>
                        </div>
                        <video-content v-if="mediaSearch.total" :data="mediaSearch.data"></video-content>
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

    import VideoContent from '../../media/video/search/Content.vue'
    import Pagination from '../../layouts/partials/Pagination.vue'

    export default {
        data() {
            return {
                kind: this.$route.params.id,
                type: window.Laravel.setting.media.type.video,
                size: 12
            }
        },
        watch: {
            '$route'(to, from) {
                this.kind = to.params.id != undefined ? to.params.id : 'all';

                this.searchMedia(this.getParamsSearch());
            }
        },
        components: {
            VideoContent,
            Pagination
        },
        computed: {
            ...mapGetters(['mediaSearch', 'allKinds']),
            kindName() {
                let name = this.$t('home.all');

                this.allKinds.forEach((item) => {
                    if (this.kind == item.id) {
                        name = item.name;
                    }
                });

                return name;
            }
        },
        methods: {
            ...mapActions(['searchMedia', 'getAllCategories']),
            changeKind(e) {
                this.kind = e.target.value;

                this.searchMedia(this.getParamsSearch());
            },
            loadVideo(page) {
                let params = this.getParamsSearch();
                params.page = page;

                this.searchMedia(params);
            },
            getParamsSearch() {
                if (this.kind == 'all') {
                    return {
                        type: this.type,
                        size: this.size
                    }
                }

                return {
                    kind: this.kind,
                    type: this.type,
                    size: this.size
                }
            }
        },
        created() {
            this.getAllCategories(window.Laravel.setting.category_type.kind);

            this.searchMedia(this.getParamsSearch());
        }
    }
</script>
<style>

</style>
