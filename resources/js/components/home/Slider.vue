<template>
    <div class="banner_slider">
        <div class="main-slider">
            <div class="slide" v-for="media in sliderItems" :key="media.id">
                <img :src="media.cover_image" alt="banner img">
                <div class="banner_content container">
                    <div class="b_title animated">{{ media.name }}</div>
                    <a href="index.html" class="btn_normal border_btn animated">{{ $t('home.view') }}</a>
                    <a href="index.html" class="btn_normal border_btn animated">{{ $t('home.listen') }}</a>
                </div>
                <div class="media-info">
                    <span><i class="fa fa-play-circle-o play-icon"></i> {{ media.views }}</span>
                    <span><i class="fa fa-heart like-icon"></i> {{ media.likes.length }}</span>
                </div>
            </div>
        </div>
        <div class="slider-nav-thumbnails">
            <div v-for="thumbnail in sliderThumbnails"><img :src="thumbnail"></div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        computed: {
            ...mapGetters(['sliderItems']),
            sliderThumbnails() {
                var thumbnails = [];

                this.sliderItems.forEach((item) => {
                    thumbnails.push(item.cover_image);
                });

                return thumbnails;
            }
        },
        methods: {
            ...mapActions(['getSliders']),
        },
        created() {
            this.getSliders();
        },
        updated() {
            $('.banner_slider .main-slider').slick({
                centerMode:true,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                autoplay: true,
                autoplaySpeed: 2000,
                asNavFor: '.banner_slider .slider-nav-thumbnails'
            });

            $('.banner_slider .slider-nav-thumbnails').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                asNavFor: '.banner_slider .main-slider',
                focusOnSelect: true,
                dots: true
            });
        }
    }
</script>
<style>

</style>
