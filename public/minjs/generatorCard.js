$click(".create-card", (e) => {
  new CardGenerator();
});

class CardGenerator {
  constructor() {
    this.modal = $id("card-generator");
    this.title = $id("generator-title");
    this.text = $id("generator-text");
    this.saveImg = $id("card-generator-save");
    this.preview = $id("card-generator-preview-card");
    this.titlePreview = $id("card-generator-preview-title");
    this.textPreview = $id("card-generator-preview-text");
    this.modalContent = $("#card-generator-content");

    this.addEventChange();
    this.openModal();
  }

  openModal() {
    $classAdd(this.modal, "open");
  }

  addEventChange() {
    $change(this.title, () => {
      this.titlePreview.innerText = this.title.value;
    });
    $keyup(this.title, () => {
      this.titlePreview.innerText = this.title.value;
    });
    $change(this.text, () => {
      this.textPreview.innerText = this.text.value;
    });
    $keyup(this.text, () => {
      this.textPreview.innerText = this.text.value;
    });
    $click(this.saveImg, () => {
      html2canvas(this.preview).then((canvas) => {
        document.body.appendChild(canvas);
      });
    });
  }
}
