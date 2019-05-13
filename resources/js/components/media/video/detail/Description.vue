<template>
    <div class="tab-pane active">
        <div class="artist-bio" v-if="video">
            <!--Heading 3 Start-->
            <div class="msl-black">
                <div class="heading3">
                    <h4><i class="fa fa-user"></i>{{ $t('artist.name') }}</h4>
                </div>
            </div>
            <div class="artist-content">
                <a href="#">
                    <figure class="backgroud-image-show" :style="{backgroundImage: `url('${video.user.avatar}')`}"></figure>
                </a>
                <div>
                    <a href="#" class="artist-title">{{ video.user.name }}</a>
                    <div class="follower-info">{{ video.user.followers_count }} {{ $t('artist.followers') }}</div>
                    <button class="btn btn-success btn-follow">{{ $t('button.follow') }}</button>
                </div>
            </div>
            <div class="msl-black">
                <div class="heading3">
                    <h4><i class="fa fa-music"></i>{{ $t('music.lyrics') }}</h4>
                </div>
            </div>
            <div class="text lyrics-content">
                <div class="lyrics-header">
                    <div>{{ $t('music.contribute_by') }} <span class="contributer">{{ video.lyrics_contributer_name }}</span></div>
                    <div class="btn-contribute-lyrics">
                        <a href="#">
                            <i class="fa fa-file-text-o"></i>
                            {{ $t('button.contribute_lyrics') }}
                        </a>
                    </div>
                </div>
                <p>{{ video.lyrics }}</p>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'

    export default {
        computed: {
            ...mapGetters({
                video: 'mediaDetailData'
            })
        }
    }
</script>
<style scoped>

</style>
