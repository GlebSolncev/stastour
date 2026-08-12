"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_module_calendar_js"],{

/***/ "./resources/js/lib/datetime.js":
/*!**************************************!*\
  !*** ./resources/js/lib/datetime.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

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

/***/ "./resources/js/lib/string.js":
/*!************************************!*\
  !*** ./resources/js/lib/string.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   String: () => (/* binding */ _String)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var _String = /*#__PURE__*/function () {
  function String() {
    _classCallCheck(this, String);
  }
  return _createClass(String, null, [{
    key: "random",
    value: function random() {
      var length = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 10;
      var prefix = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
      var chars = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var result = '';
      var charactersLength = chars.length;
      var counter = 0;
      while (counter < length) {
        result += chars.charAt(Math.floor(Math.random() * charactersLength));
        counter += 1;
      }
      return prefix + result;
    }
  }]);
}();


/***/ }),

/***/ "./resources/js/module/calendar.js":
/*!*****************************************!*\
  !*** ./resources/js/module/calendar.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   register: () => (/* binding */ register)
/* harmony export */ });
/* harmony import */ var _lib_string_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../lib/string.js */ "./resources/js/lib/string.js");
/* harmony import */ var _lib_datetime_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../lib/datetime.js */ "./resources/js/lib/datetime.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }


var Calendar = /*#__PURE__*/function () {
  function Calendar(element) {
    _classCallCheck(this, Calendar);
    _defineProperty(this, "calendarData", []);
    _defineProperty(this, "tourId", 0);
    this.element = element;
    this.tourId = this.element.dataset.id;
    this.start();
  }
  return _createClass(Calendar, [{
    key: "getDisabledMonthDays",
    value: function getDisabledMonthDays() {
      var days = Object.keys(this.month);
      var daysLocated = days.map(function (day) {
        return _lib_datetime_js__WEBPACK_IMPORTED_MODULE_1__.Datetime.parse(new _lib_datetime_js__WEBPACK_IMPORTED_MODULE_1__.Datetime(day).format()).timestamp();
      });
      var result = [];
      var firstDayInMonth = _lib_datetime_js__WEBPACK_IMPORTED_MODULE_1__.Datetime.parse(new _lib_datetime_js__WEBPACK_IMPORTED_MODULE_1__.Datetime(days[0]).format('YYYY-MM') + '-01', 'YYYY-MM-DD');
      var iterate = firstDayInMonth;
      var month = firstDayInMonth.format('MM');
      while (iterate.format('MM') === month) {
        if (!daysLocated.includes(iterate.timestamp())) {
          result.push(iterate.format('YYYY-MM-DD'));
        }
        iterate = iterate.addDays();
      }
      return result;
    }
  }, {
    key: "start",
    value: function () {
      var _start = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var _this = this;
        var now, month, min;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              now = new Date(); // const year = now.getFullYear();
              month = now.getMonth() + 1; //.padStart(2, '0');
              this.refreshCalendarData(month);
              // const response = await fetch('/api/show-calendar/' + this.element.dataset.id + '/' + month);
              // this.calendarData = await response.json()

              this.month = JSON.parse(this.element.dataset.calendar);
              min = new _lib_datetime_js__WEBPACK_IMPORTED_MODULE_1__.Datetime(this.element.dataset.min);
              this.calendar = new VanillaCalendar(this.element, {
                type: 'default',
                date: {
                  min: min.format('YYYY-MM-DD'),
                  max: min.addMonths(6).format('YYYY-MM-DD')
                },
                settings: {
                  selection: {
                    cancelableDay: false
                  },
                  selected: {
                    dates: [min.format('YYYY-MM-DD')]
                  },
                  visibility: {
                    weekNumbers: true
                  },
                  range: {
                    disabled: this.getDisabledMonthDays()
                  },
                  lang: 'define'
                },
                locale: {
                  months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                  weekday: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa']
                },
                actions: {
                  clickMonth: function clickMonth() {
                    _this.changeMonth();
                  },
                  clickArrow: function clickArrow() {
                    _this.changeMonth();
                  },
                  clickDay: function clickDay(event, self) {
                    if (self.selectedDates.length > 0) {
                      var selectedDate = self.selectedDates[0];

                      // Получаем данные для этого дня из сохраненных данных (this.month или из data-calendar)
                      // Нам нужно перевести YYYY-MM-DD в таймстамп миллисекунд, как у вас в структуре
                      var dayTimestamp = _lib_datetime_js__WEBPACK_IMPORTED_MODULE_1__.Datetime.parseUTC(selectedDate, 'YYYY-MM-DD').timestamp() * 1000;
                      var dayData = self.month && self.month[dayTimestamp];

                      // Создаем кастомное событие и передаем туда все данные дня
                      var changeEvent = new CustomEvent('calendar:change', {
                        detail: {
                          date: selectedDate,
                          timestamp: dayTimestamp,
                          info: dayData // Тут будет ваша цена, слоты и т.д.
                        },
                        bubbles: true // Позволяет событию подниматься выше по DOM
                      });

                      // Генерируем событие на корневом элементе календаря
                      self.HTMLElement.dispatchEvent(changeEvent);
                    }
                    _this.changeDay();
                  },
                  // ✅ ИСПРАВЛЕННЫЙ ХУК ОТРЕСОВКИ ЦЕНЫ
                  getDays: function getDays(day, date, HTMLElement) {
                    // Переводим дату дня (YYYY-MM-DD) в UTC Timestamp (в секундах)
                    var dayTimestamp = _lib_datetime_js__WEBPACK_IMPORTED_MODULE_1__.Datetime.parseUTC(date, 'YYYY-MM-DD').timestamp();
                    var dayData = _this.month[dayTimestamp];
                    var data = _this.calendarData[dayTimestamp * 1000];
                    // const pricing = this.element.dataset.pricing;
                    var pricing = _this.element.dataset.pricing ? JSON.parse(_this.element.dataset.pricing) : {};
                    var totalPrice = 0;
                    var selected = Object.keys(pricing);
                    if (data && data.length > 0) {
                      var _iterator = _createForOfIteratorHelper(data[0].pricesByRate),
                        _step;
                      try {
                        var _loop = function _loop() {
                          var item = _step.value;
                          var itemTotal = 0;
                          if (!selected.length) {
                            totalPrice = item.amount.amount;
                            return 1; // break
                          }
                          selected.forEach(function (rateId) {
                            if (item.id === parseInt(rateId)) {
                              itemTotal += item.amount.amount * (pricing[rateId] || 1);
                            }
                          });
                          totalPrice += itemTotal;
                        };
                        for (_iterator.s(); !(_step = _iterator.n()).done;) {
                          if (_loop()) break;
                        }
                      } catch (err) {
                        _iterator.e(err);
                      } finally {
                        _iterator.f();
                      }
                      var minPrice = parseFloat(totalPrice);

                      // Находим внутреннюю кнопку дня
                      var btn = HTMLElement.querySelector('.vanilla-calendar-day__btn');
                      if (btn) {
                        btn.removeAttribute('disabled');
                        btn.classList.remove('vanilla-calendar-day__btn_disabled');

                        // Удаляем старый спан с ценой, если он был (чтобы избежать дублирования при перерисовке)
                        var oldPrice = btn.querySelector('.calendar-day-price');
                        if (oldPrice) oldPrice.remove();

                        // let priceElement = btn.querySelector('.calendar-day-price');
                        // if (!priceElement) {
                        // priceElement = document.createElement('span');
                        // priceElement.className = 'calendar-day-price';
                        // btn.appendChild(priceElement);
                        // }
                        // Выводим цену
                        // priceElement.textContent = `${minPrice}€`;
                      } else {
                        // Если цены нет — жестко деактивируем кнопку дня
                        btn.setAttribute('disabled', 'disabled');
                        btn.classList.add('vanilla-calendar-day__btn_disabled');

                        // На всякий случай очищаем блок от старых цен
                        var _oldPrice = btn.querySelector('.calendar-day-price');
                        if (_oldPrice) _oldPrice.remove();
                      }
                    }

                    // Проверяем, что для этого дня есть данные и в них задана цена
                    // if (dayData && dayData.price !== undefined) {
                    //     const minPrice = parseFloat(dayData.price);
                    //
                    //     if (!isNaN(minPrice)) {
                    //         // Находим внутреннюю кнопку дня
                    //         const btn = HTMLElement.querySelector('.vanilla-calendar-day__btn');
                    //
                    //         if (btn) {
                    //             // Создаем или обновляем элемент цены
                    //             let priceElement = btn.querySelector('.calendar-day-price');
                    //             if (!priceElement) {
                    //                 priceElement = document.createElement('span');
                    //                 priceElement.className = 'calendar-day-price';
                    //                 btn.appendChild(priceElement);
                    //             }
                    //             // Выводим цену
                    //             priceElement.textContent = `${minPrice}€`;
                    //         }
                    //     }
                    // }
                  }
                }
              });
              this.calendar.init();
            case 7:
            case "end":
              return _context.stop();
          }
        }, _callee, this);
      }));
      function start() {
        return _start.apply(this, arguments);
      }
      return start;
    }()
  }, {
    key: "refreshCalendarData",
    value: function refreshCalendarData() {
      var _this2 = this;
      var month = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      var calendarEl = this.element;
      if (!calendarEl) return;
      if (!month) {
        var now = new Date();
        month = now.getMonth() + 1;
      }
      calendarEl.style.opacity = '0.5'; // Визуальный индикатор загрузки

      fetch("/api/show-calendar/".concat(this.tourId, "/").concat(month)).then(function (response) {
        return response.json();
      }).then(function (newData) {
        calendarEl.setAttribute('data-calendar', JSON.stringify(newData));
        _this2.month = newData;
        if (_this2.calendarData) {
          _this2.calendarData = newData;
        }
        if (_this2.calendar && typeof _this2.calendar.update === 'function') {
          _this2.calendar.update();
        } else if (_this2.calendar) {
          _this2.calendar.init();
        }
        calendarEl.style.opacity = '1';
      })["catch"](function (error) {
        console.error('Ошибка при обновлении цен календаря:', error);
        calendarEl.style.opacity = '1';
      });
    }
  }, {
    key: "changeDay",
    value: function changeDay() {
      var day = this.getSelectedDate();
      var dayTimestamp = _lib_datetime_js__WEBPACK_IMPORTED_MODULE_1__.Datetime.parseUTC(day, 'YYYY-MM-DD').timestamp();
      this.element.dispatchEvent(new CustomEvent('changeDay', {
        detail: {
          timeslots: this.month[dayTimestamp]
        }
      }));
    }
  }, {
    key: "changeMonth",
    value: function changeMonth() {
      var month = this.calendar.selectedMonth + 1;
      refreshCalendarData(month);
      this.element.dispatchEvent(new CustomEvent('changeMonth', {
        detail: {
          month: month
        }
      }));
    }
  }, {
    key: "update",
    value: function update(month) {
      var selected = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      this.month = month;
      this.calendar.settings.range.disabled = this.getDisabledMonthDays();
      if (selected) {
        this.calendar.settings.selected.dates = selected;
      }
      this.calendar.update({
        dates: true
      });
    }
  }, {
    key: "reset",
    value: function reset(month) {
      this.update(month, [new _lib_datetime_js__WEBPACK_IMPORTED_MODULE_1__.Datetime(Object.keys(month)[0]).format('YYYY-MM-DD')]);
      this.changeDay();
    }
  }, {
    key: "getSelectedDate",
    value: function getSelectedDate() {
      return this.calendar.selectedDates[0];
    }
  }, {
    key: "getSelectedDateInfo",
    value: function getSelectedDateInfo() {
      var day = this.getSelectedDate();
      var dayTimestamp = _lib_datetime_js__WEBPACK_IMPORTED_MODULE_1__.Datetime.parseUTC(day, 'YYYY-MM-DD').timestamp();
      return this.month[dayTimestamp];
    }
  }]);
}();
function register(element) {
  if (window.VanillaCalendar) {
    return new Calendar(element);
  } else {
    console.warn('No VanillaCalendar vendor js library! ignored');
  }
}

/***/ })

}]);