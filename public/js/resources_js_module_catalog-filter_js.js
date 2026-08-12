"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_module_catalog-filter_js"],{

/***/ "./resources/js/module/catalog-filter.js":
/*!***********************************************!*\
  !*** ./resources/js/module/catalog-filter.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   PATH: () => (/* binding */ PATH),
/* harmony export */   register: () => (/* binding */ register)
/* harmony export */ });
/* harmony import */ var _module_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../module.js */ "./resources/js/module.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
function _classPrivateMethodInitSpec(obj, privateSet) { _checkPrivateRedeclaration(obj, privateSet); privateSet.add(obj); }
function _checkPrivateRedeclaration(obj, privateCollection) { if (privateCollection.has(obj)) { throw new TypeError("Cannot initialize the same private elements twice on an object"); } }
function _assertClassBrand(e, t, n) { if ("function" == typeof e ? e === t : e.has(t)) return arguments.length < 3 ? t : n; throw new TypeError("Private element is not present on this object"); }

var _CatalogFilter_brand = /*#__PURE__*/new WeakSet();
var CatalogFilter = /*#__PURE__*/function () {
  function CatalogFilter(container) {
    _classCallCheck(this, CatalogFilter);
    _classPrivateMethodInitSpec(this, _CatalogFilter_brand);
    var references = (0,_module_js__WEBPACK_IMPORTED_MODULE_0__.refs)(container);
    this.container = container;
    this.filter = references.button || [];
    this.events();
  }
  return _createClass(CatalogFilter, [{
    key: "events",
    value: function events() {
      var _this = this;
      Array.from(this.filter).forEach(function (button) {
        button.addEventListener('click', function (e) {
          e.preventDefault();
          if (button.classList.contains('button--active')) {
            button.classList.remove('button--active');
          } else {
            button.classList.add('button--active');
          }
          _assertClassBrand(_CatalogFilter_brand, _this, _update).call(_this);
        });
      });
    }
  }]);
}();
function _update() {
  var filters = Array.from(this.filter).filter(function (button) {
    return button.classList.contains('button--active');
  }).map(function (button) {
    return button.dataset['code'];
  });
  if (!filters.length) {
    filters = Array.from(this.filter).map(function (button) {
      return button.dataset['code'];
    });
  }
  var catalog = (0,_module_js__WEBPACK_IMPORTED_MODULE_0__.parent)(this.container);
  catalog === null || catalog === void 0 || catalog.applyFilter(filters);
}
function register(element) {
  return new CatalogFilter(element);
}
var PATH = 'catalog-filter';

/***/ })

}]);