/**
 * @fileoverview Menus Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * MenusController Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('MenusController', ['$scope', function($scope) {

  /**
   * data
   *
   * @type {object}
   */
  $scope.menus = {};

  /**
   * Initialize
   *
   * @return {void}
   */
  $scope.initialize = function(key, data, toggle) {
    $scope.menus[key] = data;
    angular.forEach($scope.menus[key], function(domId) {
      if (toggle) {
        $('#' + domId).show();
      } else {
        $('#' + domId).hide();
      }
    });
  };

  /**
   * 切り替え
   *
   * @return {void}
   */
  $scope.switchOpenClose = function($event, key) {
    angular.forEach($scope.menus[key], function(domId) {
      $('#' + domId).toggle();
    });
    if (angular.isObject($event)) {
      $event.preventDefault();
      $event.stopPropagation();
    }
  };

}]);
