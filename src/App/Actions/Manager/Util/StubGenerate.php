<?php

namespace Laraction\App\Actions\Manager\Util;

use Illuminate\Support\Facades\File;

class StubGenerate
{
	public string $file;
	protected array $variables;
	public string $path;

	public function __construct(string $stubFile, string $outFile, array $variables = [])
	{
		$this->file = $outFile;
		$this->variables =  $variables;
		$this->path =  $stubFile;
	}


    public  function content()
    {
        return $this->getContents();
    }

 	public function run()
	{
		$this->makeDirectory(dirname($this->file));
		$this->makeFile($this->file, $this->getContents());

		return $this;
    }

	function makeDirectory($path)
	{
		if(!File::exists($path)){
			File::makeDirectory($path, 0777, true);
		}
	}

	function makeFile($filename, $content)
	{
		if(!File::exists($filename)) {
			File::put($filename, $content);
		}
	}


	function getContents()
	{
		if(!file_exists($this->path)){
			 throw new \Exception('path not found '. $this->path);
		}

		$contents = file_get_contents($this->path);
		foreach($this->variables as $name => $value){
			$contents = str_replace($name, $value, $contents);
		}

		return $contents;
	}
}
