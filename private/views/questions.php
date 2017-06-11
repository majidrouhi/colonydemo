				<section ng-controller="QuestionsCtrl">
					<form ng-submit="start(name)" id="login-form" ng-show="loginShow">
						<h5 id="error">{{message}}</h5>
						<input id="name" tabindex="1" autocorrect="off" spellcheck="false" autocapitalize="off" autofocus="true" placeholder="Y O U R &nbsp N A M E" type="text" ng-model="name" ng-change="hideMessage()">
						<button id="login" tabindex="2" type="submit">ENTER</button>
					</form>
					<div id="questions" ng-show="questionsShow">
						<h3>Welcome {{name}}!</h3>
						<h5>Question: {{currentQ + 1}} / 35</h5>
						<button id="optLeft" type="submit" ng-click="answer(0)">{{option1}}</button>
						<button id="optRight" type="submit" ng-click="answer(1)">{{option2}}</button>
					</div>
					<div ng-show="finishShow">
						<h3 id="finish">{{message}}</h3>
					</div>
				</section>