<?php

#region rest_api_init
add_action("rest_api_init", function () {
    register_rest_route('pp_opts/v1', 'currencies', [
        'methods'           => WP_REST_SERVER::READABLE,
        'callback'          => 'filter_currencies',
    ]);
    register_rest_route('pp_opts/v1', 'cryptocurrencies', [
        'methods'           => WP_REST_SERVER::READABLE,
        'callback'          => 'filter_cryptocurrencies',
    ]);
});
#endregion

#region filter_currencies
function filter_currencies() {
    $pp_opts                = get_option('pp_opts');
    $currencies             = $pp_opts['currencies'];
    $q                      = explode(',', sanitize_text_field($_GET['code']));

    $codes                  = [];
    $options                = [];

    foreach ($currencies as $key => $value) {
        $code               = $value['code'];
        $title              = $value['title'];
        $price              = $value['price'];
        $profit             = $value['profit'];

        $codes[]            = $code;

        if (in_array($code, $q)) {
            $options[]      = [
                "text"      => $title,
                "value"     => $price + ($price * ($profit / 100)),
                "id"        => $profit,
            ];
        }
    }

    return [
        "q"                 => $q,
        "count"             => count($options),
        'options'           => $options,
    ];
}
#endregion

#region filter_cryptocurrencies
function filter_cryptocurrencies() {
    $pp_opts                = get_option('pp_opts');
    $currencies             = $pp_opts['currencies'];
    $crypto_currencies      = $pp_opts['crypto_currencies'];
    $q                      = explode(',', sanitize_text_field($_GET['code']));
    $dollarPriceInRials     = null;
    // $uniq_ids               = [];
    $codes                  = [];
    $options                = [];

    foreach ($currencies as $_ => $value) {
        if ($value['code'] == 'sana_sell_usd') {
            $dollarPriceInRials = $value['price'];
        }
    }
    foreach ($crypto_currencies as $_ => $value) {
        $uniq_id            = $value['uniq_id'];
        $code               = $value['code'];
        $title              = $value['title'];
        $price              = $value['price'];
        $profit             = $value['profit'];
        $codes[]            = $code;

        if (in_array($uniq_id, $q)) {
            $options[] = [
                "text" => $title,
                "value" => ($price + ($price * ($profit / 100))) * $dollarPriceInRials,
                "id" => $profit,
            ];
        }
    }

    return [
        "q" => $q,
        "count" => count($options),
        'options' => $options,
    ];
}
#endregion