<?php
require_once './dumphpdb.php';
$dump = new DumphpDB();
$new = false;

if ($dump->config['cred'] == 'new') {
    $new = true;
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
                $("#save").click(function (event) {
                    event.preventDefault();
                    var opt = $("input:checked").val();
                    var a = $(this).attr("href");

                    window.location = a + '&option=' + opt;

                });
            });

        </script>
    </head>
    <body>
        <div id="wrapper">
            <a href="https://github.com/matheushf/dumphpdb" target="_blank" id="git">
                <!--<img style="" src="assets/forkme_left_green_007200.png" alt="Fork me on GitHub" data-canonical-src="">-->
            </a>
            <div id="header">


                <div id="title">
                    <center>
                        <h1 style=""> DumphpDB </h1>
                        <hr>
                    </center>
                </div>

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
                    
                    
                </center>
                
                <?php } else { ?>
                    <center>
                        <div id="opt">
                            <label>Structure and Data </label>
                            <input type="radio" name="option" value="data_structure" checked="">
                            <br>
                            <label> Structure: </label>
                            <input type="radio" name="option" value="data">
                        </div>

                        <div id="col-save">
                            <p> Save/Backup your current Database. </p>
                            <a href='?action=save' class="button button_save" id="save"> Save </a>
                        </div>
                    </center>                

                    <center>
                        <div id="col-update">
                            <p> Update your Working Database. </p>
                            <a href='?action=update' class="button button_cancel" id="update" > Update </a>
                        </div>

                        <p style="margin-top: -30px"><b>Database: </b><?= $dump->config['cred']['database'] ?></p>
                        <p><b>Version: </b><?= $dump->config['vers']['version'] ?></p>
                    </center>

                </div>

            <?php } ?>

            <div id="footer">
                <center>
                    Matheus Victor  <a style="" href="http://www.github.com/matheushf"> github.com/matheushf </a>
                </center>
            </div>

            <?php
            // put your code here
            ?>
        </div>
    </body>
</html>
