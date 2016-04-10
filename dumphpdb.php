<?php

$dump = new DumphpDB();

if(isset($_POST)) {
    //identify action
}

class DB {

    public $host, $user, $password, $con, $db_name;

    public function __construct() {
        $config = $this->ReadConfig();

        $this->host = $config->host;
        $this->user = $config->user;
        $this->password = $config->pass;
        $this->db_name = $config->database;

    }

    function Connect() {
        if ($this->con = mysql_pconnect($this->server, $this->username)) {
            mysql_select_db($this->db_name);
        } else {
            return false;
        }
    }

    function ExecuteSql($sql) {
        $result = mysql_query($sql);
    }

    function ReadConfig() {
        $config = file_get_contents('conf.json');
        $config = json_decode($config);

        return $config;
    }

}

class DumphpDB extends DB {

    function __construct() {
        parent::__construct();
        
//        var_dump($this);
    }

    function UpdateDB() {
        global $db;

        $db->Connect($host, $banco_de_dados = null, $user, $password);

        // Verify if script is under Windows
        if (preg_match('/linux/i', PHP_OS)) {
            $path = 'mysql';
        } else {
            $path = 'c:\xampp\mysql\bin\mysql';
        }

        if ($password != null) {
            $password = ' -p ' . $password;
        }

        exec($path . ' -u ' . $user . $password . ' -e "DROP database geleia_framework"');
        exec($path . ' -u ' . $user . $password . ' -e "CREATE database geleia_framework"');
        exec($path . ' -u ' . $user . $password . ' geleia_framework < geleia_framework.sql');

        // Pegar o numero de versao do Geleia
        $file = fopen($_SERVER['DOCUMENT_ROOT'] . '/version.txt', 'r');
        $version = fread($file, filesize($_SERVER['DOCUMENT_ROOT'] . "/version.txt"));
        fclose($file);

        UpdateVersionNumber($version);
    }

    function SaveVersionDB() {
        global $db;

        $host = 'localhost';
        $user = $_POST['mysql_user'];
        $password = $_POST['mysql_password'];

        $db->Connect($host, $banco_de_dados = null, $user, $password);

        // Check if the script is running under windows
        if (preg_match('/linux/i', PHP_OS)) {
            $path = 'mysqldump';
        } else {
            $path = 'c:\xampp\mysql\bin\mysqldump';
        }

        if ($password != null) {
            $password = ' -p ' . $password;
        }

        exec($path . ' --add-drop-database --opt -u ' . $user . $password . ' geleia_framework > geleia_framework.sql');

        // Update the version in file
        $file = fopen($_SERVER['DOCUMENT_ROOT'] . '/version.txt', 'r');
        $version = fread($file, filesize($_SERVER['DOCUMENT_ROOT'] . "/version.txt"));
        fclose($file);
        $file = fopen($_SERVER['DOCUMENT_ROOT'] . '/version.txt', 'w');
        $version += 0.01;
        $version = str_replace(',', '.', $version);
        fwrite($file, $version);
        fclose($file);

        UpdateVersionNumber($version);
    }

    function VersionDB() {

        if (filesize($_SERVER['DOCUMENT_ROOT'] . "/version.txt") != 0) {
            $file = fopen($_SERVER['DOCUMENT_ROOT'] . '/version.txt', 'r');
            $version = fread($file, filesize($_SERVER['DOCUMENT_ROOT'] . "/version.txt"));
            fclose($file);
        } else {
            return 0;
        }

        return $version;
    }

    function VersionDBLocal() {
        global $db;

        $resultado = $db->GetObject('SELECT * FROM geleia.versao WHERE id = 1');
        if ($resultado->numero != null) {
            return str_replace(',', '.', $resultado->numero);
        } else {
            return 0;
        }
    }

    function UpdateVersionNumber($version) {
        global $db;

        // Update the local DataBase version 
        $sql = 'UPDATE geleia.versao SET numero = ' . $version . ' WHERE id = 1';
        $db->ExecSQL($sql);
    }

}
