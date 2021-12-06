<?php
    ob_start();
    $id = $_GET['id'];
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/database/'.$id);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-type: application/json',
        'Accept: */*'
    ));
     
    curl_setopt($ch, CURLOPT_USERPWD, 'dangkhoatptp:dangkhoatptp');
     
    $response = curl_exec($ch);

    $_response = json_decode($response, true);

    $database = 'database';

    curl_setopt($ch, CURLOPT_URL, sprintf('http://127.0.0.1:5984/%s/%s?rev=%s', $database, $_response['_id'], $_response['_rev']));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-type: application/json',
        'Accept: */*'
    ));
    
    curl_setopt($ch, CURLOPT_USERPWD, 'dangkhoatptp:dangkhoatptp');
    
    $response = curl_exec($ch);
    
    curl_close($ch);

    header("Location: index.php");
?>