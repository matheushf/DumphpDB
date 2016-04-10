<!DOCTYPE html>
<!--
DumphpDB is a easy way to save your working database. 

If you have are working on a new project, it means that, like always, your database is going to have a lot of versions, with the progress we make, we always find something we want to change. 

So if you work in more than one place, or in a team, you probably use a git to save your work, and then pull the changes. 
This plugin allows you to save your current database, and then upload it along with your current project's directory's, and then after pulling your commit, you just update the database, it is just two clicks in a single page, and it is it!

I hope you enjoy!
-->
<?php
require_once 'dumphpdb.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title> DumphpDB </title>
        <link rel="stylesheet" href="assets/style.css">
    </head>
    <body>
        <div id="wrapper">
            <a href="https://github.com/matheushf">
                <img style="position: absolute; top: 0; left: 0; border: 0;" src="assets/forkme_left_green_007200.png" alt="Fork me on GitHub" data-canonical-src="">
            </a>
            <div id="header">
                <center>
                    <h1 style=""> DumphpDB </h1>
                    <hr>
                </center>

            </div>

            <div id="content">
                <center>
                    <div id="save">
                        <p> Save your current Database. </p>
                        <a href='?action=save' class="button" name="save"> Save </a>
                    </div>
                </center>                

                <center>
                    <div id="backup">
                        <p> Backup your Database version. </p>
                        <a href='?action=backup' class="button" name="backup"> Backup </a>
                    </div>
                </center>

                <center>
                    <div id="update">
                        <p> Update your Working Database. </p>
                        <a href='?action=update' class="button" name="save" > Update </a>
                    </div>
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
