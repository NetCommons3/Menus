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
    $scope.switchOpenClose(key);
  };

  /**
   * 切り替え
   *
   * @return {void}
   */
  $scope.switchOpenClose = function(key) {
    angular.forEach($scope.menus[key], function(domId) {
      $('#' + domId).toggle();
      if ($('#' + domId).is(':visible')) {
        console.log('visible');
      } else {
        console.log('none');
      }
    });
  };

});
