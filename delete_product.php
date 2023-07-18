<?php
    $id = $_GET['id'];
    $url = 'https://servizi.wpschool.it/wp-json/wp-json/wc/v3/products/'.$id;
    $username = 'ck_fe204273ad276fc9c7a5e36ad96765b26bbce88b';
    $password = 'cs_1ceae7502d5becd86f21d13c215d97f49d8989ff';

    // Crea un'istanza di cURL  
    $ch = curl_init();

    // Imposta le opzioni di cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");  

    // Esegui la chiamata API
    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        // Gestisci l'errore
    } else {
        header("url=http://wpschool.it/gestionalewoo/balbons/product.php");
    }
    curl_close($ch);
?>