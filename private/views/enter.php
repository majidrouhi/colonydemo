        <div id="container">
            <div id="logo"></div>
            <section ng-show="loginShow">
                <div class="que">The world's first WYR-based social network</div>
                <input id="input" autocorrect="off" spellcheck="false" autocapitalize="off" autofocus="true" placeholder="Please enter your full name" type="text" ng-model="name">
                <div id="button" ng-click="start(name)">Start Demo</div>
            </section>
            <section ng-show="questionsShow">
                <div class="title">Would you rather</div>
                <div class="finish" ng-click="start(name)">FINISH</div>
                <div class="que">Please answer minimum 5 questions of 35: {{currentQ + 1}}</div>
                <div class="buttonwrap">
                    <div class="rather" id="r0">
                        <div id="optLeft" class="text">{{option1}}</div>
                    </div>
                    <div class="rather" id="r1">
                        <div id="optRight" class="text">{{option2}}</div>
                    </div>
                    <div id="ratebox">
                        <div class="rate" ng-click="answer(1)" id="firsthigh"></div>
                        <div class="rate" ng-click="answer(2)" id="first"></div>
                        <div class="rate" ng-click="answer(3)" id="tie"></div>
                        <div class="rate" ng-click="answer(4)" id="sec"></div>
                        <div class="rate" ng-click="answer(5)" id="sechigh"></div>
                    </div>
                </div>
                <div id="gesture"></div>
                <div id="guide">By tapping on color buttons tell us <br>how much would you rather each choice.<br><t class="bold">If you like both simply press GRAY button.</t></div>
            </section>
            <section ng-show="reportShow">
                <div class="title">Your Matches</div>
                <div class="que">Here are like-minded people around you</div>
                <section ng-repeat="data in userReport">
                    <div class="match">
                        <div class="formica">{{data.name}}</div>
                        <div class="percent">% {{data.totalPercent}}</div>
                        <div class="answers">{{data.similarCount}} Common Questions</div>
                    </div>
                </section>
                <div id="ending">
                    <div id="guide"><t class="bold">Thanks for participating in our demo app.</t><br> Please help us to improve our app if you have any suggestions or questions feel free to contact us by<br><a href="mailto:report@thecolonyapp.com" target="_blank" >report[at]mython.ir</a></div>
                </div>
            </section>
        </div>