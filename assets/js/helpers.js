jQuery(document).ready(function() {
  jQuery(document).ajaxComplete(function() {
    jQuery('.stm-ajax-row').removeClass('stm-loading');
  });
});