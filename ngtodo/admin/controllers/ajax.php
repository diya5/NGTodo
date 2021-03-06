<?php

class NGTodoControllersAjax extends NGTodoControllersDisplay {

	function execute() {

		// Get the application
		$app = $this->getApplication();

		// Get the document object.
		$document = JFactory::getDocument();

		$viewName = $app->input->getWord('view', 'display');
		$viewFormat = $document->getType();
		$layoutName = $app->input->getWord('layout', 'default');

		$app->input->set('view', $viewName);

		// Register the layout paths for the view
		$paths = new SplPriorityQueue;
		$paths->insert(JPATH_COMPONENT_ADMINISTRATOR . '/views/' . $viewName . '/tmpl', 'normal');

		$viewClass = 'NGTodoViews' . ucfirst($viewName) . ucfirst($viewFormat);
		$modelClass = 'NGTodoModels' . ucfirst($viewName);

		if (false === class_exists($modelClass))
		{
			$modelClass = 'NGTodoModelsDefault';
		}

		$model = new $modelClass();

		$data = $model->listItems();

		//for better security, add a prefix before echoing
		$prefix =")]}',\n";

		$json = json_encode($data);

		echo $prefix.$json;
		$app->close();
	}



}