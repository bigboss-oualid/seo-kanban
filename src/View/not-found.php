<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title><?= (isset($title))? $title : '404 Not Found'; ?></title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <style type="text/css">
            body { background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMC8yOS8xMiKqq3kAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAABHklEQVRIib2Vyw6EIAxFW5idr///Qx9sfG3pLEyJ3tAwi5EmBqRo7vHawiEEERHS6x7MTMxMVv6+z3tPMUYSkfTM/R0fEaG2bbMv+Gc4nZzn+dN4HAcREa3r+hi3bcuu68jLskhVIlW073tWaYlQ9+F9IpqmSfq+fwskhdO/AwmUTJXrOuaRQNeRkOd5lq7rXmS5InmERKoER/QMvUAPlZDHcZRhGN4CSeGY+aHMqgcks5RrHv/eeh455x5KrMq2yHQdibDO6ncG/KZWL7M8xDyS1/MIO0NJqdULLS81X6/X6aR0nqBSJcPeZnlZrzN477NKURn2Nus8sjzmEII0TfMiyxUuxphVWjpJkbx0btUnshRihVv70Bv8ItXq6Asoi/ZiCbU6YgAAAABJRU5ErkJggg==);}
            .error-template {padding: 40px 15px;text-align: center;}
            .error-actions .btn { margin-right:10px; }
            .danger {color: red;}
            .jumbotron {color: #533;background-color:#9bb;}
            html,
            body {
                height: 100%;
            }

            .container {
                height: 75%;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        </style>
    </head>

    <body class="404">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div <?php if(isset($color)){echo $color;}?> class="jumbotron error-template">
                        <h1>
                            Oops!
                        </h1>
                        <h2 >
                            <?php echo $errorTitle;?>
                        </h2>
                        <p>

                            <?php echo $description;?>
                        </p>
                        <div class="error-actions">
                            <a href="<?= urlHtml('/') ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                                Go back to Homepage </a>
                            <a href="mailto:oualid@boulatar.com" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact us </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>