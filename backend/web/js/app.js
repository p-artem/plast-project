$(function() {
    "use strict";

    //Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

    $('.auto-checkbox-tree').bonsai({
        expandAll: true,
        checkboxes: true, // depends on jquery.qubit plugin
        createInputs: 'checkbox' // takes values from data-name and data-value, and data-name is inherited
    });

    $('.auto-radio-tree').bonsai({
        expandAll: true,
        createInputs: 'radio'
    });

    $('.add-phone-btn').click(function(){
        $(this).before('<div class="add-phones-group form-group"><input name="add_phones[]" type="text">&nbsp;' +
            '<button type="button" class="del-phone-btn btn">Удалить</button></div>');
        $('.del-phone-btn').click(function(){
            $(this).parent().remove();
        });
    });

    $('.del-phone-btn').click(function(){
        $(this).parent().find('input[type=text]').val('');
        $(this).parent().hide();
    });

});