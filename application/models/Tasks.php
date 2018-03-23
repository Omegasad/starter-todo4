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
                    echo "begin ";
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
                                $item = $xmlDoc->createElement($itemkey, htmlspecialchars($record));
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