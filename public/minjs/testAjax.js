// $(".getTitleArticle").addEventListener("click", () => {
//   add();
// });
$click(".getTitleArticle", add);

async function add() {
  let fd = new FormData();
  fd.append("testBd", "1");
  fd.append("testJson", "1");
  let req = new Request(`/index`, {
    method: "POST",
    cache: "no-cache",
    body: fd,
  });
  await fetch(req)
    .then((res) => res.json())
    .then((commit) => {
      // console.log("commit:", commit);
    })
    .catch((err) => {
      console.log("ERROR:", err.message);
    });
}

// // $onload(document, () => {
// $click(".getTitleArticle", add());

// async function add() {
//   // let h = new Headers();
//   let fd = new FormData();

//   fd.append("id", id);
//   fd.append("table", table);
//   fd.append("action", action);
//   fd.append("v", v);

//   let req = new Request(`../classes/LikeClass.php`, {
//     method: "POST",
//     cache: "no-cache",
//     body: fd,
//   });

//   await fetch(req)
//     .then((res) => res.json())
//     .then((commit) => {
//       console.log("commit:", commit);
//       // if (commit.user == 0) {
//       //   document.location.href = "login.php";
//       // } else {
//       // if (action == "raitings") {
//       //   changeStateRaitingAfterAdd(commit, el, id);
//       // } else {
//       //   changeStateIconAfterAdd(commit, el);
//       // }
//       // }
//     })
//     .catch((err) => {
//       console.log("ERROR:", err.message);
//     });

//   // console.log(1);
// }
// // });
