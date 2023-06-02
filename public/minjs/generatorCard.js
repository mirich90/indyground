$click(".create-card", (e) => {
  new CardGenerator();
});

class CardGenerator {
  constructor() {
    this.modal = $("#card-generator");
    this.modalContent = $("#card-generator-content");

    this.openModal();
  }
  openModal() {
    $classAdd(this.modal, "open");
  }
}
