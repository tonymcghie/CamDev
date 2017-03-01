var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
/// <reference path="../definitions/jquery/jquery.d.ts" />
var display_if_equals = (function () {
    function display_if_equals(base_name, rule_element_name, value) {
        this.base = $(':input[name="' + base_name + '"]');
        this.rule_element = $(':input[name="' + rule_element_name + '"]');
        this.value = value;
        this.rule_element.change(this.process.bind(this));
        this.process(null);
    }
    display_if_equals.prototype.process = function (event) {
        if (this.rule_element.val() == this.value) {
            this.base.parents('.form-group').show();
        }
        else {
            this.base.parents('.form-group').hide();
        }
    };
    return display_if_equals;
}());
var display_if_checked = (function (_super) {
    __extends(display_if_checked, _super);
    function display_if_checked(base_name, rule_element_name) {
        return _super.call(this, base_name, rule_element_name, '1') || this;
    }
    display_if_checked.prototype.process = function (event) {
        if (this.rule_element.is(':checked')) {
            this.base.parents('.form-group').show();
        }
        else {
            this.base.parents('.form-group').hide();
        }
    };
    return display_if_checked;
}(display_if_equals));
var display_if_not_equals = (function (_super) {
    __extends(display_if_not_equals, _super);
    function display_if_not_equals() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    display_if_not_equals.prototype.process = function (event) {
        if (typeof this.rule_element.val() !== 'undefined' && this.rule_element.val() == this.value) {
            this.base.parent('div.form-group').hide();
        }
        else {
            this.base.parent('div.form-group').show();
        }
    };
    return display_if_not_equals;
}(display_if_equals));
