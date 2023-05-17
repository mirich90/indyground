let a;
class Editor {
  constructor(
    appId = "editor",
    events = [{ descr: "Заголовок 1", icon: "title" }],
    multiButtons = [
      { id: 1, icon: "code", onclick: "addCode", descr: "Вставить код" },
    ]
  ) {
    this.appId = appId;
    this.app = $id(appId);
    this.classEditor = "article-content";

    this.eventsId = appId + "-events";
    this.event = this.#html.render(this.eventsId, "multi-button");
    this.events = events;

    this.bodyId = appId + "-body";
    this.body = this.#html.render(this.bodyId);

    this.codeId = appId + "-code";
    this.code = this.#html.render(this.codeId);

    this.imgId = appId + "-img";
    this.img = this.#html.render(this.imgId);

    // this.multiButtonId = appId + "-multi-button";
    this.multiButtonId = "multi-button";
    this.multiButton = this.#html.render(this.multiButtonId, "multi-button");
    this.multiButtons = multiButtons;

    this.actionsId = appId + "-action";
    this.action = this.#html.render(this.actionsId);
    this.actions = [
      { name: "Сохранить", click: "save" },
      { name: "В черновик", click: "savestorage", class: "flat" },
    ];

    this.posts = [
      {
        class: this.classEditor,
        html: "Введите текст",
        isFocus: true,
        lang: "",
        tag: "p",
        _html: "Введите текст",
      },
    ];

    this.renderEvents = this.#html.renderEvents();
    this.renderCode = this.#html.renderCode();
    this.renderImg = this.#html.renderImg();
    this.renderPosts = this.#html.renderPosts();
    this.renderActions = this.#html.renderActions();
    this.renderMultiButton = this.#html.renderMultiButton();
  }

  setFocus = () => {
    this.#html.setFocus();
  };
  #html = {
    render: (elementId, className) => {
      let newEl = document.createElement("div");
      newEl.id = elementId;
      if (className) newEl.classList.add(className);
      this.app.append(newEl);
      return newEl;
    },
    closePopup: (event) => {
      $for(".popup", (e) => {
        e.style.display = "none";
      });
      event.preventDefault();
      editor.setFocus();
    },
    renderImg: () => {
      this.img.classList.add("popup", "popup-img");
      this.img.innerHTML = `<div class="popup-code-box popup-box">
      <div id="popup-img-button" class="button medium dark flat w100">
        Добавить картинку
      </div>
      <div id="popup-img-menu" class="buttons">
        <button id="popup-article-info-img-delete" class="button">
          Удалить
        </button>
        <button id="popup-img-change" class="button">
          Высота 400px?
        </button>
      </div>
      <input
        id="popup-img-input"
        type="file"
        name="image"
        class="img"
        value="Upload image"
      />
    </div>`;

      $id("popup-img-input").addEventListener("change", (event) => {
        // let image = $id("popup-article-info-img");
        let reader = new FileReader();
        reader.onload = (evt) => {
          let id = this.#post.getFocusId();
          let image = this.posts[id];
          image.tag = "img";
          image.src = evt.target.result;
          this.#html.renderPosts();
        };
        if ($id("popup-img-input").files[0]) {
          // if (reader.readyState != 0) {
          reader.readAsDataURL($id("popup-img-input").files[0]);
        }
      });
      // пока не готово,просто добавило событие для добавления кода
      // $id("popup-code-button-add").addEventListener("click", (event) => {
      //   let textarea = $id("popup-code-textarea");
      //   let lang = $id("popup-code-lang").value;
      //   let post = this.#post.getFocus();
      //   let code = this.#html.highlight(textarea.value);

      //   post.tag = "pre";
      //   post.html = code;
      //   post.lang = lang;
      //   textarea.value = "";

      //   this.#html.renderPosts();
      //   this.#html.closePopup(event);
      //   this.#html.showMultiButton();
      // });
    },
    renderCode: () => {
      let className = "popup-code";
      this.code.classList.add("popup", className);

      this.code.innerHTML = `<div class="popup-code-box popup-box">
      <div class="input__wrapper">
        <label class="label-form">Введите код</label>
        <textarea
          tabindex="0"
          class="textarea"
          type="text"
          placeholder="Введите код"
          id="popup-code-textarea"
        ></textarea>
      </div>
      <div class="input__wrapper">
        <label class="label-form">Язык</label>
        <select
          id="popup-code-lang"
          type="text"
          class="select"
          placeholder="Placeholder"
          tabindex="0"
        >
          <option value="js">JavaScript</option>
          <option value="html">HTML</option>
          <option value="css">CSS</option>
          <option value="go">Go</option>
          <option value="php">PHP</option>
          <option value="python">Python</option>
          <option value="java">Java</option>
        </select>
      </div>

      <div class="popup-code-buttons buttons">
        <div>
          <button
            id="popup-code-button-add"
            tabindex="0"
            class="popup-code-button button medium maxwidth dark"
          >
            Вставить код
          </button>
          <button
            tabindex="0"
            class="popup-code-button button maxwidth medium accent3 cancel"
          >
            Отмена
          </button>
        </div>
      </div>
    </div>`;

      // пока не готово,просто добавило событие для добавления кода
      $id("popup-code-button-add").addEventListener("click", (event) => {
        let textarea = $id("popup-code-textarea");
        let lang = $id("popup-code-lang").value;
        let post = this.#post.getFocus();
        let code = this.#html.highlight(textarea.value);

        post.tag = "pre";
        post.html = code;
        post.lang = lang;
        textarea.value = "";

        this.#html.renderPosts();
        this.#html.closePopup(event);
        this.#html.showMultiButton();
      });
    },
    preRenderPosts: () => {
      const tags = ["h2", "h3", "h4", "p", "cite", "li", "blockquote"];
      this.posts.forEach((post, id) => {
        if (tags.includes(post.tag))
          post.html = $$("." + this.classEditor)[id].innerHTML;
      });
    },
    renderPosts: (updateElement = null, id = null) => {
      if (updateElement) {
        updateElement.removeAttribute("autofocus");
        this.posts[id].html = updateElement.innerHTML;
      } else {
        this.body.innerHTML = "";
        this.posts.forEach((post, id) => this.#html.renderPost(post, id));
        this.#html.setFocus();
      }
    },

    renderPost: (post, id) => {
      let newEl = document.createElement(post.tag);
      newEl.setAttribute("data-id", id);
      newEl.setAttribute("contenteditable", "true");
      newEl.setAttribute("tabindex", "0");
      newEl.innerHTML = post.html;
      newEl.classList.add(post.class, this.bodyId + "-post");
      if (post.tag === "pre") {
        newEl.classList.add("lang-" + post.lang);
      }
      if (post.tag === "img") {
        newEl.setAttribute("src", post.src);
      }

      if (post.isFocus) newEl.setAttribute("autofocus", "autofocus");

      newEl.addEventListener("keyup", (event) => {
        this.#post.updateFocus();
        this.#html.updateFocus();
      });
      newEl.addEventListener("click", (event) => {
        if (post.tag === "img") {
          this.#html.showImg();
        } else {
          this.#post.updateFocus();
          this.#html.updateFocus(true);
        }
      });
      newEl.addEventListener("paste", (event) => {
        let paste = (event.clipboardData || window.clipboardData).getData(
          "text"
        );
        // paste = paste.toUpperCase();

        const selection = window.getSelection();
        if (!selection.rangeCount) return false;
        selection.deleteFromDocument();
        selection.getRangeAt(0).insertNode(document.createTextNode(paste));

        event.preventDefault();
      });

      newEl.addEventListener("keydown", (event) => {
        this.#post.update(newEl);
        if (event.code == "ArrowRight" || event.code == "ArrowLeft") {
          this.#html.setMultiButton(event.code);
        } else if (event.code == "Enter") {
          event.preventDefault();
          if ($(".multi-button-active")) {
            if ($(".multi-button-active").dataset.onclick === "addCode") {
              this.#html.showCode();
            } else if ($(".multi-button-active").dataset.onclick === "addImg") {
              this.#html.showImg();
            }
            $(".multi-button-active").classList.remove("multi-button-active");
          } else {
            this.#post.add(event.target);
          }
        } else if (event.code === "Tab") {
          // console.log(event.code);
        } else {
          this.#html.clearMultiButton();
          if (event.altKey) {
            if (event.code == "Digit1")
              this.#post.edit(this.#html.getFocusElement(), "h2");
            else if (event.code == "Digit2")
              this.#post.edit(this.#html.getFocusElement(), "h3");
            else if (event.code == "Digit3")
              this.#post.edit(this.#html.getFocusElement(), "h4");
            else if (event.code == "Digit4")
              this.#post.edit(this.#html.getFocusElement(), "p");
            else if (event.code == "Digit5")
              this.#post.edit(this.#html.getFocusElement(), "blockquote");
            else if (event.code == "Digit6")
              this.#post.edit(this.#html.getFocusElement(), "li");
            else if (event.code == "Digit7")
              this.#post.edit(this.#html.getFocusElement(), "cite");
            else if (event.code == "Backspace")
              this.#post.edit(this.#html.getFocusElement(), "delete");
            else if (event.code == "KeyL")
              this.#post.edit(this.#html.getFocusElement(), "createLink");
            else if (event.code == "KeyU")
              this.#post.edit(this.#html.getFocusElement(), "unlink");
            else if (event.code == "KeyC")
              this.#post.edit(this.#html.getFocusElement(), "clear");
          }
          this.#html.addEventPre(event.target.innerText, post.tag);
        }
      });

      this.body.append(newEl);
    },
    addEventPre: (html, tag) => {
      if (tag === "pre") {
        this.#html.showCode(html);
      }
    },
    setMultiActiveFirst: () => {
      $("#multi-button").firstElementChild.classList.add("multi-button-active");
    },
    setMultiActiveLast: () => {
      $("#multi-button").lastElementChild.classList.add("multi-button-active");
    },
    setMultiButton: (direct) => {
      if ($(".multi-button-active")) {
        let multi = $(".multi-button-active");
        if (direct === "ArrowRight") {
          let next = multi.nextElementSibling;
          this.#html.clearMultiButton();
          if (next) {
            next.classList.add("multi-button-active");
          } else {
            this.#html.setMultiActiveFirst();
          }
        } else {
          let prev = multi.previousElementSibling;
          this.#html.clearMultiButton();
          if (prev) {
            prev.classList.add("multi-button-active");
          } else {
            this.#html.setMultiActiveLast();
          }
        }
      } else {
        this.#html.setMultiActiveFirst();
      }
    },
    clearMultiButton: () => {
      if ($(".multi-button-active")) {
        $for(".multi-button-active", (e) =>
          e.classList.remove("multi-button-active")
        );
      }
    },
    setFocus: (el = false) => {
      if (el) {
        // el = $(el);
      } else {
        el = this.#html.getFocusElement();
      }
      el.setAttribute("autofocus", "autofocus");
      el.focus();
    },
    getFocusElement: () => {
      return $(`.${this.classEditor}[autofocus="autofocus"]`);
    },
    getFocusElements: () => {
      return $$(`.${this.classEditor}[autofocus="autofocus"]`);
    },
    getFocusElementId: () => {
      return +this.#html.getFocusElement().dataset.id;
    },
    getTag: (el) => {
      return el.tagName.toLowerCase();
    },
    getNextTag: (el) => {
      let tag = el.tagName.toLowerCase();
      return tag === "li" ? "li" : "p";
    },
    showCode: (code = "") => {
      $(".popup-code").style.display = "flex";
      $id("popup-code-textarea").value = code;
      $id("popup-code-textarea").focus();
    },
    showImg: () => {
      // console.log(1);
      // event.preventDefault();
      $id("popup-img-input").click();
      // $(".popup-img").style.display = "flex";
      // $id("popup-code-textarea").value = code;
      // $id("popup-img-button").focus();
    },
    showMultiButton: () => {
      let focusElement = this.#html.getFocusElement();
      console.log(focusElement.tagName);
      if (focusElement.innerHTML === "" && focusElement.tagName !== "IMG") {
        // console.log("asdfasdf");
        let multi = $("#multi-button");
        multi.style.left = focusElement.offsetLeft + 100 + "px";
        multi.style.top = focusElement.offsetTop + 6 + "px";
        multi.style.display = "flex";
        console.dir(focusElement);
      } else {
        $("#multi-button").style.display = "none";
      }
    },
    updateFocus: (isMouse = false) => {
      let id = this.#post.getFocusId();
      let elem = $$("." + this.classEditor)[id];
      if (isMouse) {
        this.#html.clearAutofocus();
        if (elem.innerHTML === "") {
          elem.setAttribute("autofocus", "autofocus");
          this.#html.showMultiButton();
          // this.#html.showMultiButton();
          // this.#html.renderPosts();
        } else {
          elem.setAttribute("autofocus", "autofocus");
          const id = this.#post.getFocusId();
          this.posts[id].html = this.#html.getFocusElement().innerHTML;
        }
      } else {
        this.#html.showMultiButton();
        if (this.#post.getFocusId() !== this.#html.getFocusElementId()) {
          this.#html.setFocus(elem);
          console.log(elem, this.#html.getFocusElement());
          this.#html.renderPosts(
            this.#html.getFocusElement(),
            this.#post.getFocusId()
          );
        }
      }
    },
    clearAutofocus: () => {
      this.#html.getFocusElements().forEach((e) => {
        e.removeAttribute("autofocus");
      });
    },
    renderEvents: () => {
      this.events.forEach((e) => {
        let newEl = document.createElement("button");
        let classEvents = this.eventsId + "-item";
        newEl.classList.add(classEvents);

        let icon = document.createElement("i");
        icon.classList.add("material-icons", "noactive", classEvents + "-icon");
        icon.innerHTML = e.icon;
        newEl.append(icon);

        let p = document.createElement("p");
        p.innerHTML = e.descr;
        p.classList.add(classEvents + "-description");
        newEl.append(p);

        newEl.addEventListener("click", (event) => {
          this.#post.update();
          this.#html.updateFocus();
          event.preventDefault();
          this.#post.edit(this.#html.getFocusElement(), e.onclick);
        });

        this.event.append(newEl);
      });
    },
    renderMultiButton: () => {
      this.multiButtons.forEach((e) => {
        let newEl = document.createElement("button");
        let classButtons = this.multiButtonId + "-item";
        newEl.classList.add(classButtons);
        newEl.setAttribute("data-onclick", e.onclick);

        let icon = document.createElement("i");
        icon.classList.add(
          "material-icons",
          "noactive",
          classButtons + "-icon"
        );
        icon.innerHTML = e.icon;
        newEl.append(icon);

        let p = document.createElement("div");
        p.innerHTML = e.descr;
        p.classList.add(classButtons + "-description");
        p.classList.add("tooltip-button");
        newEl.append(p);

        newEl.addEventListener("click", (event) => {
          this.#post.update();
          this.#html.updateFocus();
          event.preventDefault();
          console.log(e.onclick);
          this.#html[e.onclick]();
          // this.#post.edit(this.#html.getFocusElement(), e.onclick);
        });

        this.multiButton.append(newEl);
      });
    },
    renderActions: () => {
      this.actions.forEach((e) => {
        let newEl = document.createElement("button");
        let classActions = this.actionsId + "-item";
        newEl.classList.add(classActions, "button", "medium");
        if (e.class) newEl.classList.add("flat");
        this.action.classList.add(classActions, "buttons");
        newEl.innerHTML = e.name;
        if (e.click === "save") {
          // newEl.classList.add("disabled");
          newEl.classList.add("bottom");
          newEl.classList.add("tooltip");
          newEl.classList.add("dark");
          newEl.setAttribute("data-tooltip", "Напишите не менее трех абзацев");
        }

        newEl.addEventListener("click", (event) => {
          event.preventDefault();
          if (e.click === "save" && this.posts.length > 2) {
            this.#html.preRenderPosts();
            this.#post.saveStorage();
            $(".popup-article-info").style.display = "flex";
          }
          if (e.click === "savestorage") {
            this.#post.saveStorage();
          }
        });

        this.action.append(newEl);
      });
    },
    highlight: (text) => {
      var comments = []; // Тут собираем все каменты
      var strings = []; // Тут собираем все строки
      var res = []; // Тут собираем все RegExp
      var all = { C: comments, S: strings, R: res };
      return (
        text
          .replace(/(<)/gi, "&lt;")
          .replace(/(>)/gi, "&gt;")
          //Убираем каменты
          .replace(/\/\*[\s\S]*\*\//g, function (m) {
            var l = comments.length;
            comments.push(m);
            return "~~~C" + l + "~~~";
          })
          .replace(/([^\\])\/\/[^\n]*\n/g, function (m, f) {
            var l = comments.length;
            comments.push(m);
            return f + "~~~C" + l + "~~~";
          })
          // Убираем строки
          .replace(
            /([^\\])((?:'(?:\\'|[^'])*')|(?:"(?:\\"|[^"])*"))/g,
            function (m, f, s) {
              var l = strings.length;
              strings.push(s);
              return f + "~~~S" + l + "~~~";
            }
          )
          // Возвращаем на место каменты, строки, RegExp
          .replace(/~~~([CSR])(\d+)~~~/g, function (m, t, i) {
            let tag =
              t === "C"
                ? "pre__comment"
                : t === "S"
                ? "pre__string"
                : "pre__html";
            return '<span class="' + tag + '">' + all[t][i] + "</span>";
          })
          .replace(
            /(console|var|export|try|catch|const|let|function|typeof|new|return|if|for|in|while|break|do|continue|switch|case)([^a-z0-9$_])/gi,
            '<span class="pre__keyword">$1</span>$2'
          )
          // Выделяем методы
          .replace(
            /(replace|map|reduce|split|length|log|search|includes|indexOf|push|find|filter)([^a-z0-9$_])/gi,
            '<span class="pre__method">$1</span>$2'
          )
          // значения
          .replace(
            /(undefined|null|NaN|true|false)([^a-z0-9$_])/gi,
            '<span class="pre__keyword">$1</span>$2'
          )
          // Выделяем ключевые слова this
          .replace(
            /(this)([^a-z0-9$_])/gi,
            '<span class="pre__keyword">$1</span>$2'
          )
          // Выделяем скобки
          .replace(
            /(\{|\}|\]|\[|\|)/gi,
            '<span class="pre__operator">$1</span>'
          )
          // Выделяем имена функций
          .replace(
            /([a-z\_\$][a-z0-9_]*)[\s]*\(/gi,
            '<span class="pre__keyword">$1</span>('
          )
          // Выделяем  цифры
          .replace(/([0-9])/gi, '<span class="pre__number">$1</span>')
      );
    },
  };
  #post = {
    getFocusId: () => {
      return this.posts.findIndex((e) => e.isFocus);
    },
    getFocus: () => {
      return this.posts.find((e) => e.isFocus);
    },
    delete: () => {
      // let id = el.dataset.id;
      // if (this.posts.length === 1) {
      //   this.#html.setFocus();
      //   return;
      // }
      // this.posts.splice([id], 1);
      // if (id != 0) id -= 1;
      // this.clearFocus();
      // this.posts[id].isFocus = true;
      // this.setFocus();
    },
    updateFocus: () => {
      let active = document.activeElement;
      if (active.classList.contains(this.classEditor)) {
        this.#post.clearFocus();
        this.posts[active.dataset.id].isFocus = true;
      }
    },
    // { id: 8, icon: "format_bold", onclick: "bold", descr: "ctrl+b" },
    // { id: 9, icon: "format_italic", onclick: "italic", descr: "ctrl+i" },
    // { id: 0, icon: "format_underlined", onclick: "underline", descr: "ctrl+u" },
    // { id: 15, icon: "add_link", onclick: "createLink", descr: "link" },
    // { id: 16, icon: "link_off", onclick: "unlink", descr: "unlink" },
    // { id: 17, icon: "clear", onclick: "clear", descr: "clear" },
    edit: (el, action = null) => {
      let id = +el.dataset.id;
      const styleTags = ["bold", "italic", "underline"];
      if (styleTags.includes(action)) {
        document.execCommand(action, false);
        return;
      }
      if (action == "createLink") {
        var sLnk = prompt("Введите ссылку", "http://");
        if (sLnk && sLnk !== "" && sLnk !== "http://") {
          document.execCommand(action, false, sLnk);
        }
        return;
      }
      if (action == "unlink") {
        document.execCommand(
          "unlink",
          false,
          document.getSelection().toString()
        );
        return;
      }
      if (action == "clear") {
        document.execCommand(
          "removeFormat",
          false,
          document.getSelection().toString()
        );
        return;
      }
      if (action == "delete") {
        if (this.posts.length === 1) {
          this.#html.setFocus();
          return;
        }
        let newId = id == 0 ? id + 1 : id - 1;
        this.posts.splice([id], 1);
        this.#post.clearFocus();
        this.posts[newId].isFocus = true;
        this.#html.renderPosts();
        this.#html.showMultiButton();
        return;
      }
      this.posts[id].tag = action;
      this.#html.renderPosts();
    },
    add: (el, elem = null) => {
      // if (el.tagName === "PRE") {
      //   if (!this.isCursorInEnd()) return;
      // }
      this.#post.update(el);
      let id = +el.dataset.id;
      let newId = id + 1;
      console.log(id, newId);
      let item = {
        tag: this.#html.getNextTag(el),
        class: this.classEditor,
        html: "",
        _html: "",
        lang: "",
        isFocus: true,
      };
      if (elem) item.tag = "li";
      this.#post.clearFocus();
      console.log(this.posts);
      this.posts.splice(newId, 0, item);
      this.#html.renderPosts();
    },
    update: (el) => {
      if (!el) el = this.#html.getFocusElement();
      this.posts[+el.dataset.id].html = el.innerHTML;
      a = this.posts;
      // console.log(el, this.posts[+el.dataset.id]);
    },
    clearFocus: () => {
      this.posts.forEach((post) => (post.isFocus = false));
    },
    getStorage: () => {
      if (!localStorage.getItem("post")) {
        localStorage.setItem("post", this.clearStorage());
      }
      let arr = JSON.parse(localStorage.getItem("post"));
      let post = this.parsePostJson(arr);
      document.querySelector("#form-contenteditable").innerHTML = post;
      this.initPost();
    },
    saveStorage: () => {
      localStorage.setItem("post", JSON.stringify(this.posts));
    },
  };
}

const multiButtons = [
  { id: 1, icon: "code", onclick: "addCode", descr: "Вставить код" },
  { id: 2, icon: "insert_photo", onclick: "addImg", descr: "Картинку" },
  { id: 3, icon: "queue", onclick: "addSpoiler", descr: "Спойлер" },
  { id: 4, icon: "wysiwyg", onclick: "addCard", descr: "Карточку" },
];

const events = [
  { id: 1, icon: "title", onclick: "h2", descr: "1" },
  { id: 2, icon: "title", onclick: "h3", descr: "2" },
  { id: 3, icon: "title", onclick: "h4", descr: "3" },
  { id: 4, icon: "format_align_left", onclick: "p", descr: "4" },
  { id: 5, icon: "comment", onclick: "blockquote", descr: "5" },
  { id: 6, icon: "format_list_bulleted", onclick: "li", descr: "6" },
  { id: 7, icon: "edit_note", onclick: "cite", descr: "7" },
  { id: 8, icon: "format_bold", onclick: "bold", descr: "ctrl+b" },
  { id: 9, icon: "format_italic", onclick: "italic", descr: "ctrl+i" },
  { id: 0, icon: "format_underlined", onclick: "underline", descr: "ctrl+u" },
  { id: 15, icon: "add_link", onclick: "createLink", descr: "link" },
  { id: 16, icon: "link_off", onclick: "unlink", descr: "unlink" },
  { id: 17, icon: "clear", onclick: "clear", descr: "clear" },
  { id: 17, icon: "delete_sweep", onclick: "delete", descr: "bspace" },
];

let editor = new Editor("editor", events, multiButtons);
