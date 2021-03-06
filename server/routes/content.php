<?php
use Propel\Runtime\Propel;

$app->get('/content', function () use ($app) {

    // authenticate before do anything
    if ( !authenticate($app->request->params('apiKey')) ) {
        $app->status(403);
        echo json_encode('You are not allowed to see this page.');
        return;
    }

    // construct query
    $con = Propel::getConnection();
    $sql =  'SELECT * FROM `misc_content`';
    $stmt = $con->prepare($sql);
    
    // execute and return
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
});