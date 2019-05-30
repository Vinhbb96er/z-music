<template>
    <div class="tab-pane active">
        <div class="artist-bio" v-if="profileData">
            <!--Heading 3 Start-->
            <div class="msl-black">
                <div class="heading3">
                    <h4><i class="fa fa-user"></i>{{ $t('auth.introduce') }}</h4>
                </div>
            </div>
            <div class="artist-information">
                <h4 class="artist-name">{{ profileData.name }}</h4>
                <p v-if="profileData.real_name">
                    {{ $t('auth.real_name') }}: {{ profileData.real_name }}
                </p>
                <p v-if="profileData.birthday">
                    {{ $t('auth.birthday') }}: {{ profileData.birthday }}
                </p>
                <p v-if="profileData.description">
                    {{ profileData.description }}
                </p>
                <p v-else>
                    {{ $t('auth.empty_description') }}
                </p>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'

    export default {
        computed: {
            ...mapGetters(['profileData'])
        }
    }
</script>
<style>
    .user-detail .artist-information {
        padding: 0 15px;
        margin-bottom: 45px;
    }

    .user-detail .artist-information .artist-name {
        margin-bottom: 10px;
    }
</style>
