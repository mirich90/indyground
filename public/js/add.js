// универсальная функция - постаивть лайк, добавить в закладки

$for(".action", (e) => {
  $click(e, (event) => {
    let id = e.dataset.id;
    let table = e.dataset.table;
    let action = e.dataset.action;
    add(e, id, table, action);
  });
});

async function add(el, id, table = "articles", action = "likes", v = 0) {
  let h = new Headers();
  let fd = new FormData();

  fd.append("article_id", id);
  fd.append("name_table", table);
  fd.append("action", action);
  fd.append("v", v);

  let req = new Request(`/article/?id=${id}`, {
    method: "POST",
    cache: "no-cache",
    body: fd,
  });

  await fetch(req)
    .then((res) => res.json())
    // .then((res) => res.text())
    .then((commit) => {
      // console.log("commit:", commit);
      if (commit.user == 0) {
        document.location.href = "/login";
      } else {
        if (action == "raitings") {
          changeStateRaitingAfterAdd(commit, el, id);
        } else {
          changeStateIconAfterAdd(commit, el);
        }
      }
    })
    .catch((err) => {
      console.log("ERROR:", err.message);
    });

  function changeStateIconAfterAdd(commit, el) {
    if (commit.state == 1) el.classList.remove("noactive");
    else el.classList.add("noactive");
    el.firstElementChild.innerText = commit.count;
  }

  function changeStateRaitingAfterAdd(commit, el, id) {
    Array.from(el.parentElement.children).forEach((e, i) => {
      if (i < commit.state) e.classList.remove("noactive");
      else e.classList.add("noactive");
    });

    document.querySelector(`.raiting_${id}`).innerText = commit.state;
    document.querySelector(
      `.raiting_count_${id}`
    ).innerText = `(${commit.count} РѕС†РµРЅРѕРє, РјРѕСЏ ${commit.my})`;
  }
}
