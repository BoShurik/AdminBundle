/**
 * Created by boshurik on 25.02.16.
 */
$(document).ready(function(){
    $('.js-delete').click(function(event){
        if (!confirm('Are you sure?')) {
            event.stopPropagation();
            event.preventDefault();
        }
    });
});