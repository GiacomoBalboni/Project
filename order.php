<?php
include('./phpqrcode/qrlib.php');
// Specifica i dati dell'API di WooCommerce
$url = 'https://servizi.wpschool.it/wp-json/wc/v3/orders';
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
            $orders = json_decode($response);
        ?>
            <table id="my-table" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Totale</th>
                        <th>Valuta</th>
                        <th>Nome</th>
                        <th>Cognome </th>
                        <th>Pagamento</th>
                        <th>Stato</th>
                        <th>Azioni</th>
                        <th>QrCode</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($orders as $order) {
                    ?>
                        <tr>
                            <td><?php echo $order->number; ?></td>
                            <td><?php echo $order->total; ?></td>
                            <td><?php echo $order->currency; ?></td>
                            <td><?php echo $order->billing->first_name; ?></td>
                            <td><?php echo $order->billing->last_name; ?></td>
                            <td><?php echo $order->payment_method_title; ?></td>
                            <td><?php echo $order->status; ?></td>
                            <td>
                                <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal-<?php echo $order->number; ?>"><i class="material-icons">&#xE254;</i></button>
                                <div class="modal fade" id="exampleModal-<?php echo $order->number; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Aggiorna <?php echo $order->billing->last_name; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="./update_order.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $order->id; ?>">
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Stato</label>
                                                        <select name="pets" class="form-control" id="status">
                                                            <?php
                                                            $url = 'https://servizi.wpschool.it/wp-json/wc/v3/orders';
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

                                                            if ($response === false) {
                                                                $error = curl_error($ch);
                                                                // Gestisci l'errore
                                                            } else {
                                                                $orders = json_decode($response);
                                                                //crea la tabella HTML
                                                                foreach ($orders as $order) {
                                                            ?>
                                                                    <option name="status" value="<?php echo $order->status; ?>"><?php echo $order->status; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                                                        <button type="submit" class="btn btn-primary">Salva</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn" data-toggle="modal">
                                    <a <?php echo 'href="./delete_order.php?id=' . $order->number . '"' ?> class="delete" title="Delete" data-toggle="tooltip">
                                        <i class="material-icons">&#xE872;</i></a>
                                </button>
                            </td>
                            <td>
                                <?php
                                $sku = $order->number;
                                $qrimages =  $sku . ".png";;
                                QRCODE::png($sku, $qrimages, 1, 2);
                                ?>
                                <button type="button" class="btn" data-toggle="modal" data-target=".bd-example-modal-sm"><img src="<?php echo $qrimages ?>" /></button>
                                <div class="modal fade bd-example-modal-sm" id="prova" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <img src="<?php echo $qrimages ?>" />
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