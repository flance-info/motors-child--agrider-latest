jQuery(document).ready(function($) {
  console.log('ready');
  $(document).ajaxComplete(function() {
    console.log('test');
    $('.stm-ajax-row').removeClass('stm-loading');
  });
});
jQuery(document).ready(function($) {
  console.log('test eeee');
  $(document).ajaxSuccess(function() {
    console.log('test');
    $('.stm-ajax-row').removeClass('stm-loading');
  });
});