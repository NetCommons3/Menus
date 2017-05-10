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
NetCommonsApp.controller('MenusController', ['$scope', '$window', function($scope, $window) {

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

  /**
   * クリック
   *
   * @return {void}
   */
  $scope.linkClick = function(domId) {
    var domEl = $('#' + domId);
    if (angular.isObject(domEl[0])) {
      $window.location.href = domEl[0].href;
    }
  };

}]);


/**
 * MenusController Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('MenuFrameSettingsController', ['$scope', function($scope) {

  /**
   * チェッククリックした際に配下ページをチェックする
   *
   * @return {void}
   */
  $scope.checkChildPages = function($event, domChildPageIds) {
    var checked = $event.target.checked;

    angular.forEach(domChildPageIds, function(domId) {
      var domEl = $('#' + domId);
      if (angular.isObject(domEl[0])) {
        domEl[0].checked = checked;
      }
    });
  };

  /**
   * チェッククリックした際に配下ページをDisableにする
   *
   * @return {void}
   */
  $scope.disableChildPages = function($event, domChildPageIds) {
    var checked = $event.target.checked;

    angular.forEach(domChildPageIds, function(domId) {
      var domEl = $('#' + domId);
      if (angular.isObject(domEl[0])) {
        if (! domEl[0].checked) {
          domEl[0].checked = checked;
        }
        domEl[0].disabled = !checked;
      }
    });
  };

}]);
