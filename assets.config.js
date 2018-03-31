const requireAssetsHelper = require("encore-require-assets-helper");
requireAssetsHelper(
  "./assets/img/**/*.{jpg,png,svg,ico}",
  "./assets/js/assets.js",
  "./assets/",
  "../"
);
