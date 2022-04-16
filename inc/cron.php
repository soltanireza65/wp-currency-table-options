<?php

use function PHPSTORM_META\type;

$pp_opts = get_option('pp_opts');

$is_remote = $pp_opts['is_remote'];
$crypto_is_remote = $pp_opts['crypto_is_remote'];

// echo "<pre>";
// print_r($crypto_currencies);
// echo "</pre>";
// die();

#region update_currencies
// Check if its optimized
if ($is_remote) {
    if (!wp_next_scheduled('update_currencies_hook')) wp_schedule_event(time(), 'currencies', 'update_currencies_hook');
    add_action('update_currencies_hook', 'update_currencies');
    function update_currencies() {
        $pp_opts = get_option('pp_opts');
        $is_remote = $pp_opts['is_remote'];

        if (!$is_remote) return;
        $token = $pp_opts['token'];

        $cmc_single_settings_options = get_option('cmc_single_settings_options');
        $cmc_single_settings_options = unserialize($cmc_single_settings_options, []);

        $reccurence = $pp_opts['reccurence'];
        $currencies = $pp_opts['currencies'];

        $service_provider = $pp_opts['service_provider'];
        // $codes = [];
        // $result = [];
        // $data = [];
        // $page = 1;
        // $hasNextPage = true;


        switch ($service_provider) {
            case 'tgju':
                $codes = [];
                $data = [];
                $page = 1;
                $hasNextPage = true;
                while ($hasNextPage) {
                    $url = 'https://api.tgju.online/v1/data/sana/json/?page=' . $page;
                    $data = wp_remote_get(esc_url($url), [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $token,
                        ],
                    ]);
                    $body = wp_remote_retrieve_body($data);
                    $decoded = json_decode($body, true);
                    $tempData = $decoded['common']['data'];
                    // echo "<pre>";
                    // print_r($decoded['common']['data']);
                    // echo "</pre>";
                    // die();
                    $data = array_merge($data, $tempData);
                    $hasNextPage = $decoded['common']['next_page_url'] === null ? false : true;
                    $page = $page + 1;
                }
                if (!is_array($data) || empty($data) || count($data) < 1) return;

                foreach ($currencies as $index => $currency) {
                    $code = $currency['code'];
                    $codes[] = $code;

                    foreach ($data as $_ => $value) {
                        $slug = $value['slug'];
                        $p = $value['p'];

                        if ($code == $slug) {
                            $pp_opts['currencies'][$index]['price'] = $p;
                            $pp_opts['currencies'][$index]['updated_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                        }
                    }
                    if ($code == "sana_sell_usd") {
                        $cmc_single_settings_options['coin_market_cap_gold_toman_price_setting_option'] = $currency['price'];;
                    }
                }


                $cmc_single_settings_options = serialize($cmc_single_settings_options);


                update_option('pp_opts', $pp_opts);
                echo "update_currencies_hook";
                update_option('cmc_single_settings_options', $cmc_single_settings_options);
                break;
            case 'parsijoo':
                $url = "http://parsijoo.ir/api?serviceType=price-API&query=Currency";
                $data = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);

                $encoded = json_encode($data);
                $decoded = json_decode($encoded, true);
                // echo "<pre>";
                // print_r($decoded['sadana-services']['price-service']['item']);
                // echo "</pre>";
                // die();
                $items = $decoded['sadana-services']['price-service']['item'] ?? [];

                if (!is_array($items) || empty($items) || count($items) < 1) return;

                foreach ($currencies as $index => $currency) {
                    $code = $currency['code'];
                    $parsijoo_title = $currency['parsijoo_title'];
                    $codes[] = $code;

                    foreach ($items as $_ => $value) {
                        $name = $value['name'];
                        $price = $value['price'];
                        if ($parsijoo_title == $name) {
                            $pp_opts['currencies'][$index]['price'] = $price;
                            $pp_opts['currencies'][$index]['updated_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                        }
                    }
                    if ($code == "sana_sell_usd") {
                        $cmc_single_settings_options['coin_market_cap_gold_toman_price_setting_option'] = $currency['price'];;
                    }
                }

                $cmc_single_settings_options = serialize($cmc_single_settings_options);

                update_option('pp_opts', $pp_opts);
                update_option('cmc_single_settings_options', $cmc_single_settings_options);
                break;
        }
    }
}
// update_currencies();
#endregion

#region update_crypto_currencies
// Check if its optimized
if ($crypto_is_remote) {
    if (!wp_next_scheduled('update_crypto_currencies_hook')) wp_schedule_event(time(), 'crypto_currencies', 'update_crypto_currencies_hook');
    add_action('update_crypto_currencies_hook', 'update_crypto_currencies');
    function update_crypto_currencies() {
        $pp_opts = get_option('pp_opts');
        $crypto_is_remote = $pp_opts['crypto_is_remote'];
        if (!$crypto_is_remote)  return;
        $crypto_reccurence = $pp_opts['crypto_reccurence'];
        $crypto_currencies = $pp_opts['crypto_currencies'];

        $token = $pp_opts['crypto_token'];
        $url = 'https://gateway.accessban.com/public/web-service/list/crypto?format=json&limit=10400&page=1';
        $codes = [];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization' => 'Bearer ' . $token
            ),
        ));


        $response = curl_exec($curl);
        $temp = json_decode($response, true);
        curl_close($curl);
        $data = $temp['data'];


        // $result = wp_remote_get($url, [
        //     'headers' => [
        //         'Authorization' => 'Bearer ' . $token,
        //     ],
        // ]);


        if (!is_array($data) || empty($data) || count($data) < 1) return;

        foreach ($crypto_currencies as $index => $currency_item_value) {
            $code = $currency_item_value['code'];
            $codes[] = $code;
            foreach ($data as $_ => $value) {

                $slug = $value['slug'];
                $p = $value['p'];

                if ($code == $slug) {
                    $pp_opts['crypto_currencies'][$index]['price'] = $p;
                    $pp_opts['crypto_currencies'][$index]['updated_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                }
            }
        }

        update_option('pp_opts', $pp_opts);
    }
}
#endregion
