<template>
    <div class="tab-pane active">
        <div class="kode-comment-form">
            <div class="msl-black">
                <div class="heading3">
                    <h4><i class="fa fa-comment-o"></i>{{ $t('media.upload_title') }}</h4>
                </div>
            </div>
            <div class="album-inner type-tab">
                <ul class="nav-tabs msl-tab-nav">
                    <li class="region-title" @click="tabName = 'MusicAndVideo'" :class="{active: tabName == 'MusicAndVideo'}">
                        <a href="#" @click.prevent>{{ $t('media.music_video') }}</a>
                    </li>
                    <li class="region-title" @click="tabName = 'Album'" :class="{active: tabName == 'Album'}">
                        <a href="#" @click.prevent>{{ $t('album.name') }}</a>
                    </li>
                </ul>
            </div>
            <components :is="tabName"></components>
        </div>
    </div>
</template>
<script>
    import MusicAndVideo from './MusicAndVideo.vue'
    import Album from './Album.vue'

    export default {
        data() {
            return {
                tabName: 'MusicAndVideo'
            };
        },
        components: {
            MusicAndVideo,
            Album
        }
    }
</script>
<style scoped>
    .type-tab .nav-tabs {
        margin-bottom: 25px;
        margin-left: 7px;
    }

    .type-tab .nav-tabs li a {
        font-size: 12px;
    }
</style>
