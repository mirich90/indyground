$for(".modal-btn-close", (e) => {
  $click(e, (event) => {
    $classDel(e.parentElement.parentElement.parentElement, "open");
  });
});
