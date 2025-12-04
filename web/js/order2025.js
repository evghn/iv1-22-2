$(() => {
  const clear = () => {
    $("#application-course_id").removeClass("is-invalid");
    $("#application-course_id").removeClass("is-valid");
    $(".field-application-course_id").find(".invalid-feedback").html("");
    $("#application-course_user").removeClass("is-invalid");
    $("#application-course_user").removeClass("is-valid");
    $(".field-application-course_user").find(".invalid-feedback").html("");
    $("#application-course_user").val("");
  };

  $("#application-check").on("click", function () {
    if ($(this).prop("checked")) {
      $(".course_user").removeClass("d-none");
      $("#form-order").yiiActiveForm("remove", "application-course_user"); //id field
      $("#application-course_id option:first").prop("selected", true);
      clear();
      $("#application-course_id").prop("disabled", true);

      $("#form-order").yiiActiveForm("add", {
        id: "application-course_user",
        name: "course_user",
        container: ".field-application-course_user",
        input: "#application-course_user",
        error: ".invalid-feedback",
        validate: function (attribute, value, messages, deferred, $form) {
          yii.validation.required(value, messages, {
            message: "Необходимо заполнить «Course».",
          });
          yii.validation.string(value, messages, {
            message: "Значение «Course» должно быть строкой.",
            max: 255,
            tooLong:
              "Значение «Course» должно содержать максимум 255 символов.",
            skipOnEmpty: 1,
          });
        },
      });
    } else {
      clear();
      $(".course_user").addClass("d-none");
      $("#form-order").yiiActiveForm("remove", "application-course_user");

      $("#application-course_id").prop("disabled", false);
      $("#form-order").yiiActiveForm("add", {
        id: "application-course_id",
        name: "course_id",
        container: ".field-application-course_id",
        input: "#application-course_id",
        error: ".invalid-feedback",
        validate: function (attribute, value, messages, deferred, $form) {
          yii.validation.required(value, messages, {
            message: "Необходимо заполнить «Наименование курса».",
          });
          yii.validation.number(value, messages, {
            pattern: /^[+-]?\d+$/,
            message: "Значение «Наименование курса» должно быть целым числом.",
            skipOnEmpty: 1,
          });
        },
      });
    }
  });
});
