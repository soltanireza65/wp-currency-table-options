<?php
#region extra_reccurences
function extra_reccurences($schedules) {
    $pp_opts = get_option('pp_opts');

    $reccurence = $pp_opts['reccurence'];
    $crypto_reccurence = $pp_opts['crypto_reccurence'];

    if (isset($reccurence)) {
        $schedules["currencies"] = [
            'interval' => (int)$reccurence * 60,
            'display' => __('currencies')
        ];
    }
    if (isset($crypto_reccurence)) {
        $schedules["crypto_currencies"] = [
            'interval' => (int)$reccurence * 60,
            'display' => __('currencies')
        ];
    }
    return $schedules;
}
add_filter('cron_schedules', 'extra_reccurences');
#endregion