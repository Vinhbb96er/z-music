<template>
    <aside class="right-bar-element">
        <!--Widget Artist Start-->
        <div class="widget widget-artist no-border no-padding">
            <div class="msl-black">
                <div class="msl-heading light-color ranking-header-title">
                    <h5>
                        <span>
                            {{ $t('home.maybe_you_interested') }}
                        </span>
                    </h5>
                </div>
            </div>
        </div>
    </aside>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                type: window.Laravel.setting.media.type.music,
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
                }
            };
        },
        computed: {

        },
        methods: {

        }
    }
</script>
<style scoped>

</style>
