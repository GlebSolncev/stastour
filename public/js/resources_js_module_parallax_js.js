"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_module_parallax_js"],{

/***/ "./resources/js/module/parallax.js":
/*!*****************************************!*\
  !*** ./resources/js/module/parallax.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   PATH: () => (/* binding */ PATH),
/* harmony export */   Parallax: () => (/* binding */ Parallax),
/* harmony export */   register: () => (/* binding */ register)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
var Parallax = /*#__PURE__*/_createClass(function Parallax(element) {
  _classCallCheck(this, Parallax);
  var config = {
    orientation: element.dataset['orientation'] || 'up',
    scale: element.dataset['scale'] || 1.2,
    overflow: element.dataset['overflow'] || false,
    delay: element.dataset['delay'] || 0.4,
    transition: element.dataset['transition'] || 'cubic-bezier(0,0,0,1)',
    customContainer: element.dataset['customContainer'] || '',
    customWrapper: element.dataset['customWrapper'] || '',
    maxTransition: element.dataset['maxTransition'] || 0
  };
  this.parallax = new simpleParallax(element, config);
});
function register(element) {
  if (window.simpleParallax) {
    return new Parallax(element);
  } else {
    console.warn('No simpleParallax vendor js library! ignored');
  }
}
var PATH = 'parallax';

/***/ })

}]);