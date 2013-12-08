'use strict';

/* Controllers */

angular.module('KdigApp.controllers', []).
  controller('KdigApp.example',['$scope'], function($scope){
    alert('try');
  })
  .controller('rootCtrl', ['$scope', 'Hello', function($scope, Hello) {
    // Simple communication sample, return world
    $scope.hello = Hello.get();
  }])
  .controller('usrCtrl', ['$scope', 'Todos', function($scope, Todos) {
    // Load Todos with secured connection
    $scope.todos = Todos.query();

    $scope.addTodo = function() {
        var todo = {text:$scope.todoText, done:false};
        $scope.todos.push(todo);
        $scope.todoText = '';
    };

    $scope.remaining = function() {
        var count = 0;
        angular.forEach($scope.todos, function(todo) {
            count += todo.done ? 0 : 1;
        });
        return count;
    };

    $scope.archive = function() {
        var oldTodos = $scope.todos;
        $scope.todos = [];
        angular.forEach(oldTodos, function(todo) {
            if (!todo.done) $scope.todos.push(todo);
        });
    };
  }]);