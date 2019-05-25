<?php

if (!function_exists('checkExistsRemoteImage')) {
    function checkExistsRemoteImage($url)
    {
        if (@getimagesize($url)) {
            return true;
        }

        return false;
    }
}
