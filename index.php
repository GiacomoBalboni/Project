<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>RestAPI</title>
    <link rel="icon" href="img/logo_transparent.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <link rel="stylesheet" href="css/mdb.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <a class="navbar-brand mt-2 mt-lg-0 pr-0" href="./index.php">
                    <img src="./img/logo_site.png" height="50" width="150" alt="Logo" loading="lazy" />
                </a>
            </div>
        </div>
    </nav>

    <div class="row row-cols-1 row-cols-md-3 g-4 pt-4 pb-4 text-center">
        <div class="col pr-0">
            <div class="card ">
                <div class="card-body">
                    <h5 class="card-title">Clienti</h5>
                    <p class="card-text">
                        Lista dei clienti del negozio
                    </p>
                    <a href="./clienti.php" class="btn btn-primary">Apri</a>
                </div>
            </div>
        </div>
        <div class="col pr-0">
            <div class="card ">
                <div class="card-body">
                    <h5 class="card-title">Prodotti</h5>
                    <p class="card-text">
                        Lista dei prodotti nel magazzino
                    </p>
                    <a href="./product.php" class="btn btn-primary">Apri</a>
                </div>
            </div>
        </div>
        <div class="col pr-0">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ordini</h5>
                    <p class="card-text">
                        Lista degli ordini del negozio
                    </p>
                    <a href="./order.php" class="btn btn-primary">Apri</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row container">
        <h3>Categorie</h3>
        <div class="col-4">
            <div class="list-group list-group-light" id="list-tab" role="tablist">
                <?php
                // Specifica i dati dell'API di WooCommerce
                $url = 'https://servizi.wpschool.it/wp-json/wc/v3/products/categories';
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
                    $categories = json_decode($response);
                    //crea la tabella HTML
                    foreach ($categories as $category) {
                ?>
                        <a class="list-group-item list-group-item-action px-3 border-0" id="list-home-list" data-mdb-toggle="list" href="#list-home" role="tab" aria-controls="list-home"><?php echo $category->name; ?></a>
                <?php
                    }
                    // Chiudi la connessione cURL
                    curl_close($ch);
                }
                ?>
            </div>
        </div>
        <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                    <?php
                    $url = 'https://servizi.wpschool.it/wp-json/wc/v3/products?category=' . $category->name . '';
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
                        $products = json_decode($response);
                        //crea la tabella HTML
                        foreach ($products as $product) {
                    ?>
                            <div class="card  ">
                                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                    <img src="https://mdbootstrap.com/img/new/standard/nature/111.webp" class="img-fluid" />
                                    <a href="#!">
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
                                    </a>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $product->name; ?></h5>
                                    <p class="card-text">
                                        <?php
                                        echo $product->description;
                                        ?>
                                    </p>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    curl_close($ch);
                    ?>
                </div>
                <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                    <?php
                    $url = 'https://servizi.wpschool.it/wp-json/wc/v3/products?category=' . $category->name . '';
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
                        $products = json_decode($response);
                        //crea la tabella HTML
                        foreach ($products as $product) {
                    ?>
                            <div class="card  ">
                                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                    <img src="https://mdbootstrap.com/img/new/standard/nature/111.webp" class="img-fluid" />
                                    <a href="#!">
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
                                    </a>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $product->name; ?></h5>
                                    <p class="card-text">
                                        <?php
                                        echo $product->description;
                                        ?>
                                    </p>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    curl_close($ch);
                    ?>
                </div>
                <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                    <?php
                    $url = 'https://servizi.wpschool.it/wp-json/wc/v3/products?category=' . $category->name . '';
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
                        $products = json_decode($response);
                        //crea la tabella HTML
                        foreach ($products as $product) {
                    ?>
                            <div class="card  ">
                                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                    <img src="https://mdbootstrap.com/img/new/standard/nature/111.webp" class="img-fluid" />
                                    <a href="#!">
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
                                    </a>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $product->name; ?></h5>
                                    <p class="card-text">
                                        <?php
                                        echo $product->description;
                                        ?>
                                    </p>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    curl_close($ch);
                    ?>
                </div>
                <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                    <?php
                    $url = 'https://servizi.wpschool.it/wp-json/wc/v3/products?category=' . $category->name . '';
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
                        $products = json_decode($response);
                        //crea la tabella HTML
                        foreach ($products as $product) {
                    ?>
                            <div class="card  ">
                                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                    <img src="https://mdbootstrap.com/img/new/standard/nature/111.webp" class="img-fluid" />
                                    <a href="#!">
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
                                    </a>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $product->name; ?></h5>
                                    <p class="card-text">
                                        <?php
                                        echo $product->description;
                                        ?>
                                    </p>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    curl_close($ch);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('footer.php');
    ?>