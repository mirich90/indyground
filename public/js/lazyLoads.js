function lazyLoads() {
  const images = document.querySelectorAll("img");
  const sources = document.querySelectorAll("source");
  const opt = {
    root: null,
    rootMargin: "0px",
    threshold: 0.1,
  };

  const observer = new IntersectionObserver(handleImg, opt);
  const observerSource = new IntersectionObserver(handleSource, opt);

  function handleImg(imgs, observer) {
    imgs.forEach((img) => {
      if (img.intersectionRatio > 0) {
        if (img.target.hasAttribute("data-src")) loadImg(img.target);
      }
    });
  }

  function handleSource(imgs, observer) {
    imgs.forEach((img) => {
      if (img.intersectionRatio > 0) {
        if (img.target.hasAttribute("data-src")) loadImg(img.target, "srcset");
      }
    });
  }

  function loadImg(img, attr = "src") {
    // const w = document.querySelector("article.section-right").clientWidth
    // const h = w / img.getAttribute('data-ratio')

    // img.setAttribute('width', w)
    // img.setAttribute('height', h)
    img.setAttribute(attr, img.getAttribute("data-src"));
  }

  images.forEach((img) => {
    observer.observe(img);
  });
  sources.forEach((source) => {
    observerSource.observe(source);
  });
}
lazyLoads();
