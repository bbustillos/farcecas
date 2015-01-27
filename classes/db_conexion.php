<?php
	include_once 'psl-config.php';
	require_once('MysqliDb.php');
	include_once 'class.registroProcesos.php';
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	$objCon = new MysqliDb(HOST, USER, PASSWORD, DATABASE);
	$oRegistro = new registroProcesos;
