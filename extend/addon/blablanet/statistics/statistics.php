<?php

/**
 * Name: Statistics Federation
 * Description: statistics From Federation
 * Version: 1.0
 * Author: Jacob M.
 */


function statistics_load() {
    register_hook('app_menu', 'addon/statistics/statistics.php', 'statistics_app_menu');
}

function statistics_unload() {
    unregister_hook('app_menu', 'addon/statistics/statistics.php', 'statistics_app_menu');

}

function statistics_app_menu($a,&$b) {
    $b['app_menu'][] = '<div class="app-title"><a href="statistics">Latest statistics</a></div>';
}


function statistics_module() {}


function statistics_content($a) {
    if (argc() > 1 && argv(1) === 'import') {
        logger('statistics import launching');
        return statistics_import($a);
    }

    $a->page['htmlhead'] .= '<link rel="stylesheet"  type="text/css" href="' . $a->get_baseurl() .'" media="all" />' . "\r\n";
    
    $a->page['htmlhead'] .= replace_macros(get_markup_template('jot-header.tpl'), array(
        '$baseurl' => $a->get_baseurl() . '/addon/statistics',
        '$editselect' => 'none',
        '$ispublic' => '&nbsp;', // t('Visible to <strong>everybody</strong>'),
        '$geotag' => '',
        '$nickname' => $channel['channel_address'],
        '$confirmdelete' => t('Delete webpage?')
    ));

    if ($_SESSION['data_cache'] !== null) {
        $data_cache = json_encode($_SESSION['data_cache']);
    } else {
        $data_cache = '';
    }
    $o .= replace_macros(get_markup_template('statistics.tpl', 'addon/statistics'), array(
        '$header' => t('statistics'),
        '$text' => $text,
        '$data_cache' => $data_cache,
        '$loginbox' => login()
    ));

    return $o;
}
