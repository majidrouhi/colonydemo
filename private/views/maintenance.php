<!DOCTYPE html>
<html lang="en-<?php echo $_SESSION['COUNTRY']; ?>">
    <head>
        <meta charset="<?php echo CHARSET; ?>" />
        <meta name="keywords" content="Who, What, When" />
        <meta name="description" content="Know about everything, here." />
        <meta name="author" content="Mr. Python" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="stylesheet" href="/css/style.css" />
        <title><?php echo APPLICATION_TITLE; ?></title>
    </head>
    <body>
        <section class="container">
            <section class="primary-content">
            we are in maintenance...
            </section>
            <footer>
                <small>&copy; <?php echo date('Y') . ' ' . strtoupper($_SERVER['SERVER_NAME']); ?></small>
            </footer>
        </section>
    </body>
</html>
