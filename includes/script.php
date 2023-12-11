<?php

 include("cart/cartModal.php") 
 
 ?>

<script>
$(document).ready(function () {
  $('.btn-number').click(function (e) {
      console.log("asas")
      e.preventDefault();

      var fieldName = $(this).attr('data-field');
      var type = $(this).attr('data-type');
      var input = $("input[id='" + fieldName + "']");
      var currentVal = parseInt(input.val());
      console.log(currentVal,input,type,fieldName)

      if (!isNaN(currentVal)) {
          if (type === 'minus') {
              if (currentVal > 0) {
                  input.val(currentVal - 1);
              }
          } else if (type === 'plus') {
              input.val(currentVal + 1);
          }
      } else {
          input.val(0);
      }
  });
});

</script>
<!-- jquery link -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
