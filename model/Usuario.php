<?php
class Usuario extends ActiveRecord\Model
{
	// order belongs to a person
	static $belongs_to = array(
		array('grupo')		
		);

}
?>
