window.onscroll = function () {
  progressBar();
};

function progressBar() {
  let windowScroll =
    document.body.scrollTop || document.documentElement.scrollTop;
  let documentHeight =
    document.documentElement.scrollHeight -
    document.documentElement.clientHeight;
  let scrolled = (windowScroll / documentHeight) * 100;

  $("#myBar").style.width = scrolled + "%";
}

progressBar();
