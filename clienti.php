<?php
include('./phpqrcode/qrlib.php');
// Specifica i dati dell'API di WooCommerce
$url = 'https://servizi.wpschool.it/wp-json/wc/v3/customers';
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
        } else {
            $customers = json_decode($response);
        ?>
            <table id="my-table" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Telefono</th>
                        <th>Indirizzo</th>
                        <th>Mail </th>
                        <th>QrCode</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($customers as $customer) {
                    ?>
                        <tr>
                            <td><?php echo $customer->id; ?></td>
                            <td><?php echo $customer->first_name; ?></td>
                            <td><?php echo $customer->last_name; ?></td>
                            <td><?php echo $customer->billing->phone; ?></td>
                            <td><?php echo $customer->billing->address_1; ?></td>
                            <td><?php echo $customer->billing->email; ?></td>
                            <td>
                                <?php
                                $num = $customer->id;
                                $newsku = str_replace(' ', '', $num);
                                $qrimage = $order->number . ".png";
                                QRCODE::png("./product_qr/" . $newsku, $qrimage, 1, 2);
                                ?>
                                <button type="button" class="btn" data-toggle="modal" data-target=".bd-example-modal-sm"><img src="<?php echo $qrimage ?>" /></button>
                                <div class="modal fade bd-example-modal-sm" id="prova" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <img src="<?php echo $qrimage ?>" />
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                <?php
                    }
                    // Chiudi la connessione cURL
                    curl_close($ch);
                }
                ?>
                </tbody>
                <!-- <tfoot>
                    <tr>
                        <td colspan="2">
                            <div id="pagination"></div>
                        </td>
                    </tr>
                </tfoot> -->
            </table>
    </div>
</div>
</div>

<?php
include('footer.php');
?>