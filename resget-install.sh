#!/usr/bin/env php
<?php
	system('clear');
	echo "\n";
	echo "*-----------------------------------------------*\n";
	echo "|	Resource Get Version 1.0.0 Installer 	|\n";
	echo "*-----------------------------------------------*\n";
	echo "	Checking for laravel existance ... \n";
	if(!file_exists('artisan'))
	{
		echo "	Could not find laravel. \n";
	}
	else
	{
		echo "	Checking Laravel version... \n";
		$result = shell_exec('php artisan --version');
		echo "	Retriving current directory... \n";
		$pwd = shell_exec('pwd');
		$path = $pwd.'/app/commands';
		$link = "https://raw.github.com/farbod69/ResGet/master/installer%20files/resget.install.raw";
		if(!file_exists($path))
		{
			echo "	Downloading resget, please wait ..... \n";
			$file = fopen('app/commands/resget.php','w');
			fwrite($file,file_get_contents("https://raw.github.com/farbod69/ResGet/master/resget.php"));
			if(!file_exists('app/storage/vendor'))
			{
				echo "	Creating vendor directory, please wait ..... \n";
				mkdir('app/storage/vendor');
			}
			echo "	Downloading jsmin, please wait ..... \n";
			$file = fopen('app/storage/vendor/jsmin.php','w');
			fwrite($file,file_get_contents("https://raw.github.com/rgrove/jsmin-php/master/jsmin.php"));
			echo "	Download completed \n";
			echo "	Setting up command .... \n";
			$appstart = fopen('app/start/artisan.php','a');
			fwrite($appstart,"\n\rArtisan::add(new resget);\n\r");
			echo "	All Done!\n";
			echo "	Thank you for using ResGet\n";
		}
		

	}

