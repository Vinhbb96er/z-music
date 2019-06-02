<template>
    <div class="widget widget-artist">
        <!--Heading Start-->
        <div class="msl-black">
            <div class="msl-heading light-color ranking-header-title">
                <h5>
                    <span>
                        <a href="#">
                            {{ $t('home.topic_hot') }}
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </span>
                </h5>
            </div>
        </div>
        <!--Heading End-->
        <!--Artist Rank List Start-->
        <div class="topic-hot-element">
            <div class="card-group">
                <div class="card-item" v-for="(topic, index) in topicHot">
                    <router-link tag="a" :to="{name: 'categoryTopic', params: {id: topic.id}}">
                        <figure class="backgroud-image-show" :style="{backgroundImage: `url(${topic.cover_image})`}">
                            <span class="card-gradient-background" :class="'gradient-background-' + (index + 1)"></span>
                        </figure>
                        <h4 class="card-title">{{ topic.name }}</h4>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {};
        },
        computed: {
            ...mapGetters(['topicHot'])
        },
        methods: {
            ...mapActions(['getTopicHot'])
        },
        created() {
            this.getTopicHot();
        }
    }
</script>
<style>

</style>
