function startTask(tasks) {
  console.log(tasks);
  tasks.forEach((e) => {
    renderTask(e);
  });

  const placeHolders = document.querySelectorAll(".placeholder");
  const items = document.querySelectorAll(".item");
  const addTask = document.querySelector(".add-task");
  const selects = document.querySelectorAll(".item select");

  addTask.addEventListener("click", addNewTask);

  for (const select of selects) {
    select.addEventListener("change", change);
  }

  for (const placeHolder of placeHolders) {
    placeHolder.addEventListener("dragover", dragOver);
    placeHolder.addEventListener("dragenter", dragEnter);
    placeHolder.addEventListener("dragleave", dragLeave);
    placeHolder.addEventListener("drop", dragDrop);
  }

  for (const item of items) {
    addEventForTask(item);
  }

  function addEventForTask(item) {
    item.addEventListener("dragstart", dragStart);
    item.addEventListener("dragend", dragEnd);
    item.children[0].addEventListener("click", editTitle);
    item.children[0].addEventListener("blur", endEditTitle);
    item.children[0].addEventListener("keydown", enterTitle);
    item.children[1].addEventListener("click", editTitle);
    item.children[1].addEventListener("blur", endEditTitle);
    item.children[1].addEventListener("keydown", enterTitle);
    addEventForSubtask(item.children[2]);
    addEventAddSubtask(item.children[3]);
  }

  function addEventAddSubtask(btn) {
    if (btn.tagName !== "BUTTON") return;
    btn.addEventListener("click", (e) => {
      let el = e.target;
      let idTask = el.parentElement.dataset.id;
      let subtask = {
        user_id: "",
        status: "1",
        title: "",
        task_id: idTask,
      };
      addSubtaskToDb(subtask);
    });
  }

  function addEventForSubtask(subtasks) {
    if (subtasks.tagName === "BUTTON") addEventAddSubtask(subtasks);
    if (subtasks.tagName !== "UL") return;
    for (subtask of subtasks.children) {
      subtask.addEventListener("click", editSubtask);
      subtask.addEventListener("keydown", enterSubtask);
      subtask.addEventListener("blur", endEditSubtask);
    }
  }

  function addNewTask() {
    let task = {
      author: "",
      description: "",
      priority: "critical",
      state: "1",
      status: "start",
      title: "",
      worker_id: "",
    };
    addTaskToDb(task);
  }

  function renderTask(task, isFocus = false) {
    let parent = document.querySelector(`.placeholder-${task.status}`);
    let item = new El("div", "", `item ${task.priority}`, {
      draggable: "true",
      "data-id": task.id,
    }).create();

    let h3 = new El("h3", task.title, "", { tabindex: "0" }).in(item);
    let h4 = new El("h4", task.description, "", { tabindex: "0" }).in(item);

    if (task.subtasks) {
      let subtasks = task.subtasks.split("||");
      let subtask_id = task.subtask_ids.split("||");
      let subtask_statuses = task.subtask_statuses.split("||");
      console.log(subtask_statuses);

      let ul = new El("ul").in(item);

      subtask_id.forEach((id, i) => {
        let li = new El("li").create();
        let label = new El("label", subtasks[i], "", {
          "data-id": id,
          tabindex: "0",
        }).create();
        let input = new El("input", null, "", {
          type: "checkbox",
          id: `subtask-${task.id}-${i}`,
          name: `subtask-${task.id}-${i}`,
          "data-id": id,
        }).create();
        li.append(input);
        li.append(label);
        ul.append(li);

        input.checked = Boolean(+subtask_statuses[i]);
      });
    }

    let buttonSubtask = new El("button", "+", "btn-new-subtask", {
      tabindex: "0",
    }).in(item);
    let action = new El("div", "", "item-action").in(item);
    let button = new El("button", "22.02").in(action);
    let select = new El("select", "", "").in(action);

    if (isFocus) {
      addEventForTask(item);
      let newTask = addTask.insertAdjacentElement("afterEnd", item);
      editTitle(newTask.firstElementChild);
    } else {
      parent.append(item);
    }
  }

  function editTitle(event) {
    el = event.target || event;
    el.setAttribute("contenteditable", "true");
    el.focus();
    console.log(event.target);
  }

  function enterTitle(event) {
    if (event.code === "Enter") {
      event.preventDefault();
      endEditTitle(event);
    }
  }

  function endEditTitle(event) {
    let el = event.target;
    let task = getTask(el);
    if (el.tagName === "H3") {
      task.title = el.innerText;
    } else {
      task.description = el.innerText;
    }
    editTask(task);
    event.target.removeAttribute("contenteditable");
    event.target.blur();
  }

  function editSubtask(event) {
    let el = event.target;
    if (el.tagName === "LABEL") {
      el.setAttribute("contenteditable", "true");
      el.focus();
    } else if (el.tagName === "INPUT") {
      let id = el.dataset.id;
      let title = el.nextElementSibling.innerText;
      editSubtaskToDb(id, title, el.checked);
    }
  }

  function enterSubtask(event) {
    if (event.code === "Enter") {
      event.preventDefault();
      endEditSubtask(event);
    }
  }

  function endEditSubtask(event) {
    let el = event.target;
    let id = el.dataset.id;
    let text = el.innerText;
    let status = el.previousElementSibling.checked;
    console.log(id, text);

    // let task = getTask(el);
    // if (el.tagName === "H3") {
    //   task.title = el.innerText;
    // } else {
    //   task.description = el.innerText;
    // }
    editSubtaskToDb(id, text, status);
    event.target.removeAttribute("contenteditable");
    event.target.blur();
  }

  function dragStart(event) {
    let item = event.target;
    item.classList.add("hold");
    item.id = "id" + Date.now();
    event.dataTransfer.setData("text", item.id);
    setTimeout(() => {
      item.classList.add("hide");
    }, 0);
  }

  function change(event) {
    let el = event.target;
    let task = tasks.find((task) => task.id == el.dataset.id);
    if (task) task.worker = el.value;
    console.log(task);
  }

  function dragEnd(event) {
    let item = event.target;
    item.classList.remove("hold", "hide");
  }

  function dragOver(event) {
    event.preventDefault();
  }

  function dragEnter(event) {
    let el = event.currentTarget;
    if (el.classList.contains("placeholder")) {
      el.classList.add("hovered");
    }
  }

  function dragLeave(event) {
    let el = event.currentTarget;
    if (el.classList.contains("placeholder")) {
      el.classList.remove("hovered");
    }
  }

  function getTask(item) {
    let id = item.dataset.id;
    if (!id) id = item.parentElement.dataset.id;

    console.log(tasks);
    return tasks.find((task) => task.id == id);
  }

  function dragDrop(event) {
    let el = event.currentTarget;
    let item = document.querySelector("#" + event.dataTransfer.getData("text"));
    if (el.classList.contains("placeholder")) {
      el.appendChild(item);
      item.classList.remove("hide");
      el.classList.remove("hovered");
      let task = getTask(item);
      if (task) task.status = el.dataset.status;
      // console.log(task);
      editTask(task);
    }
  }

  async function editSubtaskToDb(id, title, status) {
    let h = new Headers();
    let fd = new FormData();

    fd.append("subtask", true);
    fd.append("id", id);
    fd.append("title", title);
    fd.append("status", +status);

    let req = new Request(`/tasks/`, {
      method: "POST",
      cache: "no-cache",
      body: fd,
    });
    await fetch(req)
      .then((res) => res.json())
      // .then((res) => res.text())
      .then((commit) => {
        console.log(commit);
        if (commit.status) {
          console.log("Изменения сохранены");
        } else {
          console.log("Ошибка при сохранении");
        }
      })
      .catch((err) => {
        console.log("ERROR:", err.message);
      });
  }
  async function editTask(task) {
    let h = new Headers();
    let fd = new FormData();

    fd.append("task", JSON.stringify(task));
    fd.append("edit", true);

    let req = new Request(`/tasks/?id=${task.id}`, {
      method: "POST",
      cache: "no-cache",
      body: fd,
    });

    await fetch(req)
      .then((res) => res.json())
      // .then((res) => res.text())
      .then((commit) => {
        if (commit.status) {
          console.log("Изменения сохранены");
        } else {
          console.log("Ошибка при сохранении");
        }
      })
      .catch((err) => {
        console.log("ERROR:", err.message);
      });
  }

  async function addTaskToDb(task) {
    let h = new Headers();
    let fd = new FormData();

    fd.append("task", JSON.stringify(task));
    fd.append("add", true);

    let req = new Request(`/tasks/`, {
      method: "POST",
      cache: "no-cache",
      body: fd,
    });

    await fetch(req)
      .then((res) => res.json())
      // .then((res) => res.text())
      .then((commit) => {
        console.log(commit);
        if (commit.status === 200) {
          console.log("Создана задача");
          console.log(commit.data);
          tasks.push(commit.data);
          renderTask(commit.data, true);
        } else {
          console.log("Ошибка при сохранении");
        }
      })
      .catch((err) => {
        console.log("ERROR:", err.message);
      });
  }

  async function addSubtaskToDb(subtask) {
    let h = new Headers();
    let fd = new FormData();

    fd.append("newsubtask", true);
    fd.append("subtask", subtask);
    fd.append("task_id", subtask.task_id);

    let req = new Request(`/tasks/`, {
      method: "POST",
      cache: "no-cache",
      body: fd,
    });

    await fetch(req)
      .then((res) => res.json())
      // .then((res) => res.text())
      .then((commit) => {
        console.log(commit);
        if (commit.status === 200) {
          console.log("Создана подзадача");
          console.log(commit.data);
          renderSubtask(commit.data);
        } else {
          console.log("Ошибка при сохранении");
        }
      })
      .catch((err) => {
        console.log("ERROR:", err.message);
      });
  }

  function renderSubtask(data) {
    let task = tasks.find((task) => task.id == data.task_id);
    task.subtask_ids += "||" + data.id;
    task.subtask_statuses += "||0";
    task.subtasks += "||";
    let task_el = document.querySelector(`.item[data-id='${data.task_id}']`);
    let ul = task_el.children[2];
    if (ul.tagName === "BUTTON")
      ul = task_el.insertBefore(new El("ul").create(), task_el.children[2]);
    let i = ul.children.length;

    let li = new El("li").create();
    let label = new El("label", "", "", {
      "data-id": data.id,
      contenteditable: "true",
      tabindex: "0",
    }).create();
    let input = new El("input", null, "", {
      type: "checkbox",
      id: `subtask-${data.task_id}-${i}`,
      name: `subtask-${data.task_id}-${i}`,
      "data-id": data.task_id,
    }).create();
    input.checked = Boolean(0);
    li.append(input);
    li.append(label);
    ul.append(li);

    addEventForSubtask(ul);
    li.focus();

    placeCaretAtEnd(li);
  }

  function placeCaretAtEnd(el) {
    el.focus();
    el.selectionStart = el.value.length;
  }
}

class El {
  constructor(tag = "div", html = "", classes = "", attributes = {}) {
    this.tag = tag;
    this.html = html;
    this.classes = classes;
    this.attributes = attributes;
  }

  create() {
    let item = document.createElement(this.tag);
    if (this.classes !== "") item.className = this.classes;
    item.innerHTML = this.html;
    for (let key in this.attributes) {
      item.setAttribute(key, this.attributes[key]);
    }
    return item;
  }

  in(parent) {
    let item = this.create();
    parent.append(item);
    return item;
  }
}
