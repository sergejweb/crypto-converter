<?php

function pc_get_conversion_history()
{
    function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);

    }

    global $wpdb;

    $data = $wpdb->get_results("SELECT currency, converted, amount, convert_date FROM $wpdb->prefix" . "crypto_converter");

    if (!empty($data)){

        $data = array_slice($data, -10);

        $data = array_reverse($data);

        $now  = current_time( 'mysql' );

        $block = '<div class="pc-history">';
        $block .= '<h5>Recently Converted</h5>';

        $block .= '<ul>';

        foreach ($data as $datum) {

            $time_passed = dateDifference($now, $datum->convert_date, '%y years,%m months,%d days,%h hours,%i minutes,%s seconds');

            $time_arr = explode(',', $time_passed);

            $the_time = '1 second';

            foreach ($time_arr as $time) {
                if ( $time[0] !== '0') {
                    $the_time = $time;
                    break;
                }
            }

            $block .= '<li>';
            $block .= '<div>';
            $block .= $datum->amount;
            $block .= '&nbsp;';
            $block .= '<span>' . $datum->currency . '</span>';
            $block .= '&nbsp;to&nbsp;';
            $block .= '<span>' . $datum->converted . '</span>';
            $block .= '</div>';
            $block .= '<div class="pc-list-divider">';
            $block .= '</div>';
            $block .= '<div class="pc-history-time-passed">';
            $block .= $the_time . ' ago';
            $block .= '</div>';
            $block .= '</li>';
        };

        $block .= '</ul>';
        $block .= '</div>';
        echo $block;
    }

    wp_die();
}
