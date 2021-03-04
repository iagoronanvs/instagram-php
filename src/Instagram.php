<?php

namespace Iagoronanvs;

class Instagram {
    private $profile;

    function __construct($account) {
        $response = file_get_contents("https://www.instagram.com/$account/");

        $data = explode("window._sharedData = ", $response)[1];

        $data = explode("\x3c/script>", $data)[0];

        $data = str_replace(";", "", $data);

        $this->profile = json_decode($data);
    }

    public function feed() {
        return $this->profile->entry_data->ProfilePage[0]->graphql->user->edge_owner_to_timeline_media->edges;
    }
}