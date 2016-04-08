/**
 * Created by boshurik on 13.04.16.
 */
$(document).ready(function(){
    $('.js-pagination-items-per-page').change(function(event){
        var $this = $(this);
        var url = $this.data('url');
        var items = $(this).val();

        window.location.href = url.replace('_items_', items);
    });
});