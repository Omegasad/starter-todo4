<?php

use PHPUnit\Framework\TestCase;
// Extend from the entity

 class TaskTest extends TestCase
  {
    private $CI;
    public function setUp()
    {
      // Load CI instance normally
      $this->CI = &get_instance();
	  $this->CI->load->model('taskentity');
	  $this->item = new TaskEntity();
	  $this->item->id = 1;
    }
	
    public function testGetPost()
    {
      $_SERVER['REQUEST_METHOD'] = 'GET';
      $_GET['foo'] = 'bar';
      $this->assertEquals('bar', $this->CI->input->get_post('foo'));
    }
	
	function testSetup()
	{
	  $this->assertEquals(1, $this->item->id);
	}
	
	function testValidId()
	{
		$valid = 123;
		$this->item->id= $valid;
		$this->assertEquals($valid,$this->item->id);
	}
	
	function testInvalidId()
	{
		$invalid = -1;
		$this->expectException('InvalidArgumentException');
		$this->item->id= $invalid;
	}
        
        function testValidTask()
	{
		$valid = "wash windows";
		$this->item->tasks= $valid;
		$this->assertEquals($valid,$this->item->tasks);
	}
	
	function testInvalidTask()
	{
		$invalid = "wash all the windows in vancouver plus the ones"
                        . "in toronto plus the ones in america plus the ones"
                        . "in france wow that's so many windows to wash this "
                        . "task is way too long";
		$this->expectException('InvalidArgumentException');
		$this->item->tasks= $invalid;
	}
        
        function testEmptyTask()
	{
		$this->expectException('InvalidArgumentException');
		$this->item->tasks= "";
	}
        
        function testEmptyId()
	{
		$this->expectException('InvalidArgumentException');
		$this->item->id= "";
	}
	
	function testValidFlags()
	{
		$valid = 'Urgent';
		$this->item->flags = $valid;
		$this->assertEquals($valid,$this->item->flags);
	}
	
	function testInvalidFlags()
	{
		$invalid = 'Not Urgent';
		$this->expectException('InvalidArgumentException');
		$this->item->flags= $invalid;
	}
	
	function testValidGroups()
	{
		$valid = 'work';
		$this->item->groups = $valid;
		$this->assertEquals($valid,$this->item->groups);
	}

	function testInvalidGroups()
	{
		$invalid = 'business';
		$this->expectException('InvalidArgumentException');
		$this->item->groups = $invalid;
	}
        
        function testEmptyGroups()
	{
		$this->expectException('InvalidArgumentException');
		$this->item->groups= "";
	}
	
	function testValidPriorities()
	{
		$valid = 'low';
		$this->item->priority = $valid;
		$this->assertEquals($valid,$this->item->priority);
	}

	function testInvalidPriorities()
	{
		$invalid = 'omega high';
		$this->expectException('InvalidArgumentException');
		$this->item->priority = $invalid;
	}
        
        function testEmptyPriorities()
	{
		$this->expectException('InvalidArgumentException');
		$this->item->priority= "";
	}
	
	function testValidSizes()
	{
		$valid = 'small';
		$this->item->sizes = $valid;
		$this->assertEquals($valid,$this->item->sizes);
	}

	function testInvalidSizes()
	{
		$invalid = 'giant';
		$this->expectException('InvalidArgumentException');
		$this->item->sizes = $invalid;
	}	
        
        function testEmptySizes()
	{
		$this->expectException('InvalidArgumentException');
		$this->item->sizes= "";
	}
	
	function testValidStatuses()
	{
		$valid = 'in progress';
		$this->item->statues = $valid;
		$this->assertEquals($valid,$this->item->statues);
	}

	function testInvalidStatuses()
	{
		$invalid = 'half done';
		$this->expectException('InvalidArgumentException');
		$this->item->statues = $invalid;
	}	
  }