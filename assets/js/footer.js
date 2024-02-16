
document.addEventListener("DOMContentLoaded", function() {
    var lastScrollTop = 0;
  
    window.addEventListener("scroll", function() {
      var st = window.scrollY;
      var footer = document.querySelector("footer");
  
      if (st > lastScrollTop) {
        // Scroll down
        footer.classList.add("visible");
      }
  
      lastScrollTop = st;
    });
  });