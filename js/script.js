!function o(i,u,l){function f(t,e){if(!u[t]){if(!i[t]){var n="function"==typeof require&&require;if(!e&&n)return n(t,!0);if(s)return s(t,!0);var r=new Error("Cannot find module '"+t+"'");throw r.code="MODULE_NOT_FOUND",r}var a=u[t]={exports:{}};i[t][0].call(a.exports,function(e){return f(i[t][1][e]||e)},a,a.exports,o,i,u,l)}return u[t].exports}for(var s="function"==typeof require&&require,e=0;e<l.length;e++)f(l[e]);return f}({1:[function(d,e,t){(function(r){!function o(i,u,l){function f(t,e){if(!u[t]){if(!i[t]){var n="function"==typeof d&&d;if(!e&&n)return n(t,!0);if(s)return s(t,!0);var r=new Error("Cannot find module '"+t+"'");throw r.code="MODULE_NOT_FOUND",r}var a=u[t]={exports:{}};i[t][0].call(a.exports,function(e){return f(i[t][1][e]||e)},a,a.exports,o,i,u,l)}return u[t].exports}for(var s="function"==typeof d&&d,e=0;e<l.length;e++)f(l[e]);return f}({1:[function(e,t,n){(function(e){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var t,u=(t="undefined"!=typeof window?window.jQuery:void 0!==e?e.jQuery:null)&&t.__esModule?t:{default:t};n.default=function(){var t=(0,u.default)("body"),n=(0,u.default)(".js-nav-toggle"),r=n.add("nav"),a=(0,u.default)(".js-search-toggle"),o=a.add("#quicksearch");function i(e){r.removeClass("is-open"),!0!==e||(0,u.default)(this).hasClass("is-open")||setTimeout(function(){(0,u.default)("#q").focus()},100),"false"===a.attr("aria-expanded")?a.attr("aria-expanded","true").attr("aria-label","Close search"):a.attr("aria-expanded","false").attr("aria-label","Open search"),o.toggleClass("is-open"),t.toggleClass("search-open").removeClass("nav-open")}a.attr("aria-expanded","false").attr("aria-controls","quicksearch"),n.attr("aria-expanded","false").attr("aria-controls","primary-nav-menu"),n.on("click",function(e){e.preventDefault(),"false"===n.attr("aria-expanded")?n.attr("aria-expanded","true").attr("aria-label","Close menu"):n.attr("aria-expanded","false").attr("aria-label","Open menu"),r.toggleClass("is-open"),o.removeClass("is-open"),t.toggleClass("nav-open").removeClass("search-open")}),a.on({click:function(e){e.preventDefault(),i(!0)},keypress:function(e){13===e.keyCode&&(e.preventDefault(),i(!1))}})}}).call(this,void 0!==r?r:"undefined"!=typeof self?self:"undefined"!=typeof window?window:{})},{}],2:[function(e,t,n){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),Object.defineProperty(n,"toggle",{enumerable:!0,get:function(){return a.default}});var r,a=(r=e("./modules/toggle"))&&r.__esModule?r:{default:r};(0,a.default)()},{"./modules/toggle":1}]},{},[2])}).call(this,"undefined"!=typeof global?global:"undefined"!=typeof self?self:"undefined"!=typeof window?window:{})},{}],2:[function(e,t,n){"use strict";var r=e("@babel/runtime/helpers/interopRequireDefault")(e("responsive-foundation"));console.log(r.default)},{"@babel/runtime/helpers/interopRequireDefault":3,"responsive-foundation":1}],3:[function(e,t,n){t.exports=function(e){return e&&e.__esModule?e:{default:e}}},{}]},{},[2]);
//# sourceMappingURL=script.js.map