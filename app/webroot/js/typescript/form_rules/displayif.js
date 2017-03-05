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
    function display_if_equals(base_name, rule_element_name, value, options) {
        this.base = $(':input[name="' + base_name + '"]');
        this.rule_element = $(':input[name="' + rule_element_name + '"]');
        this.value = value;
        this.options = JSON.parse(options);
        if (!this.options)
            this.options = { transition: 'default', duration: 400 };
        if (!this.options.transition)
            this.options.transition = 'default';
        if (!this.options.duration)
            this.options.duration = 400;
        this.rule_element.change(this.process.bind(this));
        if (!this.is_visible())
            this.base.parents('.form-group').hide();
    }
    display_if_equals.prototype.is_visible = function () {
        return this.rule_element.val() == this.value;
    };
    display_if_equals.prototype.process = function (event) {
        if (this.is_visible()) {
            this.show_element(this.base.parents('.form-group'));
        }
        else {
            this.hide_element(this.base.parents('.form-group'));
        }
    };
    display_if_equals.prototype.show_element = function (element) {
        switch (this.options.transition) {
            case 'slide_up':
                element.slideUp(this.options.duration);
                break;
            case 'slide_down':
                element.slideDown(this.options.duration);
                break;
            case 'fade':
                element.fadeIn(this.options.duration);
                break;
            case 'default':
                element.show();
                break;
            default:
                alert('default show');
        }
    };
    display_if_equals.prototype.hide_element = function (element) {
        switch (this.options.transition) {
            case 'slide_up':
                element.slideDown(this.options.duration);
                break;
            case 'slide_down':
                element.slideUp(this.options.duration);
                break;
            case 'fade':
                element.fadeOut(this.options.duration);
                break;
            case 'default':
                element.hide();
                break;
            default:
                alert('default hide');
        }
    };
    return display_if_equals;
}());
var display_if_checked = (function (_super) {
    __extends(display_if_checked, _super);
    function display_if_checked(base_name, rule_element_name, data, options) {
        if (data === void 0) { data = null; }
        return _super.call(this, base_name, rule_element_name, '1', options) || this;
    }
    display_if_checked.prototype.is_visible = function () {
        return this.rule_element.is(':checked');
    };
    return display_if_checked;
}(display_if_equals));
var display_if_not_equals = (function (_super) {
    __extends(display_if_not_equals, _super);
    function display_if_not_equals() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    display_if_not_equals.prototype.is_visible = function () {
        return typeof this.rule_element.val() !== 'undefined' && this.rule_element.val() == this.value;
    };
    return display_if_not_equals;
}(display_if_equals));
