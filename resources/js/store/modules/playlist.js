import {get} from '../../api/base_api.js'

const state = {
    playlist: [],
    repeatMode: false,
    randomMode: false,
    playingIndex: 0,
    audio: null,
    player: null,
    isPlaying: false,
}

const getters = {
    playlist(state) {
        return state.playlist;
    },
    repeatMode(state) {
        return state.repeatMode;
    },
    randomMode(state) {
        return state.randomMode;
    },
    playingIndex(state) {
        return state.playingIndex;
    },
    playlistLength(state) {
        return state.playlist.length;
    },
    audio(state) {
        return state.audio;
    },
    player(state) {
        return state.player;
    },
    randomMusicIndex(state) {
        let randomIndex;

        do {
            randomIndex = Math.round(Math.random() * (state.playlist.length - 1));
        } while(randomIndex == state.playingIndex)

        return randomIndex;
    },
    isPlaying(state) {
        return state.isPlaying;
    }
}

const mutations = {
    setIsPlaying(state, value) {
        state.isPlaying = value;
    }
}

const actions = {
    changeRepeatMode({state}) {
        state.repeatMode = !state.repeatMode;
    },
    changeRandomMode({state}) {
        state.randomMode = !state.randomMode;
    },
    loadMusic({commit, state}, index) {
        state.playingIndex = index;
        let title = `${state.playlist[index].name} - ${state.playlist[index].user.name}`;
        $('#music-player-element #music-title').text(title);
        $('#music-player-element #music-title').attr('title', title);
        state.audio.src = state.playlist[index].url;
    },
    playMusic({commit, dispatch, state}, index) {
        dispatch('loadMusic', index);
        state.audio.play();
    },
    initPlayer({commit, dispatch, state, getters}) {
        state.player = new Plyr('#music-player', {
            controls: [
                'play',
                'current-time',
                'progress',
                'duration',
                'mute',
                'volume',
                'settings',
                'download'
            ]
        });

        state.audio = $('#music-player').on('play', function () {
            commit('setIsPlaying', true);
        }).on('pause', function () {
            commit('setIsPlaying', false);
        }).on('ended', () => {
            if ((getters.playingIndex + 1) < getters.playlistLength) {
                let index = state.randomMode
                    ? getters.randomMusicIndex
                    : getters.playingIndex + 1;

                dispatch('playMusic', index);
            } else if (getters.repeatMode) {
                dispatch('playMusic', 0);
            }
        }).get(0);
    },
    prevMusic({commit, dispatch, getters}) {
        if (getters.playlistLength <= 1) {
            return;
        }

        let index = getters.playingIndex;

        if ((getters.playingIndex - 1) > -1) {
            index = getters.randomMode
                ? getters.randomMusicIndex
                : getters.playingIndex - 1;
        } else {
            index = getters.playlistLength - 1;
        }

        dispatch('playMusic', index);
    },
    nextMusic({commit, dispatch, getters}) {
        if (getters.playlistLength <= 1) {
            return false;
        }

        let index = getters.playingIndex;

        if ((getters.playingIndex + 1) < getters.playlistLength) {
            index = getters.randomMode
                ? getters.randomMusicIndex
                : getters.playingIndex + 1;
        } else {
            index =  0;
        }

        dispatch('playMusic', index);
    },
    addMusicToPlaylist({commit, dispatch, state}, data) {
        return new Promise((resolve, reject) => {
            get(`media/${data.id}/get?type=${data.type}`)
                .then(res => {
                    state.playlist = state.playlist.concat(res.data);
                    dispatch('playMusic', state.playlist.length - res.data.length);
                })
                .catch(err => {
                    reject(err);
                });
        });

    },
    removeMusicFromPlaylist({commit, state}, index) {
        state.playlist.splice(index, 1);
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
