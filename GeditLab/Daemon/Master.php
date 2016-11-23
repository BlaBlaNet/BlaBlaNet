<?php

namespace GeditLab\Daemon;

if(array_search( __file__ , get_included_files()) === 0) {

	require_once('include/cli_startup.php');
	array_shift($argv);
	$argc = count($argv);

	if($argc)
		Master::Release($argc,$argv);
	killme();
}



class Master {

	static public function Summon($arr) {
		proc_run('php','GeditLab/Daemon/Master.php',$arr);
	}

	static public function Release($argc,$argv) {
		cli_startup();
		logger('Master: release: ' . print_r($argv,true), LOGGER_ALL,LOG_DEBUG);
		require_once('GeditLab/Daemon/' . $argv[0] . '.php');
		$cls = '\\GeditLab\\Daemon\\' . $argv[0];
		$cls::run($argc,$argv);
	}	
}