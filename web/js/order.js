$(() => {
  $("#application-course_id").on("change", function () {
    if ($(this).val() == "3") {
      $(".alert-order").removeClass("d-none");
    } else {
      $(".alert-order").addClass("d-none");
    }
  });
});
