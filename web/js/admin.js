$(() => {
  const renderToast = (toast) => {
    const container = $(".toast-container");
    const el_toast = $(`<div class="toast" data-bs-delay="3000">
      <div class="toast-header bg-${toast.status}">        
        <strong class="me-auto bg-${toast.status}-head">Смена статуса заказа</strong>        
      </div>
      <div class="toast-body bg-${toast.status}-toast">
        ${toast.text}
      </div>
    </div>`);
    container.append(el_toast);
    el_toast.toast("show");

    setTimeout(() => {
      el_toast.fadeOut(1000);
      setTimeout(() => el_toast.remove(), 2000);
    }, 2000);
  };

  const getFlash = () => {
    $.ajax({
      url: "/site/get-flash",
      success(data) {
        if (data) {
          renderToast(data);
        }
      },
    });
  };

  $("#admin-pjax").on("pjax:end", () => {
    getFlash();
  });
});
