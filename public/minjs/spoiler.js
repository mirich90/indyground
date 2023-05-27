$for(".spoiler", (e) => {
  $click(e, (event) => {
    console.log(event.target.tagName);
    if (event.target.tagName !== "A") {
      $classToggle(e, "spoiler-show");
    }
  });
});
