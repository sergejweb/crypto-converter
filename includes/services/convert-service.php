<?php

function pc_get_price()
{
    $amount                     =   $_POST['amount'];
    $id                         =   $_POST['id'];
    $convert_id                 =   $_POST['convert_id'];

    $url                        =   API_URL . '/tools/price-conversion';
    $parameters                 =   [
        'amount'                    =>  $amount,
        'id'                        =>  $id,
        'convert_id'                =>  $convert_id
    ];
    $qs                         =   http_build_query($parameters);
    $request                    =   "{$url}?{$qs}";

    $headers                    =   [
        'Accepts'                   =>  'application/json',
        'X-CMC_PRO_API_KEY'         =>  'e69b4507-e2f5-4ee5-b519-09a71239ef3d'
    ];
    $arg                        =   array(
        'timeout'                   =>  60,
        'headers'                   =>  $headers
    );

    $pc_response                =   wp_remote_get($request, $arg);

    $data                       =   json_decode($pc_response['body'], true);

    echo $data['data']['quote'][$convert_id]['price'];
    wp_die();
}