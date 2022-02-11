<?php
    //echo "Day la chuc nang Search";
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

    $search = $_POST['search'] ?? '';
    //var_dump($search);

    // Tham số tìm kiếm
    if ($search != '') {

        $params = [
        'index' => 'article',
        'type' => 'article_type',
        'body' => [
            "query" => [
                "bool" => [
                    "should" => [
                        ['match' => ['title' => $search]],
                        ['match' => ['content' => $search]],
                        //['match' => ['keywords' => $search]]
                    ]
                ]
                    ],

                'highlight' => [
                    'pre_tags' => ["<strong class='text-danger'>"],
                    'post_tags' => ["</strong>"],

                    'fields' => [
                        'title' => new stdClass(),
                        'content' => new stdClass()
                    ]
                ]


                    ]
                    ];

                    $rs = $client->search($params);

                    $items = null;

                    $total = $rs['hits']['total']['value'];

                    if ($total > 0) {
                        $items = $rs['hits']['hits'];
                    }

                    var_dump($total, $items);

    }

?>

<div class="card m-4">
    <div class="card-header text-danger display-4">Tìm kiếm</div>
    <div class="card-body">
        <form action="#" method="post">

            <div class="form-group">
                <label>Nội dung tìm kiếm</label>
                <input class="form-control" type="text" name="search" value="<?=$search?>">
            </div>

            <div class="form-group">
                <input class="btn btn-danger" type="submit" value="Search">
            </div>
        </form>

        <?php if ($items != null):?>
        <?php foreach ($items as $item):?>
        <?php
                    $title = $item['_source']['title'];
                    $content = $item['_source']['content'];

                    if (isset($item['highlight']['title']))
                        $title = implode(" ", $item['highlight']['title']);

                    if (isset($item['highlight']['content']))
                        $content = implode(" ", $item['highlight']['content']);
                ?>

        <p><strong><?=$title?></strong> <br>
            <?=$content?>
        </p>

        <hr>


        <?php endforeach?>
        <?php endif?>

    </div>
</div>