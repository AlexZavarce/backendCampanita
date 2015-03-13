<?php
class Grupo extends ActiveRecord\Model
{

	static $has_many = array(
		array('usuarios'),
		array('grupopantallas')

    );
	

	
}
?>
