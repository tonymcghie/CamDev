$(function() {
    $('.results-table th').each(function (key, value){
        let temp = $('<a href="#"><span title="hide column" class="btn glyphicon glyphicon-eye-close"></span></a>');
        temp.on('click', function(event){
            toggle_column($('th').index($(event.target).closest('th')));
        });
        $(value).append(temp);
    });
    $('#table-model').modal('show');

    function toggle_column(index){
        let th = $('.results-table tr th:nth-child('+(index+1)+')');
        $('.results-table tr td:nth-child('+(index+1)+')').toggle();
        th.toggle();
        if (!th.is(':visible')){
            let newTag = $('<span class="label label-danger btn" data="'+index+'">' +
                th.text() +
                '<a href="#">' +
                '<span title="Show column" class="glyphicon glyphicon-eye-open"></span>' +
                '</a></span>');
            newTag.on('click', function(event){
                let parentSpan = $(event.target).closest('.label');
                let index = parseInt(parentSpan.attr('data'));
                $('.results-table tr td:nth-child('+(index+1)+'), .results-table tr th:nth-child('+(index+1)+')').toggle();
                parentSpan.remove();
            });
            $('#hidden-columns').append(newTag);
        }
    }

    function open_new_page(url){
        $('#table-model').on('hidden.bs.modal', function(){
            load_page(url, $('#main_content'));
        });
        $('#table-model').modal('hide');
    }
});