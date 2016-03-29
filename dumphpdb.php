<?php
function UpdateDB() {
	global $db;

	$server =  'localhost';
	$user = $_POST['mysql_user'];
	$password = $_POST['mysql_password'];

	$db->Connect($server, $banco_de_dados = null, $user, $password);

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

	AtualizarNumeroVersao($version);

}

function SaveVersionDB() {
	global $db;

	$server =  'localhost';
	$user = $_POST['mysql_user'];
	$password = $_POST['mysql_password'];

	$db->Connect($server, $banco_de_dados = null, $user, $password);

	// Verificar se está usando windows, e definir o caminho
	if (preg_match('/linux/i', PHP_OS)) {
		$path = 'mysqldump';
	} else {
		$path = 'c:\xampp\mysql\bin\mysqldump';
	}

	if ($password != null) {
		$password = ' -p ' . $password;
	}

	exec($path . ' --add-drop-database --opt -u ' . $user . $password . ' geleia_framework > geleia_framework.sql');

	// Atualizar o numero de versao do Geleia
	$file = fopen($_SERVER['DOCUMENT_ROOT'] . '/version.txt', 'r');
	$version = fread($file, filesize($_SERVER['DOCUMENT_ROOT'] . "/version.txt"));
	fclose($file);
	$file = fopen($_SERVER['DOCUMENT_ROOT'] . '/version.txt', 'w');
	$version += 0.01;
	$version = str_replace(',', '.', $version);
	fwrite($file, $version);
	fclose($file);

	AtualizarNumeroVersao($version);
}

function VersionDB() {

	if(filesize($_SERVER['DOCUMENT_ROOT'] . "/version.txt") != 0) {
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
	if($resultado->numero != null) {
		return str_replace(',', '.', $resultado->numero);
	} else {
		return 0;
	}

}

function UpdateVersionNumber($version) {
	global $db;

	// Atualizar versão local do Geleia
	$sql = 'UPDATE geleia.versao SET numero = ' . $version . ' WHERE id = 1';
	$db->ExecSQL($sql);
}