<?php

    $page = $_GET["page"] ?? '';     

    //var_dump($page);

    $menuitems = [
        'manageindex' => 'Quản lý Index',
        'document' => "Document",
        'search' => 'Tìm kiếm',
    ];
?>

    
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thực hành EL</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>

<!--
    /                    trang index.php
    /?page=manageindex   quan ly ES index
    /?page=document      luu cap nhat Document
    /?page=search        tim kiem tren ES
-->

<body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <!-- <a class="navbar-brand" href="#">Brand-Logo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#my-nav-bar"
            aria-controls="my-nav-bar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        <div class="collapse navbar-collapse" id="my-nav-bar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Trang chủ</a>
                </li>

                <?php foreach($menuitems as $url=>$label):?>

                        <?php 
                            $class='';
                            if ($page == $url)
                                $class = 'active';
                        ?>


                <li class="nav-item <?=$class?>">
                    <a class="nav-link" href="/?page=<?=$url?>"><?=$label?></a>
                </li>
                <?php endforeach?>


                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Học HTML</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Gửi bài</a>
                </li> -->
            </ul>

        </div>
    </nav>


    <?php if ($page != ''):?>
        <?php
            include $page.".php";
        ?>
    <?php else:?>
        <p class="text-danger display-4">Thực hành Elasticsearch PHP - 2021</p>
    <?php endif?>


</body>

</html>