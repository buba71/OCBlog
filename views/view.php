<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="" rel="stylesheet" />
    <title>OCBlog</title>
</head>
<body>
    <header>
        <h1>OCBlog</h1>
    </header>
    <?php
    
    foreach ($articles as $article): ?>
    <article>
        <h2><?php echo $article->getTitle() ?></h2>
        <p>Ajouté le
            <?php
            $date = date_create($article->getDate());
            echo date_format($date, 'd/m/Y');

            ?>
             
        </p>
        <p><?php echo $article->getContent() ?></p>
        


    </article>
    <?php endforeach ?>
    <footer class="footer">
        <a href="https://github.com/bpesquet/OC-MicroCMS">OCBlog-Projet 3</a>
    </footer>
</body>
</html>