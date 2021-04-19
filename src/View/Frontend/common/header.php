<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Kanban" name="SEO-KÜCHE">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kanban Application">
    <meta name="keywords" content="">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo assets('css/bootstrap.min.css');?>" />
    <link rel="stylesheet" href="<?php echo assets('css/mdb.min.css');?>" />
    <link rel="stylesheet" href="<?php echo  assets('css/style.css');?>" />
    <!--/ Boostrap -->

    <!-- Custom Style -->
    <link rel="stylesheet" href="<?php echo assets('css/style.css');?>" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Bootstrap-->
    <!--/ Bootstrap-->
    <script type="text/javascript" defer></script>
    <script type="text/javascript" src="<?php echo assets('js/jquery-3.3.1.min.js');?>" defer></script>
    <script type="text/javascript" src="<?php echo assets('js/popper.min.js');?>" defer></script>
    <script type="text/javascript" src="<?php echo assets('js/bootstrap.min.js');?>" defer></script>
    <script type="text/javascript" src="<?php echo assets('js/mdb.min.js');?>" defer></script>
    <script type="text/javascript" src="<?php echo assets('js/ajax.js');?>" defer></script>

    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo assets('img/favicon.png');?>">

</head>

<body>
<!-- Header -->
<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo urlHtml('/'); ?>">
                <img width="30" height="30" src="<?php echo assets('img/favicon.png');?>" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-stretch" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item <?php echo ($title === 'Homepage') ? 'active' : ""; ?>">
                        <a class="nav-link" href="<?php echo urlHtml('/'); ?>">Home<span class="sr-only">(current)</span></a>
                    </li>

                    <?php if($user) {?>
                        <li class="nav-item <?php echo ($title === 'Boards') ? 'active' : ""; ?>">
                            <a class="nav-link" href="<?php echo urlHtml('/boards');?>">Boards<span class="sr-only">(current)</span></a>
                        </li>
                    <?php }?>

                </ul>
                <ul class="navbar-nav ml-auto">

                    <?php if($user) {?>
                        <li class="nav-item">
                            <img data-toggle="tooltip" data-placement="left" title="<?php echo $user->getUsername();?>" class="nav-link" src="<?php echo assets('img/avatar.png');?>" alt="Avatar" width="60" height="60">
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mt-3" href="<?php echo urlHtml('/logout');?>">Logout</a>
                        </li>
                    <?php } else {?>
                        <li class="nav-item  <?php if($title === 'Sign up'){echo 'active';} ?>">
                            <a class="nav-link" href="<?php echo urlHtml('/register');?>">Sign up</a>
                        </li>
                        <li class="nav-item  <?php echo ($title === 'Sign in') ? 'active' : ""; ?>">
                            <a class="nav-link" href="<?php echo urlHtml('/login');?>">Sign in</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!--/ Header -->

<!-- Content -->
<div class="main-container">