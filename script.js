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
