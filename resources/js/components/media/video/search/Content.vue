<template>
    <div class="album-inner video-search">
        <!--Music Album Inner Nav End-->
        <div class="grid-container-small">
            <router-link class="grid-item" v-for="video in data" tag="div" :to="{name: 'videoDetail', params: {id: video.id}}" :key="video.id">
                <div class="msl-featured-thumb video-list-thumb">
                    <figure>
                        <img src="#" :style="{backgroundImage: `url(${video.cover_image})`}">
                        <a class="video-play" href="#"><i class="icon-multimedia-1"></i></a>
                    </figure>
                    <div class="text">
                        <h4 class="featured-title" :title="video.name">
                            <router-link tag="a" :to="{name: 'videoDetail', params: {id: video.id}}">
                                {{ video.name }}
                            </router-link>
                        </h4>
                        <!--Featured Title End-->
                        <!--Featured Meta Start-->
                        <div class="blog-post-meta">
                            <div class="blog-info blog-admin">
                                <router-link tag="a" :to="{name: 'profileShow', params: {id: video.user.id}}">
                                    {{ video.user.name }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            data: {
                required: true,
                type: Array
            },
        }
    }
</script>
<style scoped>
    .video-search .grid-container-small .video-list-thumb figure img {
        height: 150px;
    }
</style>
