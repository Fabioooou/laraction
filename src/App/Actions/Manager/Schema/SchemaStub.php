<?php

namespace Laraction\App\Actions\Manager\Schema;



interface SchemaStub 
{

	/**
	 * file  example:  /app/Actions/Backoffice/Catalog/Product.php
	 *
	 * @return string
	 */
	public function getStubFile() : string;

	/**
	 * stub variables example:   
	 * 
	 * {{class}} => 'ProductController'
	 *
	 * @return array
	 */
	public function getStubVariables() : array;

	/**
	 * stub path example:  /stubs/laraction/route.stub
	 *
	 * @return string
	 */
	public function getStubPath() : string;

	public function getStubDescription() : string;


}