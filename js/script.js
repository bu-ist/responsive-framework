(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

var _toggle = require("responsive-foundation/js-dev/dist/toggle");

/**
 * The entry point for theme scripts.
 *
 * Modules are imported and compiled into one resulting `theme.js` file.
 *
 * @package ResponsiveFramework
 */
// Import Foundation scripts.
(0, _toggle.toggle)();

},{"responsive-foundation/js-dev/dist/toggle":3}],2:[function(require,module,exports){
function _interopRequireDefault(obj) {
  return obj && obj.__esModule ? obj : {
    "default": obj
  };
}

module.exports = _interopRequireDefault;
},{}],3:[function(require,module,exports){
(function (global){
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.toggle = toggle;

var _jquery = _interopRequireDefault((typeof window !== "undefined" ? window['jQuery'] : typeof global !== "undefined" ? global['jQuery'] : null));

/**
 * Toggle behavior for navigation / search buttons.
 *
 * @package ResponsiveFoundation
 */
function toggle() {
  var $body = (0, _jquery.default)('body');
  var $toggle = (0, _jquery.default)('.js-nav-toggle');
  var $toggleitems = $toggle.add('nav');
  var $searchtoggle = (0, _jquery.default)('.js-search-toggle');
  var $searchitems = $searchtoggle.add('#quicksearch'); // Add aria attributes for control/expanded if JS is available

  $searchtoggle.attr('aria-expanded', 'false').attr('aria-controls', 'quicksearch');
  $toggle.attr('aria-expanded', 'false').attr('aria-controls', 'primary-nav-menu');
  $toggle.on('click', function (e) {
    e.preventDefault();

    if ($toggle.attr('aria-expanded') === 'false') {
      $toggle.attr('aria-expanded', 'true').attr('aria-label', 'Close menu');
    } else {
      $toggle.attr('aria-expanded', 'false').attr('aria-label', 'Open menu');
    }

    $toggleitems.toggleClass('is-open');
    $searchitems.removeClass('is-open');
    $body.toggleClass('nav-open').removeClass('search-open');
  });

  function toggleSearchPanel(focus) {
    $toggleitems.removeClass('is-open');

    if (focus === true && !(0, _jquery.default)(this).hasClass('is-open')) {
      setTimeout(function () {
        (0, _jquery.default)('#q').focus();
      }, 100);
    }

    if ($searchtoggle.attr('aria-expanded') === 'false') {
      $searchtoggle.attr('aria-expanded', 'true').attr('aria-label', 'Close search');
    } else {
      $searchtoggle.attr('aria-expanded', 'false').attr('aria-label', 'Open search');
    }

    $searchitems.toggleClass('is-open');
    $body.toggleClass('search-open').removeClass('nav-open');
  }

  $searchtoggle.on({
    click: function click(e) {
      e.preventDefault();
      toggleSearchPanel(true);
    },
    keypress: function keypress(e) {
      if (e.keyCode === 13) {
        e.preventDefault();
        toggleSearchPanel(false);
      }
    }
  });
}

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{"@babel/runtime/helpers/interopRequireDefault":2}]},{},[1]);
