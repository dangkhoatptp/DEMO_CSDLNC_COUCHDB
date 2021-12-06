<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <img class="logo" src="./images/logo-couchdb.png" alt="Couch DB">
            <a class="navbar-brand" href="../index.html">CouchDB</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link active" href="#">Create</a>
                    <a class="nav-item nav-link" href="#">About Team</a>
                </div>
            </div>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav>
    </header>

    <div class="container">
        <form class="content" action="create.php" method="get">
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input name="title" type="text" class="form-control" id="inputPassword">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <input name="description" type="text" class="form-control" id="inputPassword">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Rates</label>
                <div class="col-sm-10">
                    <input name="rates" type="text" class="form-control" id="inputPassword">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input name="image" class="btn-file" type="file"></input>
                </div>
            </div>
            <div class="btn">
                <input name="submit" type="submit" class="btn btn-primary btn-create" value="Create">
            </div>

        </form>

        <?php
            if(isset($_GET['submit'])) {
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/database/_all_docs');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERPWD, 'dangkhoatptp:dangkhoatptp');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-type: application/json',
                    'Accept: */*'
                ));
                
                $response = curl_exec($ch);

                $_response = json_decode($response, true);

                echo $_response['rows'][$_response['total_rows'] - 1]['id'] + 1;

                $id_new = $_response['rows'][$_response['total_rows'] - 1]['id'] + 1;

                $new_product = array (
                    "_id" => (string)$id_new,
                    "title" => $_GET['title'],
                    "description" => $_GET['description'],
                    "rates" => $_GET['rates'],
                    "image" => $_GET['image']
                );

                $payload = json_encode($new_product, true);

                curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/database/'.$new_product['_id']);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-type: application/json',
                    'Accept: */*'
                ));
                
                curl_setopt($ch, CURLOPT_USERPWD, 'dangkhoatptp:dangkhoatptp');
                
                $response = curl_exec($ch);
                
                curl_close($ch);

                header("Location: index.php");
            }
        ?>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>