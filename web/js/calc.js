$(() => {
  $("#calc").on("click", ".btn-minus", function (e) {
    e.preventDefault();
    const value = parseInt($(".value").html());
    if (value > 0) {
      $(".value").html(value - 1);
    }
  });

  $("#calc").on("click", ".btn-plus", function (e) {
    e.preventDefault();
    const value = parseInt($(".value").html());
    $(".value").html(value + 1);
  });
});
