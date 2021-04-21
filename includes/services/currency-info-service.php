<?php

function pc_get_currency_list()
{

    $headers = [
        'Accepts' => 'application/json',
        'X-CMC_PRO_API_KEY' => 'e69b4507-e2f5-4ee5-b519-09a71239ef3d'
    ];
    $arg = array(
        'timeout' => 60,
        'headers' => $headers
    );
    $crypto_map_url = API_URL . '/cryptocurrency/map';
    $crypto_info_url = API_URL . '/cryptocurrency/info';
    $crypto_map_response = wp_remote_get($crypto_map_url, $arg);
    $currency_map_data = json_decode($crypto_map_response['body'], true);
    $currency_ids_list = '';
    $limit = 300;
    $i = 0;
    foreach ($currency_map_data['data'] as $id) {
        if ($i > $limit) {
            break;
        }
        $currency_ids_list .= $id['id'] . ',';
        $i = $i + 1;
    }
    $currency_ids_list = substr($currency_ids_list, 0, -1);
    $parameters = [
        'id' => $currency_ids_list
    ];
    $qs = http_build_query($parameters);
    $request = "{$crypto_info_url}?{$qs}";
    $currency_info_response = wp_remote_get($request, $arg);
    $data = json_decode($currency_info_response['body'], true);
    $arr_of_imgs = $data['data'];

    $currency_list = '';

    foreach ($arr_of_imgs as $item) {
        $currency_list .= '<option value="' . $item['id'] . '" data-symbol="' . $item['symbol'] . '" title="' . $item['name'] . '">' . $item['symbol'] . ' - ' . $item['name'] . '</option>';
    }

    $currency_list .= '';

    echo $currency_list;

    wp_die();
}