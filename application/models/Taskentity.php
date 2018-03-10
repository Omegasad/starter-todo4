<?php

/**
 * Task entity class, with setter methods for each property.
 */
class TaskEntity extends Entity {

	protected $id;
        protected $tasks;
	protected $flags;
	protected $groups;
	protected $priority;
	protected $sizes;
	protected $statues;
	
	function setId($value) {
		if (empty($value))
			throw new InvalidArgumentException('An Id must have a value');
		else if ($value < 0) 
			throw new InvalidArgumentException('Value must be greater than 0');
		$this->id = $value;
		return $this;
	}
        
        function setTasks($value) {
		
                if(strlen($value) > 20)
                    throw new InvalidArgumentException('Task is more than 20 characters');
		if (empty($value))
                    throw new InvalidArgumentException('Task cannot be empty');
		$this->tasks = $value;
		return $this;
	}
	
	function setFlags($value) {
		$allowed = ['Urgent'];
		if (!in_array($value, $allowed))
			throw new InvalidArgumentException('Invalid flag selection');
		$this->flags = $value;
		return $this;
	}
	
	function setGroups($value) {
		$allowed = ['house','school','work','family'];
		if (!in_array($value, $allowed))
			throw new InvalidArgumentException('Invalid group selection');
		$this->groups = $value;
		return $this;
	}
	
	function setPriority($value) {
		$allowed = ['low','medium','high'];
		if (!in_array($value, $allowed))
			throw new InvalidArgumentException('Invalid priority selection');
		$this->priority = $value;
		return $this;
	}
		
	function setSizes($value) {
		$allowed = ['small','medium','large'];
		if (!in_array($value, $allowed))
			throw new InvalidArgumentException('Invalid size selection');
		$this->sizes = $value;
		return $this;
	}

	function setStatues($value) {
		$allowed = ['in progress','complete'];
		if (!in_array($value, $allowed))
			throw new InvalidArgumentException('Invalid status selection');
		$this->statues = $value;
		return $this;
	}	
        
}
