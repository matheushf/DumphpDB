<?php

class Conf {

    public $config = array(), $pass = null;

    public function __construct() {
        $this->config = $this->ReadConfig();

        if ($this->config['cred'] == 'new') {
            return 'new';
        } else {
            
            if ($this->config['cred']['pass'] != null) {
                $this->pass = ' -p' . $this->config['cred']['pass'];
            }
        }
    }

    function ReadConfig() {

        if (file_exists('conf.json')) {
            $config['cred'] = file_get_contents('conf.json');
            $config['cred'] = json_decode($config['cred'], true);
        } else {
            $config['cred'] = 'new';
        }

        $config['vers'] = file_get_contents('version.json');
        $config['vers'] = json_decode($config['vers'], true);

        return $config;
    }

}

class DumphpDB extends Conf {

    function __construct() {
        parent::__construct();
    }

    function GetVersion() {
        return $this->config['vers']['version'];
    }

    function SaveDB($Option) {
        $response = array();

        if ($Option == 'data_structure') {
            $Option = "--add-drop-database=true --opt";
        } else {
            $Option = '-d --opt';
        }

        $path = $this->GetPath('mysqldump');

        $file = "db/" . $this->config['cred']['database'] . ($this->config['vers']['version'] + 0.1) . ".sql";
        $file = str_replace(',', '.', $file);


        exec($path . $Option . ' -u ' . $this->config['cred']['user'] . $this->pass . ' ' . $this->config['cred']['database'] . ' > ' . $file);

        if (!file_exists($file) || filesize($file) <= 1000) {
            $com = $path . $Option . ' -u ' . $this->config['cred']['user'] . $this->pass . ' ' . $this->config['cred']['database'] . ' > ' . $file;
            $response['type'] = 'error';
            $response['text'] = "Folder db/ not found. Please, create a folder called 'db' inside DumphpDB directory.";

            return $response;
        }

        // Update the version in file
        $this->config['vers']['version'] += + 0.1;
        $config = json_encode($this->config['vers']);
        file_put_contents('version.json', $config);

        $response['type'] = 'success';
        $response['text'] = 'Database saved successfully.';

        return $response;
    }

    function UpdateDB() {
        $response = array();

        $path = $this->GetPath('mysql');
        $file = 'db/' . $this->config['cred']['database'] . $this->config['vers']['version'] . '.sql';
        $file = str_replace(',', '.', $file);

        if (!file_exists($file) || filesize($file) <= 1000) {
            $response['type'] = 'error';
            $response['text'] = 'Database file not found inside DumphpDB directory.';

            return $response;
        }

        exec($path . ' -u ' . $this->config['cred']['user'] . $this->pass . ' -e "DROP database ' . $this->config['cred']['database'] . '"');
        exec($path . ' -u ' . $this->config['cred']['user'] . $this->pass . ' -e "CREATE database ' . $this->config['cred']['database'] . '"');
        exec($path
                . ' -u '
                . $this->config['cred']['user']
                . $this->pass . ' '
                . $this->config['cred']['database']
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
