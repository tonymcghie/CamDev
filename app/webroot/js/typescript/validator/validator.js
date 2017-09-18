/// <reference path="../definitions/jquery/jquery.d.ts" />
var requires = (function () {
    function requires(name) {
        this.input = $(':input[name="' + name + '"]');
    }
    requires.prototype.validate = function () {
        if (this.input.val().length !== 0) {
            return true;
        }
        else {
            this.input.parent('div').prepend('<span class="alert-danger">This field is required</span>');
            return false;
        }
    };
    return requires;
}());
var number_validator = (function () {
    function number_validator(name, args) {
        this.max = null;
        this.min = null;
        this.input = $(':input[name="' + name + '"]');
        this.min = Number(this.input.attr('min'));
        this.max = Number(this.input.attr('max'));
    }
    number_validator.prototype.validate = function () {
        var value = this.input.val();
        if (!isNaN(value) && Number(value) >= this.min && Number(value) <= this.max) {
            return true;
        }
        else {
            this.input.parent('div').prepend('<span class="alert-danger">This field needs to be a number</span>');
            return false;
        }
    };
    return number_validator;
}());
var match_validator = (function () {
    function match_validator(name, args) {
        args = JSON.parse(args);
        this.data = args['data'];
        this.input = $(':input[name="' + name + '"]');
    }
    match_validator.prototype.validate = function () {
        for (var index in this.data) {
            if (this.data[index] == this.input.val())
                return true;
        }
        this.input.parents('div.form-group').prepend('<span class="alert-danger">This input did not match the possible values</span>');
        return false;
    };
    return match_validator;
}());
