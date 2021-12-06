<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CouchDB</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <img class="logo" src="./images/logo-couchdb.png" alt="Couch DB">

            <a class="navbar-brand" href="#">CouchDB</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="create.php">Create</a>
                    <a class="nav-item nav-link" href="#">About Team</a>
                </div>
            </div>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav>
    </header>

    <div>
        <div class="container">

            <!--=====================DANH SÁCH SẢN PHẨM============================-->
            <?php 
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
            
                for($i = 0 ; $i < $_response['total_rows'] ; ++$i) {
                    $id = $_response['rows'][$i]['id'];
            
                    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/database/'.$id);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-type: application/json',
                        'Accept: */*'
                    ));
                    
                    curl_setopt($ch, CURLOPT_USERPWD, 'dangkhoatptp:dangkhoatptp');
                    
                    $response_temp = curl_exec($ch);
            
                    $d = json_decode($response_temp, true);
            
                    
                    echo '<div class="card" style="width: 18rem;">';
                        echo '<img class="card-img-top"';
                            echo 'src="'.$d['image'].'"';
                            echo 'alt="Card image cap">';
                        echo '<div class="card-body">';
                            echo '<h5 class="card-title">'.$d['title'].'</h5>';
                            echo '<p class="card-text">'.$d['description'].'</p>';
                            echo '<div class="card-rates">'.$d['rates'].' đ</div>';
                            echo '<div class="btn">';
                                echo '<a href="delete.php?id='.$d['_id'].'" class="btn btn-primary">Delete</a>';
                                echo '<a href="edit.php?id='.$d['_id'].'" class="btn btn-primary">Edit</a>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }


                
            ?>
        </div>
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