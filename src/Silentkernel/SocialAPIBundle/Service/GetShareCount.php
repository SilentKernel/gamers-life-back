<?php

namespace Silentkernel\SocialAPIBundle\Service;

class GetShareCount
{
    public function get_likes($url) {
        $json_string = file_get_contents('https://api.facebook.com/method/links.getStats?urls=' . $url . '&format=json');
        $json = json_decode($json_string, true);
        if(isset($json[0]['total_count'])){
            return intval( $json[0]['total_count'] );
        } else { return 0;}
    }

    public function get_tweets($url) {
        $json_string = file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url=' . $url);
        $json = json_decode($json_string, true);
        if(isset($json['count'])){
            return intval( $json['count'] );
        } else {return 0;}
    }

    public function get_plusones($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        $curl_results = curl_exec ($curl);
        curl_close ($curl);

        $json = json_decode($curl_results, true);
        if(isset($json[0]['result']['metadata']['globalCounts']['count'])){
            return intval( $json[0]['result']['metadata']['globalCounts']['count'] );
        } else {return 0;}
    }
}