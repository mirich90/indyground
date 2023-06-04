$blur($id("shortlink-url"), (event) => {
  const value = event.target.value.trim();

  if (value === "") return;

  if (value.length < 13) {
    $error("Длина ссылки должна быть не менее 13 символов");
  }
  if (!value.startsWith("https://") && !value.startsWith("https://")) {
    $error(
      'Первые символы поля всегда должны начинаться с "https://" или "http://"'
    );
  }
  if (value.indexOf(".") === -1) {
    $error("В URL должна быть хотя бы одна точка");
  }
});

$keydown($id("shortlink-shortcode"), (event) => {
  const el = event.target;
  const value = el.value;
  const regexp = /^[a-zA-Z0-9-][a-zA-Z0-9-]{4,}$/;
  console.log(value, !regexp.test(value));

  if (value === "") return;

  if (!regexp.test(value)) {
    $error(
      "Длина от 4 символов включительно. Только английские буквы, цифры и знак '-' (разделитель)"
    );
  }
});
