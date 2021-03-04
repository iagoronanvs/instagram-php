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
        $arr = [];

        $posts =  $this->profile->entry_data->ProfilePage[0]->graphql->user->edge_owner_to_timeline_media->edges;

        foreach($posts as $post) {

            $parsePost = (object) [
                "image" => $post->node->display_url,
                "description" => $post->node->edge_media_to_caption->edges[0]->node->text,
                "date" => $post->node->taken_at_timestamp,
                "likes" => $post->node->edge_liked_by->count,
                "comments" => $post->node->edge_media_to_comment->count,
                "url" => 'https://www.instagram.com/p/'.$post->node->shortcode.'/',
            ];

            array_push($arr, $parsePost);
        }

        return $arr;
    }
}