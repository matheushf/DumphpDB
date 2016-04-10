<?php

class DB {

    public $config = array();

    public function __construct() {
        $this->config = $this->ReadConfig();
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
        $config = json_decode($config, true);

        return $config;
    }

}

class DumphpDB extends DB {

    function __construct() {
        parent::__construct();

//        var_dump($this);
    }

    function SaveVersionDB() {

        // Check if the script is running under windows
        if (preg_match('/linux/i', PHP_OS)) {
            $path = 'mysqldump';
        } else {
            $path = 'c:\xampp\mysql\bin\mysqldump';
        }

        if ($this->config['pass'] != null) {
            $pass = ' -p' . $this->config['pass'];
        }

        $this->config['version'] = $this->config['version'] + 0.1;
        $name = $this->config['database'] . $this->config['version'] . '.sql';

        var_dump($this->config);

        exec($path . ' --add-drop-database --opt -u ' . $this->config['user'] . $pass . ' ' . $this->config['database'] . ' > db/saved/' . $name);

        // Update the version in file
        $config = json_encode($this->config);
        file_put_contents('conf.json', $config);

//        UpdateVersionNumber($version);
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

}
