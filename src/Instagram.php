<?php

namespace Iagoronanvs;

class Instagram {
    public static function handler($account) {
        $response = file_get_contents("https://www.instagram.com/$account/");

        $data = explode("window._sharedData = ", $response)[1];

        $data = explode("\x3c/script>", $data)[0];

        $data = str_replace(";", "", $data);

        $data = json_decode($data);

        return $data;
    }
}