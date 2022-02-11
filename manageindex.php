<?php
use Elasticsearch\Client;
    //echo __FILE__;
    /**
     * Ket noi Elasticsearch
     * Tao / xoa index: article
     */
     require "vendor/autoload.php";

     // Elasticsearch\Client
     // Elasticsearch\ClientBuilder

     $hosts = [
         [
             'host' => '127.0.0.1',
             'port' => '9200',
             'scheme' => 'http'
         ]
    ];

    $client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();

    // Kiểm tra index article có tồn tại hay không?
    $exists = $client->indices()->exists(['index' => 'article']);

    //$indices = $client->cat()->indices();
    //var_dump($indices);

    $action = $_GET['action'] ?? '';

    //var_dump($action);

    if ($action == 'create'){
        //Tao index: article
        if (!$exists)
            $client->indices()->create(['index' => 'article']);
    }
    else if ($action == 'delete'){
        //Xoa index: article
        if ($exists)
            $client->indices()->delete(['index' => 'article']);
    }

    $exists = $client->indices()->exists(['index' => 'article']);

    $msg = $exists ? "Index - Article đang tồn tại" : "Index - Article không có";




    ?>

<div class="card m-4">
    <div class="card-header text-danger display-4">Quản lý Index</div>
    <div class="card-body">
        <?php if (!$exists):?>
        <a class="btn btn-success" href="http://localhost:8888/?page=manageindex&action=create">Tạo index: Article</a>
        <?php else:?>
        <a class="btn btn-danger" href="http://localhost:8888/?page=manageindex&action=delete">Tạo index: Article</a>
        <?php endif?>

        <div class="alert alert-primary mt-3">
            <?=$msg?>
        </div>

    </div>
</div>
