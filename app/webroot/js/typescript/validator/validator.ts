/// <reference path="../definitions/jquery/jquery.d.ts" />
interface validator{
    input: JQuery;
    data?: Array<string>;
    validate(): boolean;
}

class requires implements validator{
    input: JQuery;

    constructor(name: string){
        this.input = $(':input[name="'+name+'"]');
    }

    validate(): boolean{
        if (this.input.val().length !== 0){
            return true;
        } else {
            this.input.parent('div').prepend('<span class="alert-danger">This field is required</span>');
            return false;
        }
    }
}

class number_validator implements validator{
    input: JQuery;
    max: number = null;
    min: number = null;

    constructor(name: string, args: string){
        this.input = $(':input[name="'+name+'"]');
        this.min = Number(this.input.attr('min'));
        this.max = Number(this.input.attr('max'));
    }

    validate(): boolean {
        let value = this.input.val();
        if (!isNaN(value) && Number(value) > this.min && Number(value) > this.max){ // TODO make this work with elements that do not have a max and min attribute
            return true;
        } else {
            this.input.parent('div').prepend('<span class="alert-danger">This field needs to be a number</span>');
            return false;
        }
    }
}

class match_validator implements validator{
    input: JQuery;
    data: Array<string>;

    constructor(name: string, args: string){
        args = JSON.parse(args);
        this.data = args['data'];
        this.input = $(':input[name="'+name+'"]');
    }

    validate(): boolean {
        console.log(this.data);
        for(var index in this.data){
            console.log(this.data[index] + ' : ' + this.input.val());
            if (this.data[index] == this.input.val())return true;
        }
        this.input.parents('div.form-group').prepend('<span class="alert-danger">This input did not match the possible values</span>');
        return false;
    }
}
