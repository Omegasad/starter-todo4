<?php

use PHPUnit\Framework\TestCase;
// Extend from the entity

 class TaskListTest extends TestCase
  {
    private $CI;
    public function setUp()
    {
      // Load CI instance normally
        $this->CI = &get_instance();
          $this->CI->load->model('tasks');
          $this->tasks = new Tasks();
    }
    
    public function testUncompleteGreaterThanComplete() 
    {
            foreach ($this->tasks->all() as $task)
            {
                if ($task->status != 2) {
                    $undone[] = $task;
                } else if ($task->status == 2) {
                    $done[] = $task;
                }

            }
            
            $this->assertLessThan(count($undone),
                count($done));
    }
	
  }