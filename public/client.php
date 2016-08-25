<!DOCTYPE html>
<html lang="en-US">

<?

if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1" || $_SERVER['REMOTE_ADDR'] == "::1") {
    $REST_URL = "mobile.camemis.home";
} else {
    $REST_URL = "mobile.camemis.de";
}
?>

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
</head>

<script>
    angular.module('myApp', [])
        .controller('myCtrl', function ($scope, $http) {
            $scope.actionCheckSchool = function () {
                var postdata = {};
                postdata.url = $scope.url;
                postdata.action_key = "Pu0QUvj82x";
                $http.post("http://<?=$REST_URL;?>", postdata, {
                    //headers: {'tokenId': 'Pu0QUvj82xZ15AcO0PTe6L2EnOLNTB1QJaH'}
                }).success(function (data, status) {
                    //
                });
            };
            $scope.actionLogin = function () {
                var postdata = {};
                postdata.role = $scope.role;
                postdata.username = $scope.username;
                postdata.password = $scope.password;
                postdata.action_key = "EnOLNTB1Q";
                $http.post("http://<?=$REST_URL;?>", postdata, {
                    //headers: {'tokenId': 'Pu0QUvj82xZ15AcO0PTe6L2EnOLNTB1QJaH'}
                }).success(function (data, status) {
                    //
                });
            };

            $scope.actionStudentCurrentAcademic = function () {
                $http({
                    method: 'GET', url: "http://<?=$REST_URL;?>/student", headers: {
                        'Authorization': 'current-academic'
                    }
                }).success(function (data, status) {
                    //....
                });
            };

            $scope.actionStudentAttendance = function () {
                $http({
                    method: 'GET', url: "http://<?=$REST_URL;?>/student", headers: {
                        'Authorization': 'student-attendance'
                    }
                }).success(function (data, status) {
                    //....
                });
            };

            $scope.actionStudentDiscipline = function () {
                $http({
                    method: 'GET', url: "http://<?=$REST_URL;?>/student", headers: {
                        'Authorization': 'student-discipline'
                    }
                }).success(function (data, status) {
                    //....
                });
            };

            $scope.actionStudentGradebook = function () {
                $http({
                    method: 'GET', url: "http://<?=$REST_URL;?>/student", headers: {
                        'Authorization': 'student-gradebook'
                    }
                }).success(function (data, status) {
                    //....
                });
            };

            $scope.actionStudentWeeklySchedule = function () {
                $http({
                    method: 'GET', url: "http://<?=$REST_URL;?>/student", headers: {
                        'Authorization': 'student-weekly-schedule'
                    }
                }).success(function (data, status) {
                    //....
                });
            };

            $scope.actionStudentDailySchedule = function () {
                $http({
                    method: 'GET', url: "http://<?=$REST_URL;?>/student", headers: {
                        'Authorization': 'student-daily-schedule'
                    }
                }).success(function (data, status) {
                    //....
                });
            };

        });
</script>
<body ng-app="myApp">
<div class="container" ng-controller="myCtrl">
    <h2>Check School</h2>
    <form class="form-horizontal" ng-submit="actionCheckSchool()" role="form">
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">School Url:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" ng-model="url" placeholder="School Url">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
    <hr>
    <h2>Logion</h2>
    <form class="form-horizontal" ng-submit="actionLogin()" role="form">
        <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Login-Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" ng-model="username" placeholder="username">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Password:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" ng-model="password" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Role:</label>
            <div class="col-sm-10">
                <select class="form-control" ng-model="role">
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
    <hr>
    <h2>Student (Current Academic)</h2>
    <div class="form-group">
        <button ng-click="actionStudentCurrentAcademic();" class="btn btn-default">Check...</button>
    </div>
    <hr>
    <h2>Student (Attendance)</h2>
    <div class="form-group">
        <button ng-click="actionStudentAttendance();" class="btn btn-default">Check...</button>
    </div>
    <hr>
    <h2>Student (Discipline)</h2>
    <button ng-click="actionStudentDiscipline();" class="btn btn-default">Check...</button>
    <hr>
    <h2>Student (Weekly Schedule)</h2>
    <button ng-click="actionStudentWeeklySchedule();" class="btn btn-default">Check...</button>
    <hr>
    <h2>Student (Daily Schedule)</h2>
    <button ng-click="actionStudentDailySchedule();" class="btn btn-default">Check...</button>
    <hr>
    <h2>Student (Gradebook)</h2>
    <button type="submit" class="btn btn-default">Check...</button>
    <hr>
</div>
</body>
</html>
