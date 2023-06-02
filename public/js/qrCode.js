$click("#qrcode-btn", (e) => {
  const qrcodeWrapper = $id("qrcode-wrapper");
  const qrcodeDiv = $id("qrcode");
  const link = qrcodeWrapper.dataset.qrcode;

  qrcodeDiv.innerHTML = "";
  const qrcode = new QRCode("qrcode");
  qrcode.clear();
  qrcode.makeCode(link);
  $classToggle(qrcodeWrapper, "open");
});
