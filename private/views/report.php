<?php
	// try
	// {
	// 	$allowedParams = explode(DELIMITER, GET_CONTENT_PARAMS);
	// 	$err = Validation::requiredOnGet($allowedParams);

	// 	if (!empty($err)) throw new Exception(API_PARAMETERS_MSG . ' (' . implode(DELIMITER, $err) . ')');

	// 	$get = Validation::get($allowedParams);

	// 	if (!Validation::checkLength($get[$allowedParams[0]], ['max' => MAX_PID_LENGTH])) throw new Exception(API_PARAMETERS_MSG . ' (' . $allowedParams[0] . ')');

	// 	$obj = new Content();

	// 	$result = $obj -> get($get);

	// 	$result = $result['result'];
	// }
	// catch (Exception $ex)
	// {
	// 	Maintenance::handleApiErrors($ex);
	// }
?>
				<div ng-controller="ReportCtrl">
					<table>
						<tr>
							<th>Name / Questions</th>
							<th ng-repeat="q in questions">{{q.option1}}(0) or {{q.option2}}(1)</th>
						</tr>
						<tr ng-repeat="user in data">
							<th>{{user.name}}</th>
							<td ng-repeat="x in user.answers">{{x}}</td>
						</tr>
					</table>
					<table>
						<tr>
							<th></th>
							<th ng-repeat="user in data">{{user.name}}</th>
						</tr>
						<tr ng-repeat="user in data">
							<th>{{user.name}}</th>
							<td ng-repeat="x in user.nearest">{{x.percent}}% ({{x.raw}})</td>
						</tr>
					</table>
				</div>