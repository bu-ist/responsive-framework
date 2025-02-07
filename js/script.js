! function o(l, i, s) {
	function u(a, e) {
		if (!i[a]) {
			if (!l[a]) {
				var t = "function" == typeof require && require;
				if (!e && t) return t(a, !0);
				if (d) return d(a, !0);
				var n = new Error("Cannot find module '" + a + "'");
				throw n.code = "MODULE_NOT_FOUND", n
			}
			var r = i[a] = {
				exports: {}
			};
			l[a][0].call(r.exports, function (e) {
				return u(l[a][1][e] || e)
			}, r, r.exports, o, l, i, s)
		}
		return i[a].exports
	}
	for (var d = "function" == typeof require && require, e = 0; e < s.length; e++) u(s[e]);
	return u
}({
	1: [function (e, a, t) {
		"use strict";
		(0, e("responsive-foundation/js-dev/dist/toggle").toggle)()
	}, {
		"responsive-foundation/js-dev/dist/toggle": 3
	}],
	2: [function (e, a, t) {
		a.exports = function (e) {
			return e && e.__esModule ? e : {
				default: e
			}
		}
	}, {}],
	3: [function (t, e, n) {
		(function (a) {
			(function () {
				"use strict";
				var e = t("@babel/runtime/helpers/interopRequireDefault");
				Object.defineProperty(n, "__esModule", {
					value: !0
				}), n.toggle = function () {
					var a = (0, u.default)("body"),
						t = (0, u.default)(".js-nav-toggle"),
						n = t.children(".nav-toggle-label-open").text(),
						r = t.children(".nav-toggle-label-closed").text(),
						o = t.add("nav"),
						l = (0, u.default)(".js-search-toggle"),
						i = l.add("#quicksearch");

					function s(e) {
						o.removeClass("is-open"), !0 !== e || (0, u.default)(this).hasClass("is-open") || setTimeout(function () {
							(0, u.default)("#q").focus()
						}, 100), "false" === l.attr("aria-expanded") ? l.attr("aria-expanded", "true").attr("aria-label", "Close search") : l.attr("aria-expanded", "false").attr("aria-label", "Open search"), i.toggleClass("is-open"), a.toggleClass("search-open").removeClass("nav-open")
					}
					l.attr("aria-expanded", "false").attr("aria-controls", "quicksearch"), t.attr("aria-expanded", "false").attr("aria-controls", "primary-nav-menu"), t.on("click", function (e) {
						e.preventDefault(), "false" === t.attr("aria-expanded") ? t.attr("aria-expanded", "true").attr("aria-label", n) : t.attr("aria-expanded", "false").attr("aria-label", r), o.toggleClass("is-open"), i.removeClass("is-open"), a.toggleClass("nav-open").removeClass("search-open")
					}), l.on({
						click: function (e) {
							e.preventDefault(), s(!0)
						},
						keypress: function (e) {
							13 === e.keyCode && (e.preventDefault(), s(!1))
						}
					})
				};
				var u = e("undefined" != typeof window ? window.jQuery : void 0 !== a ? a.jQuery : null)
			}).call(this)
		}).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
	}, {
		"@babel/runtime/helpers/interopRequireDefault": 2
	}]
}, {}, [1]);
//# sourceMappingURL=script.js.map
