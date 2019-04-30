<template>
    <div class="new-album-wrap mg-40 media-filter-element">
        <!--Heading Start-->
        <div class="msl-black title-style-2">
            <div class="msl-heading light-color ">
                <h5>
                    <span>{{ $t('home.kind_regions') }}</span>
                    <span class="line"></span>
                </h5>
            </div>
        </div>
        <!--Heading End-->
        <div class="tab-content">
            <div class="tab-pane active">
                <!--Music Album Inner Wrap Start-->
                <div class="album-inner">
                    <!--Music Album Inner Nav Start-->
                    <h4 class="heading-2 media-header-title">
                        <a href="#">
                            {{ categories[categoryType].title }} <i class="fa fa-angle-right"></i>
                        </a>
                    </h4>
                    <ul class="nav-tabs msl-tab-nav">
                        <li class="region-title" v-for="category in categories" @click.prevent="categoryType = category.type" :class="{active: categoryType == category.type}">
                            <a href="#">{{ category.title }}</a>
                        </li>
                    </ul>
                    <div class="card-group">
                        <div class="card-item" v-for="category in topViewCategories">
                            <a href="#">
                                <figure class="backgroud-image-show" :style="{backgroundImage: `url(${category.cover_image})`}">
                                    <span class="card-gradient-background" :class="category.background"></span>
                                </figure>
                                <h4 class="card-title">{{ category.name }}</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Music Album Contant End-->
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                categoryType: window.Laravel.setting.category_type.selective,
                categories: [
                    {
                        type: window.Laravel.setting.category_type.selective,
                        title: this.$t('home.selective')
                    },
                    {
                        type: window.Laravel.setting.category_type.region,
                        title: this.$t('home.region')
                    },
                    {
                        type: window.Laravel.setting.category_type.kind,
                        title: this.$t('home.kind')
                    }
                ]
            };
        },
        watch: {
            categoryType() {
                this.getTopViewCategories({
                    type: this.categoryType
                });
            }
        },
        computed: {
            ...mapGetters(['topViewCategories'])
        },
        methods: {
            ...mapActions(['getTopViewCategories'])
        },
        created() {
            this.getTopViewCategories({
                type: this.categoryType
            });
        }
    }
</script>
<style>

</style>
