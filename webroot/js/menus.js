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
NetCommonsApp.controller('MenusController', function($scope) {

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
  $scope.initialize = function(key, data, togggle) {
    $scope.menus[key] = data;
    angular.forEach($scope.menus[key], function(domId) {
      if (togggle) {
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
  $scope.switchOpenClose = function(key) {
    angular.forEach($scope.menus[key], function(domId) {
      $('#' + domId).toggle();
    });
  };

});
