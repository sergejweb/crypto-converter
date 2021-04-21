<?php

function pc_set_conversion_history()
{
    global $wpdb;
    $now                     = current_time( 'mysql' );
    $history                 = $_POST;
    $currency                = $history['currency'];
    $converted                 = $history['convert'];
    $amount                  = $history['amount'];

    $wpdb->insert(
        $wpdb->prefix . 'crypto_converter',
        [
            'currency'              => $currency,
            'converted'             => $converted,
            'amount'                => $amount,
            'convert_date'          => $now
        ]
    );

    wp_die();
}

