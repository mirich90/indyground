$click("#popup-article-info-save", add);

async function add() {
  let fd = new FormData();

  let title = $id("popup-article-info-title").value;
  let description = $id("popup-article-info-description").value;
  let img = $("#popup-article-info-img-input").files[0];
  let category = $id("popup-article-info-category").value;
  let content = localStorage.getItem("post");
  let tags = getTags();

  fd.append("title", title);
  fd.append("description", description);
  fd.append("category", category);
  fd.append("keywords", tags);
  fd.append("content", content);
  fd.append("img", img);

  let req = new Request(`/createPost`, {
    method: "POST",
    cache: "no-cache",
    body: fd,
  });

  await fetch(req)
    // .then((res) => res.json())
    .then((res) => res.text())
    .then((commit) => {
      console.log("commit:", commit);
      setMessage(commit);
    })
    .catch((err) => {
      console.log("ERROR:", err.message);
    });
}

function setMessage(commit) {
  $(".alert").innerHTML = commit[1];
  if (commit[0] === "error") {
    $classDel(".alert", "status-success");
    $classAdd(".alert", "status-error");
  } else {
    $classDel(".alert", "status-error");
    $classAdd(".alert", "status-success");
  }
}

function getTags() {
  let tags = [];
  $for($$("#popup-article-info-badges > span"), (e) => tags.push(e.innerHTML));
  return tags;
}
