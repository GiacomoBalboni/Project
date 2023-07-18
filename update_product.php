<?php
    $id = $_POST['id'];
    $price = $_POST["prezzo"];
    $stock_quantity = $_POST["giacenza"];

    $url = 'https://servizi.wpschool.it/wp-json/wc/v3/products/'.$id;
    $username = 'ck_fe204273ad276fc9c7a5e36ad96765b26bbce88b';
    $password = 'cs_1ceae7502d5becd86f21d13c215d97f49d8989ff';

    $data = array(
        "id" => $id,
        "regular_price" => $price,
        "stock_quantity" => $stock_quantity
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
    } else {
        header("Location: https://wpschool.it/gestionalewoo/balbons/product.php");
    }

    curl_close($ch);