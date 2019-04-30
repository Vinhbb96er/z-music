import axios from 'axios'

const makeUrl = function (url) {
    const baseApiUrl = window.Laravel.base_url + '/api/'

    return baseApiUrl.concat(url)
}

export function get(url) {
    return axios({
        method: 'GET',
        url: makeUrl(url)
    })
}

export function post(url, payload = '') {
    return axios({
        method: 'POST',
        url: makeUrl(url),
        data: payload
    })
}

export function patch(url, payload = '') {
    return axios({
        method: 'PATCH',
        url: makeUrl(url),
        data: payload
    })
}

export function put(url, payload = '') {
    return axios({
        method: 'PUT',
        url: makeUrl(url),
        data: payload
    })
}

export function del(url, payload = '') {
    return axios({
        method: 'DELETE',
        url: makeUrl(url),
        data: payload
    })
}

export function makePathByParams(path, params) {
    if (!params) {
        return path;
    }

    path = `${path}?`;

    var paramName = Object.keys(params);
    var paramValue = Object.values(params);

    paramName.forEach(function (name, key) {
        path += `${name}=${paramValue[key]}`;

        if (key < paramName.length - 1) {
            path += '&';
        }
    });

    return path;
}
