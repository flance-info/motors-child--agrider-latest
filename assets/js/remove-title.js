jQuery(document).ready(function($) {
  $('.stm-description-price, .price-description-single').contents().filter(function() {
    return this.nodeType === 3;
  }).each(function() {
    this.textContent = this.textContent.replace('+ ÁFA', '- tól');
  });
});
