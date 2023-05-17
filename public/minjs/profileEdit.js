$click(".profile_edit_btn", (event) => {
  $(".info_edit").classList.toggle("hidden");
  console.log($(".info_edit"));
});

$for(".profile-edit", (e) => {
  $click(e, (event) => {
    let id = e.dataset.id;
    let value = $id(id).value;
    console.log(id, value);
    profileEdit(e, id, value);
  });
});

async function profileEdit(el, field, value) {
  let h = new Headers();
  let fd = new FormData();

  fd.append("field", field);
  fd.append(field, value);
  fd.append("action", "profileEdit");

  let req = new Request(`/profile/`, {
    method: "POST",
    cache: "no-cache",
    body: fd,
  });

  await fetch(req)
    .then((res) => res.json())
    .then((commit) => {
      console.log("commit:", commit);
      if (commit.status == 200) {
        $(".modal-content").innerText = commit.message;
        $classToggle($(".modal-wrapper"), "open");
        $(`.card__profile_${commit.data.field}`).innerText = commit.data.value;
      } else {
        $(".modal-content").innerText = commit.message;
        $classToggle($(".modal-wrapper"), "open");
        $classAdd($(".modal-head"), "modal-error");
        console.log("ERROR:", commit.message);
      }
    })
    .catch((err) => {
      console.log("ERROR:", err.message);
    });
}
