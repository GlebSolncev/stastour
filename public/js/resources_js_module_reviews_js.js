"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_module_reviews_js"],{

/***/ "./resources/js/module/reviews.js":
/*!****************************************!*\
  !*** ./resources/js/module/reviews.js ***!
  \****************************************/
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

var Reviews = /*#__PURE__*/function () {
  function Reviews(element) {
    _classCallCheck(this, Reviews);
    this.element = element;
    this.start();

    //this.calculate_dots();
    this.events();
  }
  return _createClass(Reviews, [{
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
            slidesPerView: 2,
            slidesPerGroup: 2,
            spaceBetween: 60
          }
        }
      });
    }
  }, {
    key: "events",
    value: function events() {
      var _this = this;
      var ref = (0,_module_js__WEBPACK_IMPORTED_MODULE_0__.refs)(this.element);
      ref === null || ref === void 0 || ref.next.addEventListener('click', function (e) {
        _this.swiper.slideNext();
      });
      ref === null || ref === void 0 || ref.prev.addEventListener('click', function (e) {
        _this.swiper.slidePrev();
      });
    }
  }, {
    key: "calculate_dots",
    value: function calculate_dots() {
      var dots = this.element.querySelector('.swiper-pagination');
      var activeSlideIndex = this.swiper.activeIndex;
      var activeSlide = Array.from(this.element.querySelectorAll('.swiper-slide'))[activeSlideIndex];
      var slideHeight = activeSlide.querySelector('.main-slider__background').clientHeight;
      dots.style.top = slideHeight + 'px';
    }
  }]);
}();
function register(element) {
  if (window.Swiper) {
    return new Reviews(element);
  } else {
    console.warn('No Swiper vendor js library! ignored');
  }
}
var PATH = 'reviews';

/***/ })

}]);