<!DOCTYPE html>
<!--
DumphpDB is a easy way to save your working database. If you have a 
-->
<?php
require_once 'dumphpdb.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>DumphpDB</title>
        <style>
            body {
                background-color: #f3f3f3;
                font-family: sans-serif;
            }

            #save {
                float: left;
                width: 50%;
            }
            
            #save input {
                
            }

            #update {
                float: right;
                width: 50%;                
            }

        </style>
    </head>
    <body>
    <center>
        <h1 style="margin-bottom: 60px"> DumphpDB </h1>
    </center>

    <center>
        <div id="save">

            <form action="dumphpdb.php" method="POST" name="">
                <span style="margin-top: 50px"></span>
                <p> Save your DB version. </p>
                <br>
                <label>Mysql User</label>
                <input type="text" name="mysql_user">
                <br>
                <label>Password </label>
                <input type="text" name="mysql_password">
                <br>
                <input type="submit" name="save" value="Save">
            </form>
        </div>
    </center>        

    <center>
        <div id="update">
            <form action="dumphpdb.php" method="POST">
                <span style="margin-top: 50px"></span>
                <p> Update your DB Version. </p>
                <br>
                <label>Mysql User</label>
                <input type="text" name="mysql_user">
                <br>
                <label>Password </label>
                <input type="text" name="mysql_password">
                <br>
                <input type="submit" name="save" value="Update">
            </form>
        </div>
    </center>

    <?php
    // put your code here
    ?>
</body>
</html>
