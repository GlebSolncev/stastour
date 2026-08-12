(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_module_tour-checkout_js"],{

/***/ "./resources/js/ajax.js":
/*!******************************!*\
  !*** ./resources/js/ajax.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   AjaxProcessor: () => (/* binding */ AjaxProcessor),
/* harmony export */   extract: () => (/* binding */ extract),
/* harmony export */   route: () => (/* binding */ route)
/* harmony export */ });
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var AjaxProcessor = /*#__PURE__*/function () {
  function AjaxProcessor(url, data, method) {
    _classCallCheck(this, AjaxProcessor);
    this.url = url;
    this.data = data;
    this.method = method;
  }
  return _createClass(AjaxProcessor, [{
    key: "buildFormData",
    value: function buildFormData(formData, data, parentKey) {
      var _this = this;
      if (data && _typeof(data) === 'object' && !(data instanceof Date) && !(data instanceof File) && !(data instanceof Blob)) {
        Object.keys(data).forEach(function (key) {
          _this.buildFormData(formData, data[key], parentKey ? "".concat(parentKey, "[").concat(key, "]") : key);
        });
      } else {
        var value = data == null ? '' : data;
        formData.append(parentKey, value);
      }
    }
  }, {
    key: "jsonToFormData",
    value: function jsonToFormData(data) {
      var formData = new FormData();
      this.buildFormData(formData, data);
      return formData;
    }
  }, {
    key: "getFormData",
    value: function getFormData() {
      var formData = this.data;
      console.log(this.data, this.data instanceof FormData);
      if (!(this.data instanceof FormData)) {
        formData = this.jsonToFormData(this.data);
      }
      formData.append('_token', window.csrf_token);
      return formData;
    }
  }, {
    key: "request",
    value: function request() {
      var formData = this.getFormData();
      var url = this.url;
      var data = {
        method: this.method,
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      };
      if (['GET', 'HEAD'].includes(this.method)) {
        var query = new URLSearchParams(formData).toString();
        if (query) {
          url += '?' + query;
        }
      } else {
        data.body = formData;
      }
      return fetch(url, data);
    }
  }, {
    key: "json",
    value: function json() {
      var _this2 = this;
      return new Promise(function (resolve, reject) {
        _this2.request().then( /*#__PURE__*/function () {
          var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(response) {
            var body, answer;
            return _regeneratorRuntime().wrap(function _callee$(_context) {
              while (1) switch (_context.prev = _context.next) {
                case 0:
                  _context.next = 2;
                  return response.text();
                case 2:
                  body = _context.sent;
                  _context.prev = 3;
                  answer = JSON.parse(body);
                  _context.next = 10;
                  break;
                case 7:
                  _context.prev = 7;
                  _context.t0 = _context["catch"](3);
                  throw new Error("Server returned ".concat(response.status, " instead of JSON"));
                case 10:
                  if (response.ok) {
                    _context.next = 12;
                    break;
                  }
                  throw new Error(answer.message || "Request failed with status ".concat(response.status));
                case 12:
                  resolve(answer);
                case 13:
                case "end":
                  return _context.stop();
              }
            }, _callee, null, [[3, 7]]);
          }));
          return function (_x) {
            return _ref.apply(this, arguments);
          };
        }())["catch"](reject);
      });
    }
  }, {
    key: "html",
    value: function html() {
      var _this3 = this;
      return new Promise(function (resolve, reject) {
        _this3.request().then(function (response) {
          return response.text().then(function (answer) {
            resolve(answer);
          });
        })["catch"](reject);
      });
    }
  }]);
}();
var route = function route(endpoint_url, endpoint_attributes) {
  return new Promise(function (resolve, reject) {
    __webpack_require__("./resources/js/ajax lazy recursive ^\\.\\/.*\\.js$")("./" + endpoint_url + ".js").then(function (route) {
      console.log("[route]", route);
      route["default"](endpoint_attributes).then(resolve)["catch"](reject);
    })["catch"](reject);
  });
};
var extract = function extract(element) {
  var route_element = element.closest('[js-api]');
  var js_api_data = element.getAttribute('js-api-data');
  if (js_api_data && route_element) {
    var api_data = JSON.parse(js_api_data);
    var route_url = route_element.getAttribute('js-api');
    return route(route_url, api_data);
  }
  return Promise.reject();
};

/***/ }),

/***/ "./resources/js/lib/datetime.js":
/*!**************************************!*\
  !*** ./resources/js/lib/datetime.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Datetime: () => (/* binding */ Datetime),
/* harmony export */   gmdate: () => (/* binding */ gmdate),
/* harmony export */   strtotime: () => (/* binding */ strtotime)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
var _Datetime;
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
function _classPrivateMethodInitSpec(obj, privateSet) { _checkPrivateRedeclaration(obj, privateSet); privateSet.add(obj); }
function _classPrivateFieldInitSpec(obj, privateMap, value) { _checkPrivateRedeclaration(obj, privateMap); privateMap.set(obj, value); }
function _checkPrivateRedeclaration(obj, privateCollection) { if (privateCollection.has(obj)) { throw new TypeError("Cannot initialize the same private elements twice on an object"); } }
function _classPrivateFieldGet(s, a) { return s.get(_assertClassBrand(s, a)); }
function _classPrivateFieldSet(s, a, r) { return s.set(_assertClassBrand(s, a), r), r; }
function _assertClassBrand(e, t, n) { if ("function" == typeof e ? e === t : e.has(t)) return arguments.length < 3 ? t : n; throw new TypeError("Private element is not present on this object"); }
function strtotime(formatted) {
  var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'DD.MM.YYYY HH:mm:ss';
  return moment(formatted, format).unix();
}
function gmdate(timestamp) {
  var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'DD.MM.YYYY HH:mm:ss';
  return moment.unix(timestamp).format(format);
}
var _dt = /*#__PURE__*/new WeakMap();
var _Datetime_brand = /*#__PURE__*/new WeakSet();
var Datetime = /*#__PURE__*/function () {
  function Datetime(timestamp) {
    var useUtcOffset = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
    _classCallCheck(this, Datetime);
    _classPrivateMethodInitSpec(this, _Datetime_brand);
    _classPrivateFieldInitSpec(this, _dt, void 0);
    _classPrivateFieldSet(_dt, this, moment.unix(timestamp));
    if (useUtcOffset) {
      _classPrivateFieldGet(_dt, this).utcOffset(0);
    }
  }
  return _createClass(Datetime, [{
    key: "addYears",
    value: function addYears() {
      var years = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      return _assertClassBrand(_Datetime_brand, this, _add).call(this, years, 'y');
    }
  }, {
    key: "addMonths",
    value: function addMonths() {
      var months = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      return _assertClassBrand(_Datetime_brand, this, _add).call(this, months, 'M');
    }
  }, {
    key: "addDays",
    value: function addDays() {
      var days = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      return _assertClassBrand(_Datetime_brand, this, _add).call(this, days, 'd');
    }
  }, {
    key: "format",
    value: function format() {
      var _format = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'DD.MM.YYYY HH:mm:ss';
      return _classPrivateFieldGet(_dt, this).format(_format);
    }
  }, {
    key: "timestamp",
    value: function timestamp() {
      return _classPrivateFieldGet(_dt, this).unix();
    }
  }], [{
    key: "parse",
    value: function parse(string) {
      var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'DD.MM.YYYY HH:mm:ss';
      return new Datetime(strtotime(string, format), false);
    }
  }, {
    key: "parseUTC",
    value: function parseUTC(string) {
      var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'DD.MM.YYYY HH:mm:ss';
      return new Datetime(moment(string, format).utc(true).unix(), false);
    }
  }, {
    key: "now",
    value: function now() {
      return new Datetime(moment().unix());
    }
  }]);
}();
_Datetime = Datetime;
function _add(count, mask) {
  return new _Datetime(_classPrivateFieldGet(_dt, this).clone().add(count, mask).unix(), false);
}

/***/ }),

/***/ "./resources/js/module/overlay.js":
/*!****************************************!*\
  !*** ./resources/js/module/overlay.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Overlay: () => (/* binding */ Overlay)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var Overlay = /*#__PURE__*/function () {
  function Overlay() {
    var element = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    _classCallCheck(this, Overlay);
    this.element = element || document.querySelector('.static');
  }
  return _createClass(Overlay, [{
    key: "start",
    value: function start() {
      document.body.classList.add('non-scroll');
      this.element.classList.add('overlay');
    }
  }, {
    key: "stop",
    value: function stop() {
      this.element.classList.remove('overlay');
      document.body.classList.remove('non-scroll');
    }
  }, {
    key: "bound",
    value: function bound(promise) {
      var _this = this;
      this.start();
      promise["finally"](function () {
        _this.stop();
      });
      return promise;
    }
  }]);
}();

/***/ }),

/***/ "./resources/js/module/tour-checkout.js":
/*!**********************************************!*\
  !*** ./resources/js/module/tour-checkout.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   register: () => (/* binding */ register)
/* harmony export */ });
/* harmony import */ var _module_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../module.js */ "./resources/js/module.js");
/* harmony import */ var _ajax_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../ajax.js */ "./resources/js/ajax.js");
/* harmony import */ var _lib_datetime_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../lib/datetime.js */ "./resources/js/lib/datetime.js");
/* harmony import */ var _overlay_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./overlay.js */ "./resources/js/module/overlay.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }




var TourCheckout = /*#__PURE__*/function () {
  function TourCheckout(element) {
    _classCallCheck(this, TourCheckout);
    this.element = element;
    this.init();
    this.events();
  }
  return _createClass(TourCheckout, [{
    key: "init",
    value: function init() {
      var references = (0,_module_js__WEBPACK_IMPORTED_MODULE_0__.refs)(this.element);
      this.tour_price = this.element.dataset.price;
      this.tour_id = this.element.dataset.id;
      this.available_count_element = references.available_count;
      this.available_total_element = references.available_total;
      this.current_tour = references.current_tour;
      this.book_button = references.book;
      this.total_price_element = references.price;
      this.tour_adults = references.tour_adults;
      this.tour_kids = references.tour_kids;
      this.tour_kid_info = references.kid_info;
      this.calendar = references.calendar;
      this.timeslots = references['timeslots'];
      this.overlay = new _overlay_js__WEBPACK_IMPORTED_MODULE_3__.Overlay(this.element);
    }
  }, {
    key: "events",
    value: function events() {
      var _this = this;
      if (!this.current_tour) return;
      this.current_tour.js_controller.element.addEventListener('change', function (e) {
        _this.changeCurrentTour(e.detail.value);
      });
      Array.from([this.tour_adults, this.tour_kids]).forEach(function (input) {
        input.addEventListener('change', function () {
          _this.book_button.setCustomValidity('');
          _this.book_button.reportValidity();
          _this.reCalcTourPrice();
        });
      });
      this.book_button.addEventListener('click', function () {
        _this.book();
      });
      this.calendar.addEventListener('changeMonth', function (e) {
        _this.fetchCalendarMonth(e.detail.month);
      });
      this.calendar.addEventListener('changeDay', function (e) {
        var timeslots = e.detail.timeslots;
        var selectedTimeslot = null;
        if (timeslots) {
          var sortable = Object.entries(timeslots).sort(function (_ref, _ref2) {
            var _ref3 = _slicedToArray(_ref, 2),
              a = _ref3[1];
            var _ref4 = _slicedToArray(_ref2, 2),
              b = _ref4[1];
            return a.sort - b.sort;
          });
          sortable[0][1].selected = true;
          var values = [];
          sortable.forEach(function (_ref5) {
            var _ref6 = _slicedToArray(_ref5, 2),
              timeslotId = _ref6[0],
              timeslot = _ref6[1];
            var value = {
              value: timeslotId,
              label: timeslot.title
            };
            if (timeslot.selected) {
              value.selected = true;
              selectedTimeslot = timeslot;
            }
            values.push(value);
          });
          _this.timeslots.js_controller.update(values);
          _this.onChangeTimeslot();
        }
      });
      this.timeslots.addEventListener('change', function () {
        _this.onChangeTimeslot();
      });
    }
  }, {
    key: "onChangeTimeslot",
    value: function onChangeTimeslot() {
      var timeslots = this.calendar.js_controller.getSelectedDateInfo();
      var id = this.timeslots.js_controller.getValue();
      if (this.available_count_element) {
        this.available_count_element.value = this.available_total_element.value - timeslots[id].booked;
      }
    }
  }, {
    key: "fetchCalendarMonth",
    value: function fetchCalendarMonth(month) {
      var _this2 = this;
      var reset = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      this.overlay.start();
      (0,_ajax_js__WEBPACK_IMPORTED_MODULE_1__.route)('calendar.month.fetch', {
        tour: this.tour_id,
        month: month
      }).then(function (json) {
        if (reset) {
          _this2.calendar.js_controller.reset(json);
        } else {
          _this2.calendar.js_controller.update(json);
        }
        _this2.overlay.stop();
      });
    }
  }, {
    key: "getAdultQuantity",
    value: function getAdultQuantity() {
      return parseInt(this.tour_adults.value);
    }
  }, {
    key: "getKidsQuantity",
    value: function getKidsQuantity() {
      return parseInt(this.tour_kids.value);
    }
  }, {
    key: "reCalcTourPrice",
    value: function reCalcTourPrice() {
      this.total_price_element.innerText = this.tour_price * (this.getAdultQuantity() + this.getKidsQuantity());
    }
  }, {
    key: "changeCurrentTour",
    value: function changeCurrentTour(tour_id) {
      var _this3 = this;
      (0,_ajax_js__WEBPACK_IMPORTED_MODULE_1__.route)('catalog.checkout', tour_id).then(function (response) {
        if (response.done) {
          _this3.apply(response.data);
        }
      });
    }
  }, {
    key: "apply",
    value: function apply(data) {
      this.tour_price = data.price;
      this.tour_id = data.id;
      this.reCalcTourPrice();
      this.fetchCalendarMonth(_lib_datetime_js__WEBPACK_IMPORTED_MODULE_2__.Datetime.now().format('MM'), true);
    }
  }, {
    key: "collectData",
    value: function collectData() {
      return {
        id: this.tour_id,
        qty: {
          adults: this.getAdultQuantity(),
          kids: this.getKidsQuantity()
        },
        info: {
          kids_info: this.tour_kid_info.value
        },
        timeslot: {
          id: this.timeslots.js_controller.getValue(),
          date: this.calendar.js_controller.getSelectedDate()
        }
      };
    }
  }, {
    key: "book",
    value: function book() {
      var _this4 = this;
      var data = this.collectData();
      if (this.available_total_element) {
        var available = this.available_count_element.value;
        var quantity = data.qty.adults + data.qty.kids;
        if (quantity > available) {
          this.book_button.setCustomValidity('Available for selected date: ' + available);
          this.book_button.reportValidity();
          return;
        }
      }
      this.overlay.start();
      (0,_ajax_js__WEBPACK_IMPORTED_MODULE_1__.route)('basket.add.tour', this.collectData()).then(function (response) {
        if (response.done) {
          window.location.href = '/checkout/';
        } else {
          _this4.overlay.stop();
        }
      });
    }
  }]);
}();
function register(element) {
  return new TourCheckout(element);
}

/***/ }),

/***/ "./resources/js/ajax lazy recursive ^\\.\\/.*\\.js$":
/*!***************************************************************!*\
  !*** ./resources/js/ajax/ lazy ^\.\/.*\.js$ namespace object ***!
  \***************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var map = {
	"./basket.add.tour.js": [
		"./resources/js/ajax/basket.add.tour.js",
		"resources_js_ajax_basket_add_tour_js"
	],
	"./blog.page.js": [
		"./resources/js/ajax/blog.page.js",
		"resources_js_ajax_blog_page_js"
	],
	"./calendar.month.fetch.js": [
		"./resources/js/ajax/calendar.month.fetch.js",
		"resources_js_ajax_calendar_month_fetch_js"
	],
	"./catalog.checkout.js": [
		"./resources/js/ajax/catalog.checkout.js",
		"resources_js_ajax_catalog_checkout_js"
	],
	"./catalog.fetch.js": [
		"./resources/js/ajax/catalog.fetch.js",
		"resources_js_ajax_catalog_fetch_js"
	],
	"./catalog.page.js": [
		"./resources/js/ajax/catalog.page.js",
		"resources_js_ajax_catalog_page_js"
	],
	"./checkout.confirm.js": [
		"./resources/js/ajax/checkout.confirm.js",
		"resources_js_ajax_checkout_confirm_js"
	],
	"./discuss.confirm.js": [
		"./resources/js/ajax/discuss.confirm.js",
		"resources_js_ajax_discuss_confirm_js"
	],
	"./language.choose.js": [
		"./resources/js/ajax/language.choose.js",
		"resources_js_ajax_language_choose_js"
	],
	"./modal.create.js": [
		"./resources/js/ajax/modal.create.js",
		"resources_js_ajax_modal_create_js"
	],
	"./payment.process.js": [
		"./resources/js/ajax/payment.process.js",
		"resources_js_ajax_payment_process_js"
	]
};
function webpackAsyncContext(req) {
	if(!__webpack_require__.o(map, req)) {
		return Promise.resolve().then(() => {
			var e = new Error("Cannot find module '" + req + "'");
			e.code = 'MODULE_NOT_FOUND';
			throw e;
		});
	}

	var ids = map[req], id = ids[0];
	return __webpack_require__.e(ids[1]).then(() => {
		return __webpack_require__(id);
	});
}
webpackAsyncContext.keys = () => (Object.keys(map));
webpackAsyncContext.id = "./resources/js/ajax lazy recursive ^\\.\\/.*\\.js$";
module.exports = webpackAsyncContext;

/***/ })

}]);