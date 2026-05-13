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

    // Only apply on desktop (float-section is absolute on desktop only)
    if (window.innerWidth >= 992) {
      const sectionHeight = section.offsetHeight;
      const topOffset     = Math.abs(parseInt(getComputedStyle(section).top) || 144); // default top: -9rem
      container.style.marginBottom = (sectionHeight - topOffset) + "px";
    } else {
      container.style.marginBottom = "";
    }
  }

  fixFloatSection();
  window.addEventListener("resize", fixFloatSection);
});
