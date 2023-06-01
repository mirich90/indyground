$click(".create-card", (e) => {
  new CardGenerator();
});

class CardGenerator {
  constructor() {
    // this.generatorDiv = $create();
    this.modal = $(".modal-wrapper");
    this.modalContent = $(".modal-content");

    this.setModalTitle();
    this.setModalContent();
    this.openModal();
    // modal.append(qrcodeDiv);
  }

  setModalTitle() {
    $(".modal-title").innerText = "Создать карточку";
  }
  setModalContent() {
    $(".modal-content").innerHTML = `
    <div class="input__wrapper">
      <label class="label">Заголовок (необязательно)</label>
      <input id="generator-title" class="input" type="text" placeholder="Введите название карточки" value="">
    </div>
    <div class="input__wrapper">
      <label class="label">Текст</label>
      <input id="generator-text" class="input" type="text" placeholder="Введите текст карточки" value="">
    </div>
    `;
  }
  openModal() {
    $classAdd($(".modal-wrapper"), "open");
  }
}
