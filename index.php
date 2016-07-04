<?php
// testd
require_once './dumphpdb.php';
$dump = new DumphpDB();
$new = false;
$error = false;

if ($dump->config['cred'] == 'new') {
    $new = true;
} else if ($dump->config['cred']['error']) {
    $msg = $dump->response;
    $error = true;
}

$action = (isset($_GET['action'])) ? $_GET['action'] : null;

switch ($action) {
    case 'save': {
            $msg = $dump->SaveDB($_GET['option']);

            break;
        }

    case 'update': {
            $msg = $dump->UpdateDB();

            break;
        }

    case 'save_cred': {
            $msg = $dump->SaveCredentials();

            if ($msg['type'] == 'success') {
                header('Refresh:0; url=index.php');
            }

            break;
        }

    case 'change_db': {
            $new = true;

            break;
        }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title> DumphpDB </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/style.css">
        <script src="assets/jquery-1.11.3.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#save").click(function () {
                    var opt = $("input:checked").val();
                    var a = $(this).attr("href");
                    $(this).attr('href', a + '&option=' + opt);
                });
            });
        </script>
    </head>
    <body>
        <div id="wrapper">
            <a href="https://github.com/matheushf/dumphpdb" target="_blank" id="git">
                <img style="" src="assets/forkme_left_green_007200.png" alt="Fork me on GitHub" data-canonical-src="">
            </a>
            <div id="header">
                <center>
                    <h1> DumphpDB </h1>
                    <hr style="margin-bottom: 30px">
                </center>
            </div>

            <?php if (isset($msg) && $msg !== true) { ?>
                <div id="msg" class="<?= $msg['type'] ?>">
                    <center>
                        <?= $msg['text'] ?>
                    </center>
                </div>
            <?php } ?>

            <div id="content">

                <?php if ($new) { ?>

                    <center>
                        <h3 style="margin-top: 50px; margin-bottom: 100px; font-weight: normal"> Set the credentials from mysql and the database you want to use. </h3>

                        <form action="?action=save_cred" method="post" enctype="multipart/form-data">
                            <div class="input-group">
                                <label>Mysql Username: </label>
                                <input type="text" class="input-control" name="user" autofocus>
                            </div>
                            <div class="input-group">                        
                                <label>Mysql Password: </label>
                                <input type="text" class="input-control" name="pass">
                            </div>
                            <div class="input-group">
                                <label>Database: </label>
                                <input type="text" class="input-control" name="database">
                            </div>

                            <input type="submit" class="button button_save" value="Confirm">
                        </form>

                    </center>

                <?php } else { ?>
                    <center>
                        <label>Structure and Data </label>
                        <input type="radio" name="option" value="data_structure" checked="" style="margin-right: 20px">
                        <label> Structure: </label>
                        <input type="radio" name="option" value="data">

                        <div id="col-save">
                            <p> Save/Backup your current Database. </p><br>
                            <label> 
                                <input type="checkbox">
                                Download 
                            </label>
                            <br> <br>
                            <a href='?action=save' class="button button_save" id="save"> Save </a>
                            <a id="download" download=""></a>
                        </div>
                    </center>                

                    <center>
                        <div id="col-update">
                            <p> Update your Working Database. </p>
                            <a href='?action=update' class="button button_cancel" id="update" > Update </a>
                        </div>

                        <p style="margin-top: -30px;"><b>Database: </b> <?= $dump->config['cred']['database'] ?> </p>
                        <p><b>Version: </b><?= $dump->config['vers']['version'] ?></p>
                        <p><b>Type: </b> <?= $dump->config['vers']['type'] ?> </p>
                        <p><a href="?action=change_db">Change Database..</a></p>
                        <br>
                    </center>

                <?php } ?>

            </div> 

            <div id="footer">
                <center>
                    matheushf - 2016 <a href="http://www.github.com/matheushf"> github.com/matheushf </a>
                </center>
            </div>

            <?php
            // put your code here
            ?>
        </div>
    </body>
</html>
