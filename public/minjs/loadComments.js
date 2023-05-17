$click("#createComment", (event) => {
  let el = event.target;
  let id = el.dataset.id;
  create_comment(id);
});

$for(".load-comments-btn", (e) => {
  $click(e, (event) => {
    let id = e.dataset.id;
    let table = e.dataset.table;
    let sort = e.dataset.sort;
    loadComments(id, sort, table);
  });
});

async function loadComments(id, sort = "new", table = "article") {
  let h = new Headers();
  let fd = new FormData();

  fd.append("article_id", id);
  fd.append("loadComments", "loadComments");
  fd.append("sort", sort);

  let req = new Request(`/${table}/?id=${id}`, {
    method: "POST",
    cache: "no-cache",
    body: fd,
  });

  await fetch(req)
    .then((res) => res.json())
    // .then((res) => res.text())
    .then((commit) => {
      addClassActive(sort);
      renderComments(commit[1]);
    })
    .catch((err) => {
      console.log("ERROR:", err.message);
    });
}

async function addClassActive(sort) {
  let sortElements = document.querySelectorAll(".load-comments li");
  let sortElement = document.querySelector(".load-comments-" + sort);
  sortElements.forEach((e) => e.classList.remove("active"));
  sortElement.classList.add("active");
}

async function create_comment(id) {
  let text = $id("textComment").value;
  let h = new Headers();
  let fd = new FormData();

  fd.append("createComment", "createComment");
  fd.append("text", text.trim());

  let req = new Request(`/article/?id=${id}`, {
    method: "POST",
    cache: "no-cache",
    body: fd,
  });

  await fetch(req)
    .then((res) => res.json())
    // .then((res) => res.text())
    .then((commit) => {
      // console.log(commit);
      if (commit[0] === "error") {
        renderError(commit[1]);
      } else {
        document.querySelector("#textComment").value = "";
        clearAlert();
        clearAlert("error");
        renderSuccess(commit[1]);
        addClassActive("new");
        renderComments(commit[2]);
      }
    });
}

function renderError(commit) {
  clearAlert();
  clearAlert("error");
  let divError = document.querySelector(".status-error");
  divError.classList.remove("hidden");
  divError.innerHTML = commit;
}

function renderSuccess(commit) {
  clearAlert();
  clearAlert("error");
  let divSuccess = document.querySelector(".status-success");
  divSuccess.classList.remove("hidden");
  divSuccess.innerHTML = commit;
}

function clearAlert(status = "success") {
  let div = document.querySelector(".status-" + status);
  div.classList.add("hidden");
  div.innerHTML = "";
}

function renderComments(commit) {
  document.querySelector("#comments button").classList.add("hidden");
  let commentsArray = JSON.parse(commit);
  let comments = "";
  commentsArray.forEach((comment) => {
    // console.log(comment);
    let ava = comment.ava ? `avatars/${comment.ava}` : "static/ava.png";
    let is_like = comment.is_like ? "" : "noactive";
    let is_bookmark = comment.is_bookmark ? "" : "noactive";
    comments += `
        <section class="comment">
          <a href="/profile/?id=zxc" class="article-author">
            <picture>
              <img src="/img/${ava}" alt="${comment.username}">
            </picture>
            ${comment.username}
          </a>
          
          <p>${comment.text}</p>
          
          <section class="comment-info">
            <time datetime=">${comment.datetime}" class="article-date">${comment.datetime}</time>
  
            <div class="comment-action">
              <div class="icon action ${is_like}" data-id="${comment.id}" data-table="comments" data-action="likes">
                <p> ${comment.sum_likes} </p>
                <i class="material-icons"> favorite </i>
              </div>
        
              <div class="icon action ${is_bookmark}" data-id="${comment.id}" data-table="comments" data-action="bookmarks">
                <p> ${comment.sum_bookmarks} </p>
                <i class="material-icons"> bookmark </i>
              </div>
        
              <div class="nav-item menu">
                <a class="icon action noactive y-dropdown-toggle">
                  <i class="material-icons"> menu </i>
                </a>
                <ul class="nav-dropdown y-dropdown-menu" style="display: none;">
                  <li><a href="index.php?complain=1&amp;id=2">Пожаловаться</a></li>
                </ul>
              </div>
            </div>
  
          </section>
          <hr/>
      </section>`;
  });
  document.querySelector(".comments").innerHTML = comments;
  document.querySelector(".comments").style.textAlign = "left";
  document.querySelector(".comments-header").classList.remove("hidden");

  $for(".action", (e) => {
    $click(e, (event) => {
      let id = e.dataset.id;
      let table = e.dataset.table;
      let action = e.dataset.action;
      add(e, id, table, action);
    });
  });
}
