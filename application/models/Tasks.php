<?php
class Tasks extends XML_Model {

        public function __construct()
        {
                parent::__construct(APPPATH . '../data/tasks.xml', 'id');
        }

        function getCategorizedTasks()
        {
            // extract the undone tasks
            foreach ($this->all() as $task)
            {
                if ($task->status != 2)
                    $undone[] = $task;
            }

            // substitute the category name, for sorting
            foreach ($undone as $task)
                $task->group = $this->app->group($task->group);

            // order them by category
            usort($undone, "orderByCategory");

            // convert the array of task objects into an array of associative objects       
            foreach ($undone as $task)
                $converted[] = (array) $task;

            return $converted;
        }
		
		// provide form validation rules to prevent cross script attacks
		public function rules()
		{
			$config = array(
				['field' => 'task', 'label' => 'TODO task', 'rules' => 'alpha_numeric_spaces|max_length[64]'],
				['field' => 'priority', 'label' => 'Priority', 'rules' => 'integer|less_than[4]'],
				['field' => 'size', 'label' => 'Task size', 'rules' => 'integer|less_than[4]'],
				['field' => 'group', 'label' => 'Task group', 'rules' => 'integer|less_than[5]'],
			);
			return $config;
		}
                
                protected function load()
                {
                    $first = true;
                    $dataindex = 1;
                    $count = 0;
                    if (($tasks = simplexml_load_file($this->_origin)) !== FALSE)
                    {
                            foreach ($tasks as $task) {
                                    $record = new stdClass();
                                    $record->id = (int) $task['id'];
                                    $record->task = (string) $task->task;
                                    $record->priority = (int) $task->priority;
                                    $record->size = (int) $task->size;
                                    $record->group = (int) $task->group;
                                    $record->deadline = (string) $task->deadline;
                                    if((int) $task->status != NULL) {
                                        $record->status = (int) $task->status;
                                    } else {
                                       $record->status = ""; 
                                    }
                                    $record->flag = (int) $task->flag;

                                    $this->_data[$record->id] = $record;
                            //}
                            if($first){
                                    foreach ($task as $key => $value) {
                                            $keyfieldh[] = $key;	
                                            //echo " key: ".$key." value: ".$value;
                                            //echo " keyfieldh: " . $keyfieldh[$count];
                                            //var_dump((string)$value);
                                            $count++;
                                    }
                                    $this->_fields = $keyfieldh;
                                }
                            $first = false; 
                    }

		// rebuild the keys table
                    $this->reindex();
                    }
                }
                
        protected function store()
	{
		
		// rebuild the keys table
		$this->reindex();
		//---------------------
                
                 $this->xml = simplexml_load_file(realpath($this->_origin));
		    if ($this->xml === false) {
			      // error so redirect or handle error
			      header('location: /404.php');
			      exit;
		}
		
		if (($handle = fopen($this->_origin, "w")) !== FALSE)
		{
                    $xmlDoc = new DOMDocument( "1.0");
                    $xmlDoc->preserveWhiteSpace = false;
                    $xmlDoc->formatOutput = true;
                    $data = $xmlDoc->createElement($this->xml->getName());
                    foreach($this->_data as $key => $value)
                    {
                        $task  = $xmlDoc->createElement($this->xml->children()->getName());
                        foreach ($value as $itemkey => $record ) {
                            if($itemkey == 'id') {
                                $task->setAttribute($itemkey, $record);
                              
                            } else {
                                if($record != NULL) {
                                    $item = $xmlDoc->createElement($itemkey, htmlspecialchars($record));                                    
                                }
                                $task->appendChild($item);
                            }
                        }
                            $data->appendChild($task);
                    }
                        $xmlDoc->appendChild($data);
                        $xmlDoc->saveXML($xmlDoc);
                        $xmlDoc->save($this->_origin);
                }
                
         }
}
?>