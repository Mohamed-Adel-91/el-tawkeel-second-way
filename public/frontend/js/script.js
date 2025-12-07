$(".form_group_control").on("focus blur input", function () {
  if (
    $(this).hasClass("valid") ||
    $(this).val().trim() !== "" ||
    $(this).is(":focus")
  ) {
    $(this).siblings(".form_group_label").addClass("top");
  } else {
    $(this).siblings(".form_group_label").removeClass("top");
  }
});


$("input[name='dealing_type']").on("change", function () {
  let formType = $(this).closest("label").data("form");
  // Show only the selected one
  $("." + formType).fadeIn().siblings(".mainForm").hide();
});

$(".profileTab").click(function () {
  $(this).addClass("active").siblings().removeClass("active")
  let dataContent = $(this).data("tab");
  // Show only the selected one
  $("." + dataContent).fadeIn().siblings(".tab-content").hide();
})

$(".request").click(function () {
  let dataContent = $(this).data("tab");
  // Show only the selected one
  $("." + dataContent).fadeIn().siblings(".tab-content").hide();
})

// تعديل البيانات
$(document).on("click", ".profile_edit", function () {
  let container = $(this).closest(".field");
  let target = container.find(".edit");
  let currentValue = target.text().trim();
  let inputType = container.data("type") || "text"; // النوع الافتراضي text

  if (target.find("input, textarea").length) return;

  let input;
  if (inputType === "textarea") {
    input = $("<textarea>", {
      class: "border px-2 py-1 rounded w-full",
      text: currentValue
    });
  } else {
    input = $("<input>", {
      type: inputType,
      value: currentValue,
      class: "border px-2 py-1 rounded w-full"
    });
  }

  target.html(input);
  input.focus();

  input.on("blur", function () {
    let newValue = $(this).val().trim();
    target.text(newValue);
    // هنا ممكن تضيف حفظ بالـ AJAX لو عايز
  });
});

// حفظ البيانات
$(document).on("click", ".save-btn", function () {
  var input = $(this).siblings(".edit-input");
  var newValue = input.val();
  var field = input.closest("div").find(".edit-input").data("field");
  input.replaceWith('<span class="editable" data-field="' + field + '">' + newValue + '</span>');
  $(this).text("تعديل").removeClass("save-btn").addClass("profile_edit");
});

$('input[type="file"]').on('change', function () {
  const files = Array.from(this.files).map(f => f.name).join(', ');
  $(this).closest('label').find('.inputValue')
    .text(files || 'برجاء تحميل او إدراج ملفك هنا!');
});
$(".serviceCenter_brands_brand").click(function () {
  $(this).addClass("active").siblings().removeClass("active")
})

$(".custAccordion h2 button").click(function (e) {
  e.preventDefault();

  var content = $(this).closest("h2").next("div");
  var img = $(this).find("img");

  $(".custAccordion div[id^='accordion-collapse-body']").addClass("hidden");
  $(".custAccordion h2 button img").attr("src", "img/faq/plus.svg");

  if (content.hasClass("hidden")) {
    content.removeClass("hidden");
    img.attr("src", "img/faq/minus.svg");
  }
});

// Sidebar functionality
function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const overlay = document.querySelector('.sidebar-overlay');
  if (sidebar && overlay) {
    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
  }
}

// ✅ Initialize Swiper FIRST

// Sidebar overlay click handler
const sidebarOverlay = document.querySelector('.sidebar-overlay');
if (sidebarOverlay) {
  sidebarOverlay.addEventListener('click', () => {
    document.querySelector('.sidebar')?.classList.remove('open');
    sidebarOverlay.classList.remove('open');
  });
}

// Highlight active links
const bottomBarBoxes = document.querySelectorAll('.bottom-bar-box');
const sidebarLinks = document.querySelectorAll('.sidebar-a');
const currentPath = window.location.pathname;

bottomBarBoxes.forEach(box => {
  const link = box.querySelector('a');
  if (link && link.getAttribute('href') === currentPath) {
    box.classList.add('active');
  }
});

sidebarLinks.forEach(link => {
  if (link.getAttribute('href') === currentPath) {
    link.classList.add('text-red-600', 'font-bold');
  }
});


// Initialize WOW.js if available
if (typeof WOW !== 'undefined') {
  new WOW().init();
}



$("#togglePassword").on("click", function () {
  let isPassword = $("#passwordInput").attr("type") === "password";
  $("#passwordInput").attr("type", isPassword ? "text" : "password");
});

// change paragraph of tawkeel.com to be link and redirect to the home page
var paragraph = $(".getHtml p");

if (paragraph.text().includes("tawkeel.com")) {
  window.location.href = "https://tawkeel.com";
}
$("#visa").prop("checked", true);

// change image when hover 


// loading button
$(".btn").click(function () {
  $(this).addClass('loading').removeClass('btn');
});
setTimeout(function () {
  $('.loading').removeClass('loading').addClass('btn')
}, 3000);

// show more button
$(".showMore").click(function () {
  $(this).parent("ul").toggleClass('showAll');

  if ($(this).text().trim() === "المزيد") {
    $(this).text("إخفاء")
  } else {
    $(this).text("المزيد")

  }

});
