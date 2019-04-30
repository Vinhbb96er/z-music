<template>
    <aside class="right-bar-element">
        <topic-hot></topic-hot>
        <music-ranking></music-ranking>
        <music-video-ranking></music-video-ranking>
        <album-ranking></album-ranking>
    </aside>
</template>
<script>
    import MusicRanking from './MusicRanking.vue'
    import MusicVideoRanking from './MusicVideoRanking.vue'
    import AlbumRanking from './AlbumRanking.vue'
    import TopicHot from './TopicHot.vue'

    export default {
        components: {
            MusicRanking,
            MusicVideoRanking,
            AlbumRanking,
            TopicHot
        }
    }
</script>
<style>

</style>
