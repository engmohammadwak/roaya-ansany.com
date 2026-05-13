document.addEventListener("DOMContentLoaded", function () {
  if (typeof SlimSelect !== "undefined") {
    new SlimSelect({
      select: "#CurrencySelect",
      settings: {
        showSearch: false,
      },
    });
  }

  // ===== Fix float-section-container dynamic height =====
  function fixFloatSection() {
    const container = document.querySelector(".float-section-container");
    const section   = document.querySelector(".float-section");
    if (!container || !section) return;

    if (window.innerWidth >= 992) {
      const sectionHeight = section.offsetHeight;
      const topOffset     = 144; // top: -9rem = 144px
      const needed        = sectionHeight - topOffset;
      // setProperty with !important to override the CSS 68%
      container.style.setProperty("margin-bottom", needed + "px", "important");
    } else {
      container.style.removeProperty("margin-bottom");
    }
  }

  fixFloatSection();
  window.addEventListener("resize", fixFloatSection);
});
