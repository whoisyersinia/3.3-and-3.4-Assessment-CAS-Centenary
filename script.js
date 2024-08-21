let nav = document.querySelector("nav");
let nav_button = document.getElementById("nav_button");

if (nav_button != null) {
  nav_button.onclick = function (e) {
    if (e.target.id !== "nav_button") {
      nav.classList.add("bg-dark", "shadow");
    } else {
      nav.classList.remove("bg-dark", "shadow");
    }
  };
} else {
  nav_button = null;
}

let btn_login = document.getElementById("btn_login");

if (btn_login != null) {
  btn_login = document.getElementById("btn_login");
  btn_login.addEventListener("click", function () {
    document.location.href = "login.php";
  });
} else {
  btn_login = null;
}
let btn_register = document.getElementById("btn_register");

if (btn_register != null) {
  btn_register = document.getElementById("btn_register");
  btn_register.addEventListener("click", function () {
    document.location.href = "register.php";
  });
} else {
  btn_register = null;
}

let btn_logout = document.getElementById("btn_logout");

if (btn_logout != null) {
  btn_logout = document.getElementById("btn_logout");
  btn_logout.addEventListener("click", function () {
    document.location.href = "logout.php";
  });
} else {
  btn_logout = null;
}

setTimeout(function () {
  bootstrap.Alert.getOrCreateInstance(document.querySelector(".alert")).close();
}, 3000);

var items = document.querySelectorAll(".code"),
  lastTabIndex = 4,
  backSpaceCode = 8;
items.forEach(function (item) {
  item.addEventListener("focus", function (e) {
    e.target.value = "";
  });
  item.addEventListener("keydown", function (e) {
    let keyCode = e.keyCode,
      currentTabIndex = e.target.tabIndex;
    if (keyCode !== backSpaceCode && currentTabIndex !== lastTabIndex) {
      document.querySelectorAll(".code").forEach(function (inpt) {
        if (inpt.tabIndex === currentTabIndex + 1) {
          setTimeout(function () {
            inpt.focus();
          }, 100);
        }
      });
    }
  });
});

window.onload = function () {
  var oneMinute = 59,
    display = document.querySelector("#time");

  if (display != null) {
    function startTimer(duration, display) {
      var timer = duration,
        seconds;
      setInterval(function () {
        seconds = parseInt(timer % 60, 10);

        seconds = seconds < 10 ? +seconds : seconds;

        display.textContent = seconds;

        if (--timer < 0) {
          timer = duration;
        }
      }, 1000);
    }
    startTimer(oneMinute, display);
  } else {
    display = null;
  }
};

let sign_up_button = document.getElementById("sign_up");

if (sign_up_button != null) {
  sign_up_button.addEventListener("mouseover", function () {
    sign_up_button.classList.add("btn-transparent");
    sign_up_button.classList.remove("btn-primary");
  });

  sign_up_button.addEventListener("mouseout", function () {
    sign_up_button.classList.add("btn-primary");
    sign_up_button.classList.remove("btn-transparent");
  });
}

if (nav != null) {
  window.addEventListener("scroll", function () {
    if (window.scrollY > 100) {
      nav.classList.add("bg-primary", "shadow");
    } else {
      nav.classList.remove("bg-dark", "shadow");
    }
  });
} else {
  nav = null;
}

$(document).ready(function () {
  $(".minus").click(function () {
    var $input = $(this).parent().find("input");
    var count = parseInt($input.val()) - 1;
    count = count < 1 ? 1 : count;
    $input.val(count);
    $input.change();
    return false;
  });
  $(".plus").click(function () {
    var $input = $(this).parent().find("input");
    $input.val(parseInt($input.val()) + 1);
    $input.change();
    return false;
  });
});

// trigger when form is submitted
// runs the form without it reloading using ajax, when success shows modal if not prints console.log error (for development)
$(document).ready(function () {
  $("#shop_form").on("submit", function (e) {
    let qty = document.getElementById("qty").value;
    let cart_total_qty = document.getElementById("cart_total");
    e.preventDefault();
    $.ajax({
      type: $(this).attr("method"),
      url: $(this).attr("action") + "&qty=" + qty,
      data: $(this).serialize(),
      success: function () {
        let currentTotal = parseInt(cart_total_qty.textContent);
        let currentQty = parseInt(qty);

        cart_total_qty.textContent = currentTotal + currentQty;
        console.log(cart_total_qty.innerHTML);
        $("#cartModal").modal("show");
        console.log("success");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      },
    });
  });

  if (window.location.pathname.endsWith("cart.php")) {
    $("input[name='quantity']").change(function () {
      var newQuantity = $(this).val();
      var productId = $(this).data("product-id");
      $.ajax({
        url: "updatecart.php",
        type: "post",
        data: { quantity: newQuantity, product_id: productId },
        success: function (response) {
          location.reload(); // Reload the page to get the updated cart
        },
      });
    });
  }
});
