"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_module_overlay_js"],{

/***/ "./resources/js/module/overlay.js":
/*!****************************************!*\
  !*** ./resources/js/module/overlay.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

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

/***/ })

}]);