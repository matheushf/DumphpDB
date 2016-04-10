<?php
require_once './dumphpdb.php';
$dump = new DumphpDB();

$action = (isset($_GET['action'])) ? $_GET['action'] : null;

switch ($action) {
    case 'save': {
            $dump->SaveVersionDB($_GET['option']);

            break;
        }

    case 'update': {
            $dump->UpdateDB();

            break;
        }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> DumphpDB </title>
        <link rel="stylesheet" href="assets/style.css">
        <script src="assets/jquery-1.11.3.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#save").click(function (event) {
                    event.preventDefault();
                    var opt = $("input:checked").val();
                    var a = $(this).attr("href");

                    window.location = a + '&option=' + opt;

                })
            })

        </script>
    </head>
    <body>
        <div id="wrapper">

            <div id="header">
                <a href="https://github.com/matheushf">
                    <img style="" src="assets/forkme_left_green_007200.png" alt="Fork me on GitHub" data-canonical-src="">
                </a>

                <center>
                    <h1 style=""> DumphpDB </h1>
                    <hr>
                </center>

            </div>

            <div id="content">
                <center>
                    <div id="opt">
                        <label>Structure and Data </label>
                        <input type="radio" name="option" value="data_structure" checked="">
                        <br>
                        <label> Data: </label>
                        <input type="radio" name="option" value="data">
                    </div>

                    <div id="col-save">
                        <p> Save/Backup your current Database. </p>
                        <a href='?action=save' class="button" id="save"> Save </a>
                    </div>
                </center>                

                <center>
                    <div id="col-update">
                        <p> Update your Working Database. </p>
                        <a href='?action=update' class="button" id="update" > Update </a>
                    </div>

                    <p style="margin-top: -30px"><b>Database </b><?= $dump->config['database'] ?></p>
                    <p><b>Version: </b><?= $dump->config['version'] ?></p>
                </center>

            </div>

            <div id="footer">
                <center>
                    Matheus Victor  <a style="" href="github.com/matheushf"> github.com/matheushf </a>
                </center>
            </div>

            <?php
            // put your code here
            ?>
        </div>
    </body>
</html>
