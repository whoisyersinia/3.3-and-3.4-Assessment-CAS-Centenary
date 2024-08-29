function reveal() {
  var reveals = document.querySelectorAll(".reveal");

  for (var i = 0; i < reveals.length; i++) {
    var windowHeight = window.innerHeight;
    var elementTop = reveals[i].getBoundingClientRect().top;
    var elementVisible = 30;

    if (elementTop < windowHeight - elementVisible) {
      reveals[i].classList.add("active");
    } else {
      reveals[i].classList.remove("active");
    }
  }
}

function reveal_once() {
  var reveals = document.querySelectorAll(".reveal_once");

  for (var i = 0; i < reveals.length; i++) {
    var windowHeight = window.innerHeight;
    var elementTop = reveals[i].getBoundingClientRect().top;
    var elementVisible = 100;

    if (elementTop < windowHeight - elementVisible) {
      reveals[i].classList.add("active");
    }
  }
}

window.addEventListener("scroll", reveal);
window.addEventListener("scroll", reveal_once);

let nav = document.querySelector("nav");
let nav_button = document.getElementById("nav_button");

if (nav_button != null) {
  nav_button.onclick = function (e) {
    if (e.target.id !== "nav_button") {
      nav.classList.add("bg-light", "shadow");
    } else {
      nav.classList.remove("bg-light", "shadow");
    }
  };
} else {
  nav_button = null;
}

if (nav != null) {
  window.addEventListener("scroll", function () {
    if (window.scrollY > 10) {
      nav.classList.add("bg-light", "shadow");
    } else {
      nav.classList.remove("bg-light", "shadow");
    }
  });
} else {
  nav = null;
}

let nav_light = document.querySelector("nav_light");
let nav_button_light = document.getElementById("nav_button_light");

if (nav_button_light != null) {
  nav_button_light.onclick = function (e) {
    if (e.target.id !== "nav_button_light") {
      nav_light.classList.add("bg-primary", "shadow");
    } else {
      nav_light.classList.remove("bg-primary", "shadow");
    }
  };
} else {
  nav_button_light = null;
}

if (nav_light != null) {
  window.addEventListener("scroll", function () {
    if (window.scrollY > 100) {
      nav_light.classList.add("bg-primary", "shadow");
    } else {
      nav_light.classList.remove("bg-primary", "shadow");
    }
  });
} else {
  nav_light = null;
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
  $("#checkout").on("submit", function () {
    $("#loadingModal").modal("show");
    $.ajax({
      type: $(this).attr("method"),
      url: $(this).attr("action"),
      data: $(this).serialize(),

      success: function () {
        $("#loadingModal").modal("hide");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      },
    });
  });

  $("#rsvp").on("submit", function () {
    $("#loadingModal").modal("show");
    $.ajax({
      type: $(this).attr("method"),
      url: $(this).attr("action"),
      data: $(this).serialize(),

      success: function () {
        $("#loadingModal").modal("hide");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      },
    });
  });

  $("#register").on("submit", function () {
    $("#loadingModal").modal("show");
    $.ajax({
      type: $(this).attr("method"),
      url: $(this).attr("action"),
      data: $(this).serialize(),

      success: function () {
        $("#loadingModal").modal("hide");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      },
    });
  });

  $("#shop_form").on("submit", function (e) {
    let qty = document.getElementById("qty").value;
    let cart_total_qty = document.getElementById("cart_total");
    let lim = parseInt(document.getElementById("lim").value);

    if (
      parseInt(document.getElementById("curr_qty").value) + parseInt(qty) >
      lim
    ) {
      $("#warningModal").modal("show");
      return false;
    } else {
      e.preventDefault();

      $.ajax({
        type: $(this).attr("method"),
        url: $(this).attr("action") + "&qty=" + qty,
        data: $(this).serialize(),
        success: function () {
          let currentTotal = parseInt(cart_total_qty.textContent);
          let currentQty = parseInt(qty);

          document.getElementById("curr_qty").value =
            parseInt(document.getElementById("curr_qty").value) + currentQty;
          cart_total_qty.textContent = currentTotal + currentQty;

          $("#cartModal").modal("show");
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        },
      });
    }
  });

  // update cart item quantity in real time using ajax
  if (window.location.pathname.endsWith("cart.php")) {
    $("input[name='quantity']").change(function () {
      let newQuantity = $(this).val();
      let productId = $(this).data("product-id");
      let limit = $(this).data("limit");
      console.log(limit);

      if (parseInt(newQuantity) > parseInt(limit)) {
        $("#warningModal").modal("show");
        this.value = limit;
        return false;
      } else {
        $.ajax({
          url: "updatecart.php",
          type: "post",
          data: { quantity: newQuantity, product_id: productId },
          success: function () {
            location.reload(); // Reload the page to get the updated cart
          },
        });
      }
    });
  }
});

// Restricts input for the given textbox to the given inputFilter function.
function setInputFilter(textbox, inputFilter, errMsg) {
  [
    "input",
    "keydown",
    "keyup",
    "mousedown",
    "mouseup",
    "select",
    "contextmenu",
    "drop",
    "focusout",
  ].forEach(function (event) {
    textbox.addEventListener(event, function (e) {
      if (inputFilter(this.value)) {
        // Accepted value.
        if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
          this.classList.remove("input-error");
          this.setCustomValidity("");
        }

        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        // Rejected value: restore the previous one.
        this.classList.add("input-error");
        this.setCustomValidity(errMsg);
        this.reportValidity();
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        // Rejected value: nothing to restore.
        this.value = "";
      }
    });
  });
}

setInputFilter(
  document.getElementById("qty"),
  function (value) {
    return /^(\s*|\d+)$/.test(value); // Allow digits only.
  },
  "Only digits allowed"
);
