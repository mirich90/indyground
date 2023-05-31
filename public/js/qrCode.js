const qrcodeBtn = $("#qrcode-btn");
$click(qrcodeBtn, (e) => {
  const modal = $(".modal-content");
  const link = qrcodeBtn.dataset.qrcode;
  const qrcodeDiv = document.createElement("div");
  qrcodeDiv.id = "qrcode";
  $(".modal-title").innerText = "QR-код статьи";
  modal.innerText = "Перейти на страницу статьи с помощью этого qr-кода";
  modal.append(qrcodeDiv);
  const qrcode = new QRCode("qrcode");
  qrcode.clear();
  qrcode.makeCode(link);
  $classToggle($(".modal-wrapper"), "open");
});
