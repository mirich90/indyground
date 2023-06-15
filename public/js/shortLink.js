$blur($id("shortlink-url"), (event) => {
  const value = event.target.value.trim();

  if (value === "") return;

  if (value.length < 13) {
    $error("Длина ссылки должна быть не менее 13 символов");
  }
  if (!value.startsWith("https://") && !value.startsWith("http://")) {
    $error(
      'Первые символы поля всегда должны начинаться с "https://" или "http://"'
    );
  }
  if (value.indexOf(".") === -1) {
    $error("В URL должна быть хотя бы одна точка");
  }
});

$keydown($id("shortlink-shortcode"), (event) => {
  const regexp = /^[a-zA-Z0-9-]/;
  $classDel($id("shortlink-shortcode"), "error");
  if (!regexp.test(event.key)) {
    event.preventDefault();
  }
});

$blur($id("shortlink-shortcode"), (event) => {
  const el = event.target;
  const value = el.value;
  const regexp = /^[a-zA-Z0-9-][a-zA-Z0-9-]{3,}$/;

  if (value === "") return;

  if (!regexp.test(value)) {
    $error(
      "<p>Длина желаемого короткого адреса от 4 символов включительно. Только английские буквы, цифры и знак '-' (разделитель)</p>"
    );
  }
});

$click($(".shortlink-category-new"), (event) => {
  $classAdd($id("category-new"), "open");
});

$click($(".shortlink-category-create"), async (event) => {
  let h = new Headers();
  let fd = new FormData();

  let name = $id("shortlink-category-name");

  if (name.value === "") {
    $error("Введите назвние категории");
    return;
  }

  fd.append("name", name.value);
  fd.append("add-category", "true");

  let req = new Request(`/shortlinks`, {
    method: "POST",
    cache: "no-cache",
    body: fd,
  });

  await fetch(req)
    .then((res) => res.json())
    .then((commit) => {
      console.log("commit:", commit);
      if (commit.user == 0) {
        document.location.href = "/login";
      } else {
        if (commit.status == "success") {
          name.value = "";
          $message(commit.text);
        } else {
          $error(commit.text);
        }
      }
    })
    .catch((err) => {
      console.log("ERROR:", err.message);
    });
});

$click($(".shortlink-shortcode-btn"), async (event) => {
  let h = new Headers();
  let fd = new FormData();

  let shortcode = $id("shortlink-shortcode");

  if (shortcode.value === "") {
    $error("Заполните короткий адрес или оставьте его пустым");
    return;
  }

  fd.append("check", shortcode.value);

  let req = new Request(`/shortlinks`, {
    method: "POST",
    cache: "no-cache",
    body: fd,
  });

  await fetch(req)
    .then((res) => res.json())
    .then((commit) => {
      console.log("commit:", +commit.data === 0);
      if (commit.user == 0) {
        document.location.href = "/login";
      } else {
        if (+commit.data === 0) {
          $classDel(shortcode, "error");
          $message("Введенный короткий адрес свободен");
        } else {
          $classAdd(shortcode, "error");
          $error("Введенный короткий адрес уже существует. Придумайте другой");
        }
      }
    })
    .catch((err) => {
      console.log("ERROR:", err.message);
    });
});

$click($id("shortlink-save"), async (event) => {
  let h = new Headers();
  let fd = new FormData();

  let title = $id("shortlink-title");
  let url = $id("shortlink-url");
  let shortcode = $id("shortlink-shortcode");
  let category = $id("shortlink-category");

  if (title.value === "" || url.value === "") {
    $error("Поля 'Название ссылки' и 'Ссылка' не должны быть пустыми");
    return;
  }

  fd.append("title", title.value);
  fd.append("url", url.value);
  fd.append("shortcode", shortcode.value);
  fd.append("category", category.value);
  fd.append("add", "true");

  let req = new Request(`/shortlinks`, {
    method: "POST",
    cache: "no-cache",
    body: fd,
  });

  await fetch(req)
    .then((res) => res.json())
    .then((commit) => {
      console.log("commit:", commit);
      if (commit.user == 0) {
        document.location.href = "/login";
      } else {
        if (commit.status == "success") {
          const data_url = commit.data.url;
          const id = commit.data.id;
          const html = `
          <div>
            <p>Создана короткая ссылка <a href='${data_url}'>${data_url}</a></p>
            <br>
            <p>QR-код для этой ссылки:</p>
            <div id='qrcode'></div>
            <br>
            <p>Все созданные вами ссылки можно посмотреть или исправить на <a href='/shortlinks?id=${id}'>этой странице</a></p>
          </div>
          `;
          $setContentMessage(html);

          const qrcode = new QRCode("qrcode");
          qrcode.clear();
          qrcode.makeCode(data_url);

          title.value = "";
          url.value = "";
          shortcode.value = "";
          category.value = "";
          $showMessage(commit.text);
        } else {
          $error(commit.text);
        }
      }
    })
    .catch((err) => {
      console.log("ERROR:", err.message);
    });
});
