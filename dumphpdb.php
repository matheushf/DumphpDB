<?php

class DB {

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

class DumphpDB extends DB {

    function __construct() {
        parent::__construct();
    }
    
    function GetVersion() {
        return $this->config['version'];
    }

    function SaveVersionDB($Option) {

        if ($Option == 'data_structure') {
            $Option = "--add-drop-database=true --opt";
        } else {
            $Option = '-d --opt';
        }

        $path = $this->GetPath('mysqldump');

        $this->config['version'] = $this->config['version'] + 0.1;
        $name = $this->config['database'] . $this->config['version'] . '.sql';

        exec($path . $Option . ' -u ' . $this->config['user'] . $this->pass . ' ' . $this->config['database'] . ' > db/' . $name);

        // Update the version in file
        $config = json_encode($this->config);
        file_put_contents('conf.json', $config);
    }

    function UpdateDB() {

        $path = $this->GetPath('mysql');

        exec($path . ' -u ' . $this->config['user'] . $this->pass . ' -e "DROP database ' . $this->config['database'] . '"');
        exec($path . ' -u ' . $this->config['user'] . $this->pass . ' -e "CREATE database ' . $this->config['database'] . '"');
        exec($path 
                . ' -u ' 
                . $this->config['user'] 
                . $this->pass . ' ' 
                . $this->config['database'] 
                . ' < db/' . $this->config['database'] . $this->config['version'] . '.sql');
    }

    function GetPath($program) {
        // Verify if script is under Windows
        if (preg_match('/linux/i', PHP_OS)) {
            $path = $program . ' ';
        } else {
            $path = "c:\xampp\mysql\bin\\" . $program;
        }

        return $path;
    }

}
