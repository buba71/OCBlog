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
        <p><?php echo $article->getContent() ?></p>
        <p>Ajouté le
            <?php
            $date = date_create($article->getDate());
            echo date_format($date, 'd/m/Y');

            ?>
             
         </p>


    </article>
    <?php endforeach ?>
    <footer class="footer">
        <a href="https://github.com/bpesquet/OC-MicroCMS">MicroCMS</a> is a minimalistic CMS built as a showcase for modern PHP development.
    </footer>
</body>
</html>