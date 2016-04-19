<?php

class Conf {

    public $config = array(), $pass = null;

    public function __construct() {
        $this->config = $this->ReadConfig();

        if ($this->config['pass'] != null) {
            $this->pass = ' -p' . $this->config['pass'];
        }
    }

    function ReadConfig() {
        $config = file_get_contents('conf.json');
        $config = json_decode($config, true);

        return $config;
    }

}

class DumphpDB extends Conf {

    function __construct() {
        parent::__construct();
    }

    function GetVersion() {
        return $this->config['version'];
    }

    function SaveDB($Option) {
        $response = array();

        if ($Option == 'data_structure') {
            $Option = "--add-drop-database=true --opt";
        } else {
            $Option = '-d --opt';
        }

        $path = $this->GetPath('mysqldump');

        $file = "db/" . $this->config['database'] . ($this->config['version'] + 0.1) . ".sql";
        $file = str_replace(',', '.', $file);


        exec($path . $Option . ' -u ' . $this->config['user'] . $this->pass . ' ' . $this->config['database'] . ' > ' . $file);

        if (!file_exists($file) || filesize($file) <= 1000) {
            $com = $path . $Option . ' -u ' . $this->config['user'] . $this->pass . ' ' . $this->config['database'] . ' > ' . $file;
            $response['type'] = 'error';
            $response['text'] = "Folder db/ not found. Please, create a folder called 'db' inside DumphpDB directory.";

            return $response;
        }

        // Update the version in file
        $this->config['version'] += + 0.1;
        $config = json_encode($this->config);
        file_put_contents('conf.json', $config);

        $response['type'] = 'success';
        $response['text'] = 'Database saved successfully.';

        return $response;
    }

    function UpdateDB() {
        $response = array();

        $path = $this->GetPath('mysql');
        $file = 'db/' . $this->config['database'] . $this->config['version'] . '.sql';
        $file = str_replace(',', '.', $file);

        if (!file_exists($file) || filesize($file) <= 1000) {
            $response['type'] = 'error';
            $response['text'] = 'Database file not found inside DumphpDB directory.';

            return $response;
        }

        exec($path . ' -u ' . $this->config['user'] . $this->pass . ' -e "DROP database ' . $this->config['database'] . '"');
        exec($path . ' -u ' . $this->config['user'] . $this->pass . ' -e "CREATE database ' . $this->config['database'] . '"');
        exec($path
                . ' -u '
                . $this->config['user']
                . $this->pass . ' '
                . $this->config['database']
                . ' < ' . $file);

        $response['type'] = 'success';
        $response['text'] = 'Database updated successfully.';

        return $response;
    }

    function GetPath($program) {
        // Verify if script is under Windows
        if (preg_match('/linux/i', PHP_OS)) {
            $path = $program . ' ';
        } else {
            $path = 'C:\\' . $_SERVER['MYSQL_HOME'] . '\\' . $program . ' ';
        }

        return $path;
    }

}
