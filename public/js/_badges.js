$onload(document, () => {
  $id("tags").addEventListener("keydown", (event) => {
    if (event.code == "Space") {
      event.preventDefault();
    } else if (event.code == "Enter") {
      event.preventDefault();

      let tag = $id("tags");
      if (tag.value === "") return console.log("Введите название тега");
      if (getTags().includes(tag.value))
        return console.log("Этот тег уже есть");
      let badges = $id("list-badges");
      let newBadge = document.createElement("span");
      let colors = ["blue", "violet", "lagoon", "green"];
      let random = Math.floor(4 + Math.random() * (0 + 1 - 4));
      let color = colors[random];

      newBadge.classList.add("badge", "status-" + color);
      newBadge.innerText = tag.value.trim();
      tag.value = "";
      $click(newBadge, (e) => {
        e.target.remove();
      });

      badges.append(newBadge);
    }
  });

  function getTags() {
    let tags = [];
    $for($$("#popup-article-info-badges > span"), (e) =>
      tags.push(e.innerHTML)
    );
    return tags;
  }
});
