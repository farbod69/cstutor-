<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
require base_path()."/app/storage/vendor/jsmin.php";
class resget extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'resget';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get essential javascripts and stylesheets for you';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$info = "ResGet is small tool for downloading js and css files to your project\nThis tool has beed developed by Farbod Nosrat Nezami\nThis tool is under MIT lisence feel free to use it or change it\nContact me on fn.nezami.info@gmail.com\nThank you for using ResGet";
		$version= ' version 1.0.1 Beta ';
		$help = '';
		
		/* Getting all command arguments */
		
		$arguments = $this->argument();
		
		/* Checking all recived arguments run proper functionality and insure that only one argument at a time works */
		/* Insure this by returning after each detected argument */
		
		foreach ($arguments as $argument) {
			/* Minify given javascripts and css */
			if($argument == 'minify')
			{
				$this->info("ResGet ".$version);
				$addresses = $this->option('path');
				
				/* adding essential folders to the public directory*/
				$path = base_path().str_replace('=', '/', $this->option('approot'));
				if(!file_exists($path.'/js'))
				{
					$this->info('Creating JavaScript folder at '.$path.'/js');
					mkdir($path.'/js');
				}
				if(!file_exists($path.'/css'))
				{
					$this->info('Creating StyleSheet folder at '.$path.'/css');
					mkdir($path.'/css');
				}
				if(!file_exists($path.'/img'))
				{
					$this->info('Creating Image folder at '.$path.'/img');
					mkdir($path.'/img');
				}
				if(!file_exists($path.'/fonts'))
				{
					$this->info('Creating JavaScript folder at '.$path.'/fonts');
					mkdir($path.'/fonts');
				}
				/* reading file contents and merge them */
				$this->info('Creating temporary file for merging ....');
				$tmp = fopen('merger.tmp', "w");
				foreach ($addresses as $address) {
					$this->info('Reading following file content >> '.str_replace('=', '', $address));
					fwrite($tmp,file_get_contents(str_replace('=', '', $address)));

				}
				$this->info('Minifying your files to '.str_replace('=', '', $this->option('name')).'....');
				// minify package and write it to the given folder name 
				if($this->option('type') == '=js')
				{
					file_put_contents($path.'/js'.'/'.str_replace('=', '', $this->option('name')).'-min.js',JSMin::minify(file_get_contents('merger.tmp')));
					$this->info('Removing temporary file ....');
					unlink('merger.tmp');
				}
				else
				{
					file_put_contents($path.'/css'.'/'.str_replace('=', '', $this->option('name')).'-min.css',JSMin::minify(file_get_contents('merger.tmp')));
					$this->info('Removing temporary file ....');
					unlink('merger.tmp');
				}
				$this->info('All done successfully ....');
				return;
 				
			}
			if($argument == 'get')
			{
				$this->info("ResGet ".$version);
				/**
				*
				* This part of command tool is using GitHub search API you can read more about GitHub seach API from here:
				* URL : http://developer.github.com/v3/search
				* Note : By the time I was developing this command tool GitHub search API was in priview mode. note the CURLOPT_HTTPHEADER value
				* Note : By default GitHub allows 5 queries per minute for non authunticated requests you can increase the limit to 20 by using authuntication
				**/
				
				/* building a url from user input to query github
				
				/* starting a curl session, setting CURLOPT_URL and _HTTPHEADER you may need to change the header after search api exits preview mode */
				$this->info('starting query session ....');
				$curlSession = curl_init();
				curl_setopt($curlSession, CURLOPT_URL, "https://api.github.com/search/repositories?q=jquery+language:javascript&sort=stars&order=desc");
				curl_setopt($curlSession, CURLOPT_HTTPHEADER ,array('Accept: application/vnd.github.preview.text-match+json'));
				curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
				/* execute curl session, recive data, check for errors, if any error occured return, else pars recived string to array with json decode method */
				$this->info('Start searching GitHub for ....');
				$curlData = curl_exec($curlSession);
				
				if(!curl_errno($curlSession))
				{ 
				  $info = curl_getinfo($curlSession); 
  				  $this->info('Took ' . $info['total_time'] . ' seconds to send a request to GitHub');
				} 
				else
				{ 
				  $this->error('Curl error: ' . curl_error($curlSession)); 
				  return;
				} 
				$this->info('Searching in the result for ....');
				$curlData = mb_convert_encoding($curlData, 'utf-8');
				$jsonData = (array)json_decode($curlData);
				$items = (array)$jsonData["items"];
				dd($items);
				foreach ($items as $item) {
					if($item->name == 'jquery')
					{

					}
				}
				
				curl_close($curlSession); 
				return;
			}
			if($argument == 'info')
			{
				$this->info($info);
				return;
			}
			if($argument == 'version')
			{
				$this->info('You are currently using ResGet'.$version);
				return;
			}
			else if($argument != 'resget')
			{
				$this->info("ResGet ".$version);
				$resources = $this->option('resname');
				$path = base_path().str_replace('=', '/', $this->option('approot'));
				if(!file_exists($path.'/js'))
				{
					$this->info('Creating JavaScript folder at '.$path.'/js');
					mkdir($path.'/js');
				}
				if(!file_exists($path.'/css'))
				{
					$this->info('Creating StyleSheet folder at '.$path.'/css');
					mkdir($path.'/css');
				}
				if(!file_exists($path.'/img'))
				{
					$this->info('Creating Image folder at '.$path.'/img');
					mkdir($path.'/img');
				}
				if(!file_exists($path.'/fonts'))
				{
					$this->info('Creating JavaScript folder at '.$path.'/fonts');
					mkdir($path.'/fonts');
				}
				foreach ($resources as $resource ) 
				{
					if($resource == "=jquery")
					{
						if(!file_exists($path.'/js'.'/jquery-min.js'))
						{
							$this->info('Downloading jquery, please wait .....');
							file_put_contents($path.'/js'.'/jquery-min.js', fopen("http://code.jquery.com/jquery-1.10.2.min.js", 'r'));
						}
						else
						{
							$this->error("Resource already exist!");
						}
					}
					if($resource == "=underscore")
					{
						
						if(!file_exists($path.'/js'.'/underscore-min.js'))
						{
							$this->info('Downloading underscorejs, please wait .....');
							file_put_contents($path.'/js'.'/underscore-min.js', fopen("http://underscorejs.org/underscore-min.js", 'r'));
						}
						else
						{
							$this->error("Resource already exist!");
						}
					}
					if($resource == "=angular")
					{
						
						if(!file_exists($path.'/js'.'/jquery-min.js'))
						{
							$this->info('Downloading angularjs, please wait .....');
							file_put_contents($path.'/js'.'/angular-min.js', fopen("https://ajax.googleapis.com/ajax/libs/angularjs/1.0.8/angular.min.js", 'r'));
						}
						else
						{
							$this->error("Resource already exist!");
						}	
					}
					if($resource == "=backbone")
					{
						if(!file_exists($path.'/js'.'/jquery-min.js'))
						{
							$this->info('Downloading jquery, please wait .....');
							file_put_contents($path.'/js'.'/jquery-min.js', fopen("http://code.jquery.com/jquery-1.10.2.min.js", 'r'));
						}
						if(!file_exists($path.'/js'.'/underscore-min.js'))
						{
							$this->info('Downloading underscore, please wait .....');
							file_put_contents($path.'/js'.'/underscore-min.js', fopen("http://underscorejs.org/underscore-min.js", 'r'));
						}
						if(!file_exists($path.'/js'.'/backbone-min.js'))
						{
							$this->info('Downloading backbone, please wait .....');
							file_put_contents($path.'/js'.'/backbone-min.js', fopen("http://backbonejs.org/backbone-min.js", 'r'));
						}
						else
						{
							$this->error("Resource already exist!");
						}	
					}
					if($resource == "=bootstrap3")
					{
						if(!file_exists($path.'/css'.'/bootstrap-min.css'))
						{
							$this->info('Downloading Twitter Bootstrap 3 StyleSheet, please wait .....');
							file_put_contents($path.'/css'.'/bootstrap-min.css', fopen("http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css", 'r'));
						}
						if(!file_exists($path.'/js'.'/bootstrap-min.js'))
						{
							$this->info('Downloading Twitter Bootstrap 3 JavaScript, please wait .....');
							file_put_contents($path.'/js'.'/bootstrap-min.js', fopen("http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js", 'r'));
						}
						else
						{
							$this->error("Resource already exist!");
						}
					}
					if($resource == "=fontawesome")
					{
						if(!file_exists($path.'/css'.'/font-awesome-min.css'))
						{
							$this->info('Downloading Font Awesome StyleSheet, please wait .....');
							file_put_contents($path.'/css'.'/font-awesome-min.css', fopen("http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css", 'r'));
						}
						else
						{
							$this->error("Resource already exist!");
						}
					}
					$this->info('Task done!');
				}
				$this->info('All done successfully!');
				return;
			}
			
		}
		/**/
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	
	protected function getArguments()
	{
		return array(
			//array('get', InputArgument::OPTIONAL, 'To add a custom resource',null),
			array('info', InputArgument::OPTIONAL, 'Show developer information',null),
			array('help', InputArgument::OPTIONAL, 'Show help information',null),
			array('version', InputArgument::OPTIONAL, 'Show current resgen version',null),
			array('minify', InputArgument::OPTIONAL, 'Show current resgen version',null),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			 array('resname', 'r', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'specify resource name', null),
			 array('approot', 'a', InputOption::VALUE_OPTIONAL , 'specify you applicaion public folder. default is /public', '=public'),
			 array('path', 'p', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY , 'specify your file addresses', null),
			 array('name', null, InputOption::VALUE_OPTIONAL , 'specify your minified output name', null),
			 array('type', 't', InputOption::VALUE_OPTIONAL , 'specify your file type', 'js'),
			
		);
	}

}