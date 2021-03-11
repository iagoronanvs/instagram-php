<?php

namespace Iagoronanvs;

class Instagram {
    private $profile;

    function __construct($account) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables=%7B%22id%22%3A%22".$account."%22%2C%22first%22%3A12%2C%22after%22%3A%22QVFCSmQ3SE56OFllMUJhdlM5TEFBT19sU0hBS3Q4UzJIbkdTMjhtRUluYWlpYllNTGF2NHV0UFY1VGFDMGo0bG5jcm9BWnh4Vk9vNDN5SjJSem9pZXhXQg%3D%3D%22%7D");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        curl_close($ch);
        
        $this->profile = json_decode($response);
    }

    public function feed() {
        $arr = [];

        $posts = $this->profile->data->user->edge_owner_to_timeline_media->edges;

        foreach($posts as $post) {

            $parsePost = (object) [
                "image" => $post->node->display_url,
                "description" => $post->node->edge_media_to_caption->edges[0]->node->text,
                "date" => $post->node->taken_at_timestamp,
                "likes" => $post->node->edge_media_preview_like->count,
                "comments" => $post->node->edge_media_to_comment->count,
                "url" => 'https://www.instagram.com/p/'.$post->node->shortcode.'/',
            ];

            array_push($arr, $parsePost);
        }

        return $arr;
    }
}