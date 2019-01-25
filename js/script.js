(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

var _responsiveFoundation = _interopRequireDefault(require("responsive-foundation"));

},{"@babel/runtime/helpers/interopRequireDefault":2,"responsive-foundation":3}],2:[function(require,module,exports){
function _interopRequireDefault(obj) {
  return obj && obj.__esModule ? obj : {
    default: obj
  };
}

module.exports = _interopRequireDefault;
},{}],3:[function(require,module,exports){
(function (global){
!function o(l,i,s){function u(a,e){if(!i[a]){if(!l[a]){var t="function"==typeof require&&require;if(!e&&t)return t(a,!0);if(d)return d(a,!0);var r=new Error("Cannot find module '"+a+"'");throw r.code="MODULE_NOT_FOUND",r}var n=i[a]={exports:{}};l[a][0].call(n.exports,function(e){return u(l[a][1][e]||e)},n,n.exports,o,l,i,s)}return i[a].exports}for(var d="function"==typeof require&&require,e=0;e<s.length;e++)u(s[e]);return u}({1:[function(e,a,r){(function(e){"use strict";Object.defineProperty(r,"__esModule",{value:!0}),r.default=void 0;var a;(a="undefined"!=typeof window?window.jQuery:void 0!==e?e.jQuery:null)&&a.__esModule;var t=Toggle=function(a){var t=a("body"),r=a(".js-nav-toggle"),n=r.add("nav"),o=a(".js-search-toggle"),l=o.add("#quicksearch");function i(e){n.removeClass("is-open"),!0!==e||a(this).hasClass("is-open")||setTimeout(function(){a("#q").focus()},100),"false"===o.attr("aria-expanded")?o.attr("aria-expanded","true").attr("aria-label","Close search"):o.attr("aria-expanded","false").attr("aria-label","Open search"),l.toggleClass("is-open"),t.toggleClass("search-open").removeClass("nav-open")}o.attr("aria-expanded","false").attr("aria-controls","quicksearch"),r.attr("aria-expanded","false").attr("aria-controls","primary-nav-menu"),r.on("click",function(e){e.preventDefault(),"false"===r.attr("aria-expanded")?r.attr("aria-expanded","true").attr("aria-label","Close menu"):r.attr("aria-expanded","false").attr("aria-label","Open menu"),n.toggleClass("is-open"),l.removeClass("is-open"),t.toggleClass("nav-open").removeClass("search-open")}),o.on({click:function(e){e.preventDefault(),i(!0)},keypress:function(e){13===e.keyCode&&(e.preventDefault(),i(!1))}})};r.default=t}).call(this,"undefined"!=typeof global?global:"undefined"!=typeof self?self:"undefined"!=typeof window?window:{})},{}],2:[function(e,a,t){"use strict";var r;Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n={Toggle:((r=e("./modules/toggle"))&&r.__esModule?r:{default:r}).default};t.default=n},{"./modules/toggle":1}]},{},[2]);

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{}]},{},[1]);
