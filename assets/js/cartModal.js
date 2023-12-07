const clickEditCartItem = (cartId) => {
  console.log("cartsd id", cartId, document.getElementById(`plus_${cartId}`));
  document.getElementById(`plus_${cartId}`).style.display = "block";
  document.getElementById(`minus_${cartId}`).style.display = "block";
  document.getElementById(`actionOpt_${cartId}`).style.display = "none";
  document.getElementById(`back_${cartId}`).style.display = "block";
};
const clickDeleteCartItem = (cartId) => {
  console.log("cart id", cartId);
};

const cancelUpdateCartItem = (cartId, prevQty) => {
  var input = document.getElementById(`qty_${cartId}`);
  input.value = prevQty;
  document.getElementById(`actionOpt_${cartId}`).style.display = "block";
  document.getElementById(`back_${cartId}`).style.display = "none";
};

const updateCartItem = (cartId, prevQty) => {
  var input = document.getElementById(`qty_${cartId}`);

  if (input.value != prevQty  && input!=0) {
    const dataToSend = { cartId: cartId, qty: input.value };
    $.ajax({
      type: "POST",
      url: "php_backend/updateCartItem/updateCartItem.php", // Replace with your backend PHP file
      data: dataToSend,
      success: function (response) {
        console.log(response);
        // Handle the response from the server
        const res = JSON.parse(response);

        if (res.isSuccess) {
            Swal.fire({
                title: "Good job!",
                text: "You clicked the button!",
                icon: "success"
              });
          document.getElementById(`actionOpt_${cartId}`).style.display =
            "block";
          document.getElementById(`back_${cartId}`).style.display = "none";

        } else {
          console.log("failed to updat cart item");
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText); // Log any errors to the console
        // Example: Display an error message to the user
        alert("Error sending data to backend");
      },
    });
  }
  else if(input==0){

  }
};
