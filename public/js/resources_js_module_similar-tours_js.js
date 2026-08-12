"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_module_similar-tours_js"],{

/***/ "./resources/js/module/similar-tours.js":
/*!**********************************************!*\
  !*** ./resources/js/module/similar-tours.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   register: () => (/* binding */ register)
/* harmony export */ });
/* harmony import */ var _module_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../module.js */ "./resources/js/module.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }
function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
function _classPrivateMethodInitSpec(obj, privateSet) { _checkPrivateRedeclaration(obj, privateSet); privateSet.add(obj); }
function _checkPrivateRedeclaration(obj, privateCollection) { if (privateCollection.has(obj)) { throw new TypeError("Cannot initialize the same private elements twice on an object"); } }
function _assertClassBrand(e, t, n) { if ("function" == typeof e ? e === t : e.has(t)) return arguments.length < 3 ? t : n; throw new TypeError("Private element is not present on this object"); }

var _SimilarTours_brand = /*#__PURE__*/new WeakSet();
var SimilarTours = /*#__PURE__*/function () {
  function SimilarTours(element) {
    _classCallCheck(this, SimilarTours);
    _classPrivateMethodInitSpec(this, _SimilarTours_brand);
    this.element = element;
    this.init();
    this.events();
  }
  return _createClass(SimilarTours, [{
    key: "start",
    value: function start() {
      this.swiper = new window.Swiper(this.element, {
        loop: true,
        direction: 'horizontal',
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
        },
        slidesPerView: 1,
        slidesPerGroup: 1,
        breakpoints: {
          1200: {
            disable: true
          }
        }
      });
    }
  }, {
    key: "destroy",
    value: function destroy() {
      this.swiper.destroy();
    }
  }, {
    key: "init",
    value: function init() {
      if (_assertClassBrand(_SimilarTours_brand, this, _getMatchMedia).call(this).matches) {
        this.start();
      }
    }
  }, {
    key: "events",
    value: function events() {
      var _this = this,
        _ref$item,
        _ref$more;
      _assertClassBrand(_SimilarTours_brand, this, _getMatchMedia).call(this).addEventListener('change', function (event) {
        if (event.matches) {
          _this.start();
        } else {
          _this.destroy();
        }
      });
      var ref = (0,_module_js__WEBPACK_IMPORTED_MODULE_0__.refs)(this.element);
      ref === null || ref === void 0 || ref.next.addEventListener('click', function (e) {
        _this.swiper.slideNext();
      });
      ref === null || ref === void 0 || ref.prev.addEventListener('click', function (e) {
        _this.swiper.slidePrev();
      });
      var next_row = 1;
      var max_row = Math.max.apply(Math, _toConsumableArray((ref === null || ref === void 0 || (_ref$item = ref.item) === null || _ref$item === void 0 ? void 0 : _ref$item.map(function (item) {
        return parseInt(item.dataset.row);
      })) || 0));
      ref === null || ref === void 0 || (_ref$more = ref.more) === null || _ref$more === void 0 || _ref$more.addEventListener('click', function (e) {
        e.preventDefault();
        console.log("[more]", next_row, max_row);
        if (next_row <= max_row) {
          var _ref$item2;
          ref === null || ref === void 0 || (_ref$item2 = ref.item) === null || _ref$item2 === void 0 || _ref$item2.filter(function (item) {
            return parseInt(item.dataset.row) === next_row;
          }).forEach(function (item) {
            item.classList.add('is-visible');
          });
          next_row++;
        }
        if (next_row > max_row) {
          ref.more.remove();
        }
      });
    }
  }]);
}();
function _getMatchMedia() {
  return window.matchMedia('(max-width: 1200px)');
}
function register(element) {
  return new SimilarTours(element);
}

/***/ })

}]);