<?php
require_once './dumphpdb.php';
$dump = new DumphpDB();

$action = (isset($_GET['action'])) ? $_GET['action'] : null;

switch ($action) {
    case 'save': {
        $dump->SaveVersionDB();
        
        break;
    }
    
    case 'update': {
        $dump->UpdateDB();
        
        break;
    }
}

