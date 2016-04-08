/**
 * Created by boshurik on 01.03.16.
 */
$(document).ready(function(){
    $('.js-datepicker').datetimepicker({
        format: 'DD.MM.YYYY',
        allowInputToggle: false,
        useCurrent: false
    });

    $('.js-datetimepicker').datetimepicker({
        format: 'DD.MM.YYYY HH:mm:ss',
        allowInputToggle: false,
        useCurrent: false
    });
});