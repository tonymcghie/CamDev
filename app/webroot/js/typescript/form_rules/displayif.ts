/**
 * Created by mgoo on 5/02/17.
 */
/// <reference path="../definitions/jquery/jquery.d.ts" />
interface display_rule_interface{
    process(event: Event): void;
}

type option_object = {
    transition: string;
    duration: number | string;
}

class display_if_equals implements display_rule_interface{
    base: JQuery;
    rule_element: JQuery;
    value: string;
    options: option_object;

    is_visible(): boolean{
        return this.rule_element.val() == this.value;
    }

    process(event?: Event): void{
        if (this.is_visible()){
            this.show_element(this.base.parents('.form-group'));
        } else {
            this.hide_element(this.base.parents('.form-group'));
        }
    }

    show_element(element: JQuery): void{
        switch(this.options.transition){
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
                alert('default show'); // TODO throw error here
        }
    }

    hide_element(element: JQuery): void{
        switch(this.options.transition){
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
                alert('default hide'); // TODO throw error here
        }
    }

    constructor(base_name: string, rule_element_name: string, value: string, options?: string){
        this.base = $(':input[name="'+base_name+'"]');
        this.rule_element = $(':input[name="'+rule_element_name+'"]');
        this.value = value;
        this.options = JSON.parse(options);
        if (!this.options)this.options = {transition: 'default', duration: 400};
        if (!this.options.transition)this.options.transition = 'default';
        if (!this.options.duration)this.options.duration = 400;
        this.rule_element.change(this.process.bind(this));
        if (!this.is_visible())this.base.parents('.form-group').hide();
    }
}

class display_if_checked extends display_if_equals implements display_rule_interface{
    is_visible(): boolean{
        return this.rule_element.is(':checked');
    }

    constructor(base_name: string, rule_element_name: string, data = null, options?: string){
        super(base_name, rule_element_name, '1', options);
    }
}

class display_if_not_equals extends display_if_equals implements display_rule_interface{
    is_visible(): boolean{
        return typeof this.rule_element.val() !== 'undefined' && this.rule_element.val() == this.value;
    }
}