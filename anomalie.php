<?php
// Specifica i dati dell'API di WooCommerce
$url = 'https://servizi.wpschool.it/wp-json/wc/v3/products';
$username = 'ck_fe204273ad276fc9c7a5e36ad96765b26bbce88b';
$password = 'cs_1ceae7502d5becd86f21d13c215d97f49d8989ff';


// Crea un'istanza di cURL
$ch = curl_init();

// Imposta le opzioni di cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Esegui la chiamata API
$response = curl_exec($ch);
include('header.php');
?>




<div class=" container table-responsive pt-3">
    <div class="table-wrapper">
        <?php
        if ($response === false) {
            $error = curl_error($ch);
            // Gestisci l'errore
        } else {
            $products = json_decode($response);
            //crea la tabella HTML
        ?>
            <table id="my-table" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Prezzo</th>
                        <th scope="col">Magazzino</th>
                        <!-- <th>Azioni</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($products as $product) {
                        if ($product->stock_quantity <= 10 && $product->sku == "") {
                    ?>
                            <tr>
                                <td><?php echo $product->id; ?></td>
                                <td><?php echo $product->sku; ?></td>
                                <td><?php echo $product->name; ?></td>
                                <td><?php echo $product->price; ?></td>
                                <td><?php echo $product->stock_quantity; ?></td>
                                <!-- <td> </td> -->
                            </tr>
                <?php
                        }
                    }
                    // Chiudi la connessione cURL
                    curl_close($ch);
                }
                ?>
                </tbody>
                <!-- <tfoot>
                    <tr>
                        <td colspan="2">
                            <div id="pagination"></div> Pagination links will be inserted here
                        </td>
                    </tr>
                </tfoot> -->
            </table>
    </div>
</div>

<?php
include('footer.php');
?>