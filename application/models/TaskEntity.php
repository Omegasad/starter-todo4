<?php

/**
 * Task entity class, with setter methods for each property.
 */
class Entity extends CI_Model {

	$id;
	$flags;
	$groups;
	$priority;
	$sizes;
	$statues;
	
    // If this class has a setProp method, use it, else modify the property directly
    public function __set($key, $value) {
        // if a set* method exists for this key, 
        // use that method to insert this value. 
        // For instance, setName(...) will be invoked by $object->name = ...
        // and setLastName(...) for $object->last_name = 
        $method = 'set' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key)));

        if (method_exists($this, $method))
        {
            $this->$method($value);

            return $this;
        }

        // Otherwise, just set the property value directly.
        $this->$key = $value;
        
        return $this;
    }
	
	function setId($value) {
		if ($value > 0) {
			$id = $value;
		}
	}
	
	function setFlags($value) {
		if ($value != 0 || $value != 1) {
			$flags = $value;
		}
	}
	
	function setGroups($value) {
		if ($value > 0 && $value < 5) {
			$groups = $value;
		}

	}
	
	function setPriority($value) {
		if ($value > 0 && $value < 4) {
			$priority = $value;
		}
	}
		
	function setSizes($values) {
		if ($values > 0 && $values < 4) {
			$sizes = $value;
		}
	}

	function setStatues($values) {
		if ($values > 0 && $values < 3) {
			$statues = $value;
		}
	}	
}
