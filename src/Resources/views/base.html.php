<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title><?php $view['slots']->output('title', '#1 Algarve Boat &amp; Cave Tours 2018 | Seasiren Tours') ?></title>
    </head>
    <body>
        <?php $view['slots']->output('_content') ?>
    </body>
	{% include 'footer.html.php' %}
</html>