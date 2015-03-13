<?php
class Banco extends ActiveRecord\Model
{

	static $has_many = array(
		array('cuentas')
    );
	

	
}
?>