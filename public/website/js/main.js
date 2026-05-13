document.addEventListener("DOMContentLoaded", function () {
  if (typeof SlimSelect !== "undefined") {
    new SlimSelect({
      select: "#CurrencySelect",
      settings: {
        showSearch: false,
      },
    });
  }
});
