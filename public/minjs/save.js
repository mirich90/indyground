$onload(document, () => {
  $for(".no-enter", (e) => {
    e.addEventListener("keydown", (event) => {
      if (event.code == "Enter") {
        event.preventDefault();
      }
    });
  });

  $for(".popup", (e) => {
    e.addEventListener("keydown", (event) => {
      // console.log(event.code);
      if (event.code == "Escape") {
        event.preventDefault();
        e.style.display = "none";
        editor.$setFocus();
      }
    });
  });

  $for(".cancel", (e) => {
    e.addEventListener("click", (event) => {
      $for(".popup", (e) => {
        e.style.display = "none";
      });
      event.preventDefault();
      editor.$setFocus();
    });
  });

  $for(".badge", (badge) => {
    badge.addEventListener("click", (e) => e.target.remove());
  });

  document.addEventListener("click", (event) => {
    if (event.target.classList.contains("popup")) {
      $for(".popup", (e) => {
        e.style.display = "none";
      });
    }
  });

  $id("popup-article-info-input").addEventListener("click", (event) => {
    editor.$imgShow("popup-article-info-img");
    $id("popup-article-info-delete").style.display = "block";
  });

  $id("popup-article-info-delete").addEventListener("click", (event) => {
    $id("popup-article-info-img").removeAttribute("src");
    $id("popup-article-info-img").setAttribute("alt", "");
    event.target.style.display = "none";
  });

  function getTags() {
    let tags = [];
    $for($$("#popup-article-info-badges > span"), (e) =>
      tags.push(e.innerHTML)
    );
    return tags;
  }

  $id("popup-article-info-save")?.addEventListener("click", () => {
    saveInBd();
  });

  $id("popup-article-info-edit")?.addEventListener("click", (e) => {
    const dataset = e.target.dataset;
    saveInBd(dataset.id, dataset.src);
  });

  async function saveInBd(id = null, src = null) {
    let title = $id("popup-article-info-title").value;
    let description = $id("popup-article-info-description").value;
    let img = $id("popup-article-info-img").getAttribute("src");
    let category = $id("popup-article-info-category").value;
    let content = localStorage.getItem("posts");
    let tags = getTags();
    let message = this.$(`.alert`);

    if (!validate(title, description, category, tags, img)) return;

    img = img ? img.replace("/img/load/", "") : "";

    let fd = new FormData();
    fd.append("title", title);
    fd.append("description", description);
    fd.append("content", content);
    fd.append("category", category);
    fd.append("keywords", tags);
    fd.append("img", img);
    if (id) {
      fd.append("editArticle", id);
      fd.append("src", src);
    } else {
      fd.append("creatArticle", "");
    }

    let req = new Request("/createPost", {
      method: "POST",
      cache: "no-cache",
      body: fd,
    });

    await fetch(req)
      // .then((res) => res.text())
      .then((res) => res.json())
      .then((commit) => {
        // console.log(commit);
        if (commit["status"] === "success") {
          message.innerHTML = commit.text;
          // setTimeout(() => (message.innerHTML = ""), 1500);
        } else {
          message.innerHTML = "ошибка:" + commit.text;
          // setTimeout(() => (message.innerHTML = ""), 1500);
        }
      })
      .catch((err) => {
        console.log("ERROR:", err.message);
        message.innerHTML = "ошибка:" + err.message;
        // setTimeout(() => (message.innerHTML = ""), 5500);
      });

    function validate() {
      // console.log(title, description, category, tags, img);
      if (title === "") {
        alert("Введите название статьи");
        return false;
      }
      if (description === "") {
        alert("Введите описание");
        return false;
      }
      if (category === "") {
        alert("Выберите категорию");
        return false;
      }
      if (tags.length === 0) {
        alert("Введите тэги");
        return false;
      }
      return true;
    }
  }
  function textToFile(text, name) {
    const b = new Blob([text], { type: "text/plain" });
    const url = window.URL.createObjectURL(b);
    const a = document.createElement("a");
    a.href = url;
    a.download = "F:\\code\\my_project\\JS\\editor\\" + name || "text.json";
    a.type = "text/json";
    a.addEventListener("click", () => {
      setTimeout(() => window.URL.revokeObjectURL(url), 10000);
    });
    a.click();
  }

  $id("popup-article-info-tags").addEventListener("keydown", (event) => {
    if (event.code == "Space") {
      event.preventDefault();
    } else if (event.code == "Enter") {
      let tag = $id("popup-article-info-tags");
      if (tag.value === "") return console.log("Введите название тега");
      if (getTags().includes(tag.value))
        return console.log("Этот тег уже есть");
      let badges = $id("popup-article-info-badges");
      let newEl = document.createElement("span");
      let colors = ["blue", "violet", "lagoon", "green"];
      let random = Math.floor(4 + Math.random() * (0 + 1 - 4));
      let color = colors[random];

      newEl.classList.add("badge", "status-" + color);
      newEl.innerText = tag.value.trim();
      tag.value = "";
      $click(newEl, (e) => {
        e.target.remove();
      });

      badges.append(newEl);
    }
  });
});
