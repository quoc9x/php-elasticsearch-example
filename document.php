<?php
    // echo "Day la Document";

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

    if (!$exists) {
        throw new Exception("Index - article khong ton tai");
    }


    /**
     * DOCUMENT
     * - title
     * - content
     * - keywords
     */
    
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? null;
    $content = $_POST['content'] ?? null;
    $keywords = $_POST['keywords'] ?? null;

    // In dữ liệu ra để kiểm tra
    //var_dump($id, $title, $content, $keywords);

    $msg = "";

    if ($id != null && $title != null && $content != null && $keywords != null){
        // Update - Create Document vào index article

        $params = [
            'index' => 'article',
            'type' => 'article_type',
            'id' => $id,

            'body' => [
                'title' => $title,
                'content' => $content,
                // Phân tách keywords thành mảng
                'keywords' => explode(",", $keywords)
            ]

            ];

            //var_dump($params);
            $req = $client->index($params);

            $msg = "Cập nhật thành công cho document id=" . $id;

            $id = $title = $content = $keywords = null;
    }
     ?>

<div class="card m-4">
    <div class="card-header text-danger display-4">Tạo / Cập nhật Document</div>
    <div class="card-body">
        <form action="#" method="post">

            <div class="form-group">
                <label>ID Documnet</label>
                <input class="form-control" type="text" name="id" value="<?=$id?>">
            </div>

            <div class="form-group">
                <label>Title</label>
                <input class="form-control" type="text" name="title" value="<?=$title?>">
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea class="form-control" type="text" name="content"><?=$title?></textarea>
            </div>

            <div class="form-group">
                <label>Keywords</label>
                <input class="form-control" type="text" name="keywords" value="<?=$title?>">
            </div>

            <div class="form-group">
                <input class="btn btn-danger" type="submit" value="Update">
            </div>
        </form>

        <?=$msg?>
    </div>
</div>