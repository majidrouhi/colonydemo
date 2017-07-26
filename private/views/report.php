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
							<td ng-repeat="x in user.data">{{x.totalPercent}}% ( {{x.similarCount}} )</td>
						</tr>
					</table>
				</div>