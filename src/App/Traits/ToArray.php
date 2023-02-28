<?php

namespace Laraction\App\Traits;

trait ToArray 
{
	public function toArray() {
		return get_object_vars( $this ); 
	}
}

?>