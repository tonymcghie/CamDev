/// <reference path="../definitions/jquery/jquery.d.ts" />
interface validator{
    name: string;
    data?: Array<string>;
    validate(): boolean;
}

class requires implements validator{
    name: string;
    input: JQuery;

    constructor(name: string){
        this.name = name;
        this.input = $(':input[name="'+this.name+'"]');
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
    name: string;
    input: JQuery;
    max: number = null;
    min: number = null;

    constructor(name: string, args: string){
        this.name = name;
        this.input = $(':input[name="'+this.name+'"]');
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
