<?php
	class View
	{
		public function show ($_view = null)
		{
			try
			{
				http_response_code(BAD_REQUEST);

				if ($_view == null)
				{
					$allowedParams = explode(DELIMITER, VIEW_PARAMS);

					$params = Validation::get($allowedParams);
					$view = constant(strtoupper($params[$allowedParams[0]]) . VIEW_PREFIX);
				}
				else $view = $_view;

				$view = Maintenance::getViewOutput($view);

				if (!@include_once $view) throw new Exception(MODULE_MSG . ' (' . $view . ')');
			}
			catch (Exception $ex)
			{
				Maintenance::handleExceptions($ex);
			}
		}
	}
?>