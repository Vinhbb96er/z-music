import {get, makePathByParams} from '../../api/base_api.js'
import {i18n} from '../../lang/index.js'

const state = {
    playlist: [],
    repeatMode: false,
    randomMode: false,
    playingIndex: 0,
    audio: null,
    player: null,
    isPlaying: false,
    checkPlayingThisMusic: false,
    isView: false,
    startPlay: 0
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
    },
    checkPlayingMusic: state => (musicId) => {
        if (!state.playlist.length || !state.isPlaying) {
            return false;
        }

        return state.playlist[state.playingIndex].id == musicId;
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
    initPlayer({commit, dispatch, state, getters, rootState}) {
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
            state.startPlay = state.audio.currentTime;
            state.isView = true;
        }).on('timeupdate', function () {
            let totalTimePlay = ((state.audio.currentTime - state.startPlay) / state.audio.duration) * 100;

            if (state.isView && totalTimePlay > 70) {
                state.isView = false;
                var currentPlaying = state.playlist[state.playingIndex];

                dispatch('upViewMedia', currentPlaying.id, {root: true})
                    .then(function (value) {
                        currentPlaying.views = value;
                        let mediaDetail = rootState.Media.mediaDetailData;

                        if (mediaDetail && mediaDetail.id == currentPlaying.id) {
                            mediaDetail.views = value;
                        }
                    });
            }
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
            get(makePathByParams('media/playlist', data))
                .then(res => {
                    let newMusics = res.data.filter(function (item) {
                        let index = state.playlist.findIndex(function (music) {
                            return music.id == item.id;
                        });

                        return index == -1;
                    });

                    if (!newMusics.length) {
                        if (data.type == window.Laravel.setting.album.media_type) {
                            return alertWarning({message: i18n.t('message.album_exists_in_playlist')});
                        }

                        let index = state.playlist.findIndex(function (music) {
                            return music.id == res.data[0].id;
                        });

                        dispatch('playMusic', index);

                        return;
                    }

                    state.playlist = state.playlist.concat(newMusics);
                    dispatch('playMusic', state.playlist.length - newMusics.length);
                    flashMessage('Thêm nhạc vào danh sách phát thành công');
                })
                .catch(err => {
                    reject(err);
                });
        });

    },
    removeMusicFromPlaylist({commit, dispatch, state}, index) {
        state.playlist.splice(index, 1);

        if (index == state.playingIndex) {
            dispatch('playMusic', state.playingIndex);
        }
    },
    pauseMusic({commit, state}) {
        state.audio.pause();
    },
    playingMusic({commit, dispatch, state}, data) {
        var index = state.playlist.findIndex(function(music, index) {
            return music.id == data.id;
        });

        if (index != -1) {
            if (index == state.playingIndex) {
                state.audio.play();
            } else {
                dispatch('playMusic', index);
            }

            return;
        }

        dispatch('addMusicToPlaylist', data);
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
