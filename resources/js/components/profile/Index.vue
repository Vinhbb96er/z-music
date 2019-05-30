<template>
    <div class="media-detail user-detail">
        <div class="msl-banner2" v-if="profileData" :style="{backgroundImage: `url('${profileData.background}')`}">
            <div class="container">
                <div class="artist-banner">
                    <div class="artist-banner-thumb">
                        <figure class="backgroud-image-show" :style="{backgroundImage: `url('${profileData.avatar}')`}">
                        </figure>
                        <div class="text-overflow">
                            <h5 class="artist-name">
                                {{ profileData.name }}
                                <span class="label" v-if="profileData.type_text">{{ profileData.type_text }}</span>
                            </h5>
                            <p v-if="profileData.followers">{{ profileData.followers.length }} {{ $t('artist.followers') }}</p>
                            <p></p>
                        </div>
                        <div class="action-group" v-show="!user || user && user.id != profileData.id">
                            <a class="btn-1 theme-bg" href="#">
                                <i class="fa fa-user-plus"></i>{{ $t('button.follow') }}
                            </a>
                            <a class="btn-1 theme-bg" href="#"><i class="fa fa-flag-o"></i>{{ $t('playlist.report') }}</a>
                        </div>
                    </div>
                </div>
                <!--Music Album Wrap Start-->
            </div>
            <div class="music-album-wrap">
                <div class="container">
                    <ul class="nav-tabs music-album-nav">
                        <li @click.prevent="tabName = 'GeneralInformation'" :class="{active: tabName == 'GeneralInformation'}">
                            <a href="#" >{{ $t('media.description') }}</a>
                        </li>
                        <li @click.prevent="tabName = 'Music'" :class="{active: tabName == 'Music'}">
                            <a href="#">{{ $t('music.name') }}</a>
                        </li>
                        <li @click.prevent="tabName = 'Video'" :class="{active: tabName == 'Video'}">
                            <a href="#">{{ $t('music_video.name') }}</a>
                        </li>
                        <li @click.prevent="tabName = 'Album'" :class="{active: tabName == 'Album'}">
                            <a href="#">{{ $t('album.name') }}</a>
                        </li>
                        <li @click.prevent="tabName = 'Create'" :class="{active: tabName == 'Create'}">
                            <a href="#">Upload</a>
                        </li>
                    </ul>
                </div>
                <!--Music Album Wrap End-->
            </div>
        </div>
        <div class="kode_content_wrap">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="tab-content">
                                <components :is="tabName"></components>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <artist-suggest></artist-suggest>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
    import GeneralInformation from './GeneralInformation.vue'
    import Music from './Music.vue'
    import Video from './Video.vue'
    import Album from './Album.vue'
    import ArtistSuggest from './Suggest.vue'
    import Create from './upload/Create.vue'

    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                tabName: 'GeneralInformation',
                type: window.Laravel.setting.media.type.music,
                id: this.$route.params.id,
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
                }
            }
        },
        components: {
            GeneralInformation,
            ArtistSuggest,
            Music,
            Video,
            Album,
            Create
        },
        watch: {
            '$route'(to, from) {
                this.id = to.params.id;
                this.getProfile(this.id);
            }
        },
        computed: {
            ...mapGetters(['profileData', 'user', 'checkIsAuthUser'])
        },
        methods: {
            ...mapActions(['getProfile'])
        },
        created() {
            this.getProfile(this.id);
        }
    }
</script>
<style scoped>
    .artist-banner-thumb figure {
        border-radius: 50%;
    }

    .artist-banner .text-overflow {
        margin-top: 10px;
    }

    .artist-banner .artist-name {
        width: auto;
    }

    .artist-banner .artist-name .label {
        padding: 4px 10px;
        font-size: 13px;
        margin-bottom: 3px;
        display: inline-block;
        float: right;
        margin-top: 10px;
        margin-left: 12px;
        background-color: #bbad07;
    }

    .container .action-group {
        margin: 16px 0 0 0;
    }

    .artist-banner-thumb .text-overflow p {
        font-size: 14px;
    }
</style>
