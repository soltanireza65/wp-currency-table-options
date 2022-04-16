<?php
#region pp_get_currency_options
function pp_get_currency_options() {
    $pp_opts = get_option('pp_opts');
    $currencies = $pp_opts['currencies'];

    $codes = [];
    $options = [];

    foreach ($currencies as $_ => $currency) {
        $code = $currency['code'];
        $title = $currency['title'];
        $price = $currency['price'];
        $profit = $currency['profit'];
        $codes[] = $code;
        $options[] = [
            "text" => $title,
            "value" => $price + ($price * ($profit / 100)),
            "id" => $profit,
        ];
    }
    return $options;
}
#endregion