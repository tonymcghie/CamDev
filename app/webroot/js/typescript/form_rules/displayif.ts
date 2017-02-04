/**
 * Created by mgoo on 5/02/17.
 */
/// <reference path="../definitions/jquery/jquery.d.ts" />
interface display_rule{
    process(event: Event): void;
}

class display_if_equals implements display_rule{
    base: JQuery;
    rule_element: JQuery;
    value: string;
    process(event: Event): void{
        if (this.rule_element.val() == this.value){
            this.base.parents('.form-group').show();
        } else {
            this.base.parents('.form-group').hide();
        }
    }

    constructor(base_name: string, rule_element_name: string, value: string){
        this.base = $(':input[name="'+base_name+'"]');
        this.rule_element = $(':input[name="'+rule_element_name+'"]');
        this.value = value;
        this.rule_element.change(this.process.bind(this));
        this.process(null);

    }
}

class display_if_checked extends display_if_equals implements display_rule{
    process(event: Event): void{
        if (this.rule_element.is(':checked')){
            this.base.parents('.form-group').show();
        } else {
            this.base.parents('.form-group').hide();
        }
    }

    constructor(base_name: string, rule_element_name: string){
        super(base_name, rule_element_name, '1');
    }
}

class display_if_not_equals extends display_if_equals implements display_rule{
    process(event: Event):void {
        if (typeof this.rule_element.val() !== 'undefined' && this.rule_element.val() == this.value){
            this.base.parent('div.form-group').hide();
        } else {
            this.base.parent('div.form-group').show();
        }
    }
}