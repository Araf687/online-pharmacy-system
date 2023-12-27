
// Function to load all products
function loadAllProducts(shopId) {
  $.ajax({
    url: "php_backend/shop/get_products.php",
    type: "POST",
    data:{shopId:shopId},
    success: function (response) {
      console.log(response)
      $("#product_list").html(response);
    },
  });
}

//   Get products based on category selection
function selectCategory(shopId,category_id, sub_category_id) {
  console.log(shopId, category_id, sub_category_id)
    $.ajax({
      url: "php_backend/shop/get_products.php",
      type: "POST",
      data: { shopId:shopId,category_id: category_id, sub_category_id: sub_category_id },
      success: function (response) {
          $("#product_list").html(response);
        console.log(response);
      },
    });
    //     }
  }
  
$(document).ready(function () {
  // Change the '+' and '-' signs on collapse/expand
  document.querySelectorAll(".sidebar .collapse").forEach((collapseElement) => {
    collapseElement.addEventListener("show.bs.collapse", function () {
      const parentAnchor = this.previousElementSibling;
      parentAnchor.querySelector("span").textContent = "-";
    });
    collapseElement.addEventListener("hide.bs.collapse", function () {
      const parentAnchor = this.previousElementSibling;
      parentAnchor.querySelector("span").textContent = "+";
    });
  });

  // Load categories
  $.ajax({
    url: "php_backend/shop/get_categories.php",
    type: "POST",
    data: { shopId: shopId },
    success: function (response) {
    
      $("#category_list").html(response);
    },
  });






});

// Function to add to cart
function addToCart(productId, productPrice, userId, pharmacyId) {
  var quantity = parseInt($("#quantity_" + productId).val());
  // Perform action to add product with productId and quantity to cart
  // For example, use AJAX to send this data to the server (e.g., PHP endpoint)
  // $.post('add_to_cart.php', { productId: productId, quantity: quantity }, function(data) {
  //     // Handle response from server (e.g., success message)
  // });
  var dataToSend = {
    id: productId,
    qty: quantity,
    price: productPrice,
    pharmacy_id: pharmacyId,
  };
  if (userId) {
    $.ajax({
      type: "POST",
      url: "php_backend/addToCart/add_to_cart.php", // Replace with your backend PHP file
      data: dataToSend,
      success: function (response) {
        console.log(response);
        // Handle the response from the server
        const res = JSON.parse(response);

        if (res.type == "add") {
          //update cart
          var currentValue = parseInt($("#cart").text());
          var incrementedValue = currentValue + 1;
          $("#cart").text(incrementedValue);

          const inputId = "#quantity_" + productId;
          $(inputId).val(1);
          Swal.fire({
            title: "Good job!",
            text: "Aded Cart Item Successfully",
            icon: "success",
          });
        } else {
          const inputId = "#quantity_" + productId;
          $(inputId).val(1);
          Swal.fire({
            title: "Good job!",
            text: "Upodated Cart Item Successfully",
            icon: "success",
          });
        }
        // Example: Display a success message to the user
        // alert('Data sent successfully to backend');
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText); // Log any errors to the console
        // Example: Display an error message to the user
        alert("Error sending data to backend");
      },
    });
  } else {
    console.log("asd");
    document.getElementById("loginPageLink").click();
  }

  // alert('Added ' + quantity + ' items of product with ID ' + productId + ' to cart');
}
