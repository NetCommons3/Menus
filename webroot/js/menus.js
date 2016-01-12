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
  $scope.initialize = function(key, data) {
    $scope.menus[key] = data;
  };

});
