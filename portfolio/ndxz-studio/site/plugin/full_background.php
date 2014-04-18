   1. <?php if defined'SITE' exit'No direct script access allowed'
   2. /**
   3. * Backgrounded
   4. *
   5. * Exhbition format
   6. * 
   7. * @version 1.0
   8. * @author Vaska 
   9. */
  10. // defaults from the general libary - be sure these are installed
  11. $exhibit'dyn_css'  dynamicCSS
  12. $exhibit'dyn_js'  dynamicJS
  13. $exhibit'exhibit'  full_background
  14. function full_background
  15. // we'll just get it from the page background image
  16. global $rs
  17. if $rs'bgimg' != '' 
  18. // get the dimensions
  19. $size  getimagesizeDIRNAME  '/files/'  $rs'bgimg'
  20. return "<img src='"  BASEURL  /files/$rsbgimg' width='$size0' height='$size1' />
  21. return
  22. function dynamicCSS
  23.     return "#the-background { position: absolute; z-index: 1; width: 100%; height: 100%; top: 0; left: 0; }"
  24. function dynamicJS
  25.     global $rs
  26.     return "function bg_img_resize() {
  27.         var w = $(window).width();
  28.         var h = $(window).height();
  29.         var iw = $('#the-background img').attr('width');
  30.         var ih = $('#the-background img').attr('height');
  31.         var rw = iw / ih;
  32.         var rh = ih / iw;
  33.         var sc = h * rw;
  34.         if (sc >= w) {
  35.             nh = h;
  36.             nw = sc;
  37.         } else {
  38.             sc = w * rh;
  39.             nh = sc;
  40.             nw = w;
  41.         }
  42.         $('#the-background img').css({height: nh, width: nw});
  43.     }"
  44. ?>
