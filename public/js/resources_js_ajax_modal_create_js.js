"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_ajax_modal_create_js"],{

/***/ "./resources/js/ajax/modal.create.js":
/*!*******************************************!*\
  !*** ./resources/js/ajax/modal.create.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ajax_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../ajax.js */ "./resources/js/ajax.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function (_ref) {
  var code = _ref.code,
    data = _ref.data;
  return new Promise(function (resolve, reject) {
    new _ajax_js__WEBPACK_IMPORTED_MODULE_0__.AjaxProcessor("/api/modal/create/".concat(code, "/"), data, 'POST').html().then(function (response) {
      resolve(response);
    })["catch"](function (error) {
      reject(error);
    });
  });
});

/***/ })

}]);