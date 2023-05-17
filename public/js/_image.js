$onload(document, () => {
  $id("imageUpload").addEventListener("change", function () {
    if (this.files && this.files[0]) {
      let reader = new FileReader();
      reader.onload = function (evt) {
        let image = $id("imagePreview");
        // image.alt = "";
        image.style.backgroundImage = `url(${evt.target.result})`;
      };
      reader.readAsDataURL(this.files[0]);
    }
  });

  $id("imageHeight").addEventListener("click", function () {
    let h = $(".image-preview").clientHeight + 20;
    // console.log($(".image-preview").clientHeight);
    $(".image-preview").style.height = h + "px";
  });
});
