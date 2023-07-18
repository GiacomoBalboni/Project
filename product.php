<?php
include('./phpqrcode/qrlib.php');
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
                        <th scope="col">Taglia</th>
                        <th scope="col">Giacenza</th>
                        <th scope="col">Azioni</th>
                        <th scope="col">QrCode</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($products as $product) {
                    ?>
                        <tr>
                            <?php
                            if ($product->type == "variable") {
                                $name = $product->name;
                                $id = $product->id;

                                $url = 'https://servizi.wpschool.it/wp-json/wc/v3/products/' . $id . '/variations';
                                $username = 'ck_fe204273ad276fc9c7a5e36ad96765b26bbce88b';
                                $password = 'cs_1ceae7502d5becd86f21d13c215d97f49d8989ff';

                                $chi = curl_init();

                                curl_setopt($chi, CURLOPT_URL, $url);
                                curl_setopt($chi, CURLOPT_USERPWD, $username . ':' . $password);
                                curl_setopt($chi, CURLOPT_RETURNTRANSFER, true);


                                $response = curl_exec($chi);
                                $variables = json_decode($response);

                                foreach ($variables as $variable) {
                            ?>
                                    <td><?php echo $variable->id; ?></td>
                                    <td><?php echo $variable->sku; ?></td>
                                    <td><?php echo $name; ?></td>
                                    <td><?php echo $variable->price; ?></td>
                                    <td><?php echo $variable->attributes[0]->option ?></td>
                                    <td><?php echo $variable->stock_quantity; ?></td>
                                    <td>
                                        <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal-<?php echo $variable->id; ?>"><i class="material-icons">&#xE254;</i></button>
                                        <div class="modal fade" id="exampleModal-<?php echo $variable->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Aggiorna <?php echo $name . " " . $variable->attributes[0]->option; ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="./update_variable_product.php" method="post">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                                                            <input type="hidden" name="variation_id" value="<?php echo $variable->id; ?>">
                                                            <div class="form-group">
                                                                <label for="message-text" class="col-form-label">Nome</label>
                                                                <input type="text" class="form-control" name="nome" value="<?php echo $name; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="message-text" class="col-form-label">Giacenza</label>
                                                                <input type="number" name="giacenza" class="form-control" value="<?php echo $variable->stock_quantity; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="message-text" class="col-form-label">Taglia</label>
                                                                <input type="text" name="attribute" class="form-control" value="<?php echo $variable->attributes[0]->option; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="message-text" class="col-form-label">Prezzo</label>
                                                                <input type="number" name="prezzo" class="form-control" value="<?php echo $variable->price; ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                                                                <button type="submit" class="btn btn-primary">Salva</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn" data-toggle="modal">
                                            <a <?php echo 'href="./delete_product_variable.php?id=' . $variable->id . '&variable_id=' . $variable->id . '"' ?> class="delete" title="Delete" data-toggle="tooltip">
                                                <i class="material-icons">&#xE872;</i></a>
                                        </button>
                                    </td>
                                    <td>
                                        <?php
                                        $sku = $variable->sku;
                                        $newsku = str_replace(' ', '', $sku);
                                        $qrimages = $variable->sku . ".png";;
                                        QRCODE::png(" ./product_qr/ " . $newsku, $qrimages, 1, 2);
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
                            } else {
                    ?>
                    <tr>
                        <td><?php echo $product->id; ?></td>
                        <td><?php echo $product->sku; ?></td>
                        <td><?php echo $product->name; ?></td>
                        <td><?php echo $product->price; ?></td>
                        <td><?php echo $product->attributes[0]->option ?></td>
                        <td><?php echo $product->stock_quantity; ?></td>
                        <td>
                            <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal-<?php echo $product->id; ?>"><i class="material-icons">&#xE254;</i></button>
                            <div class="modal fade" id="exampleModal-<?php echo $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Aggiorna <?php echo $product->name . " " . $variable->attributes[0]->option; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="./update_product.php" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Nome</label>
                                                    <input type="text" class="form-control" name="nome" value="<?php echo $product->name; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Giacenza</label>
                                                    <input type="number" class="form-control" name="giacenza" value="<?php echo $product->stock_quantity; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Prezzo</label>
                                                    <input type="number" class="form-control" name="prezzo" value="<?php echo $product->price; ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                                                    <button type="submit" class="btn btn-primary">Salva</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn" data-toggle="modal">
                                <a <?php echo 'href="./delete_product.php?id=' . $product->id . '"' ?> class="delete" title="Delete" data-toggle="tooltip">
                                    <i class="material-icons">&#xE872;</i></a>
                            </button>
                        </td>
                        <td>
                            <?php
                                $sku = $product->sku;
                                $newsku = str_replace(' ', '', $sku);
                                $qrimages = $newsku . ".png";
                                QRCODE::png("./products_qr/" . $newsku, $qrimages, 1, 2);
                            ?>
                            <button type="button" class="btn" data-toggle="modal" data-target=".bd-example-modal-sm"><img src="<?php echo $qrimages ?>" /></button>
                            <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                        }
                    }
                    curl_close($ch);
        ?>
        <tr>
            </tbody>
                <tfoot>
                    <th scope="col">Id</th>
                    <th scope="col">SKU</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Taglia</th>
                    <th scope="col">Giacenza</th>
                    <th scope="col">Azioni</th>
                    <th scope="col">QrCode</th>
                    </tr>
                </tfoot>
            </table>
    </div>
</div>

<?php
include('footer.php');
?>