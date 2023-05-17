const gulp = require("gulp");
const cssmin = require("gulp-cssmin");
const uglify = require("gulp-uglify-es").default;
const watch = require("gulp-watch");

const pathJs = "public/js/*.js";
const pathNoJs = "!public/js/_*.js";
const pathNoJs2 = "!public/js/* copy.js";
const pathCss = "public/css/*.css";
const pathNoCss = "!public/css/_*.css";
const pathIcons = "public/css/*.woff2";

const toMinJs = "public/minjs";
const toMinCss = "public/mincss";

function minjs() {
  return gulp
    .src([pathJs, pathNoJs, pathNoJs2])
    // .pipe(uglify({ toplevel: false }))
    .pipe(gulp.dest(toMinJs));
}
function mincss() {
  return gulp
    .src([pathCss, pathNoCss, pathIcons])
    .pipe(cssmin())
    .pipe(gulp.dest(toMinCss));
}

//-----for host-----
const host_dir = "public_html";
const pathCssHost = `../cg28577_test3_indy/${host_dir}/mincss`;
const pathJsHost = `../cg28577_test3_indy/${host_dir}/minjs`;

const index = "public/index.php";
const host_index = "../cg28577_test3_indy/public_html";

const pathApp = `App/*`;
const pathAppHost = `../cg28577_test3_indy/App`;

const pathAppControllers = `App/Controllers/*`;
const pathAppControllersHost = `../cg28577_test3_indy/App/Controllers`;

const pathAppModels = `App/Models/*`;
const pathAppModelsHost = `../cg28577_test3_indy/App/Models`;

const pathTemplates = `Templates/*`;
const pathTemplatesHost = `../cg28577_test3_indy/Templates`;
const pathTemplatesComponents = `Templates/components/*`;
const pathTemplatesComponentsHost = `../cg28577_test3_indy/Templates/components`;
const pathTemplatesLayouts = `Templates/layouts/*`;
const pathTemplatesLayoutsHost = `../cg28577_test3_indy/Templates/layouts`;

function app_host() {
  return gulp.src([pathApp]).pipe(gulp.dest(pathAppHost));
}
function app_index_host() {
  return gulp.src([index]).pipe(gulp.dest(host_index));
}
function app_models_host() {
  return gulp.src([pathAppModels]).pipe(gulp.dest(pathAppModelsHost));
}
function app_controllers_host() {
  return gulp.src([pathAppControllers]).pipe(gulp.dest(pathAppControllersHost));
}
function templates_host() {
  return gulp.src([pathTemplates]).pipe(gulp.dest(pathTemplatesHost));
}
function templates_components_host() {
  return gulp
    .src([pathTemplatesComponents])
    .pipe(gulp.dest(pathTemplatesComponentsHost));
}
function templates_layouts_host() {
  return gulp
    .src([pathTemplatesLayouts])
    .pipe(gulp.dest(pathTemplatesLayoutsHost));
}

function mincss_host() {
  return gulp
    .src([pathCss, pathNoCss, pathIcons])
    .pipe(cssmin())
    .pipe(gulp.dest(pathCssHost));
}

function minjs_host() {
  return gulp
    .src([pathJs, pathNoJs, pathNoJs2])
    .pipe(uglify({ toplevel: false }))
    .pipe(gulp.dest(pathJsHost));
}

//-------END for host --------

gulp.task("minjs", minjs);
gulp.task("mincss", mincss);
gulp.task("mincss_host", mincss_host);
gulp.task("minjs_host", minjs_host);
gulp.task("app_host", app_host);
gulp.task("app_index_host", app_index_host);
gulp.task("app_models_host", app_models_host);
gulp.task("app_controllers_host", app_controllers_host);
gulp.task("templates_host", templates_host);
gulp.task("templates_components_host", templates_components_host);
gulp.task("templates_layouts_host", templates_layouts_host);

gulp.task("watch", function () {
  gulp.watch(pathJs, gulp.parallel("minjs"));
  gulp.watch(pathCss, gulp.parallel("mincss"));

  gulp.watch(pathCss, gulp.parallel("mincss_host"));
  gulp.watch(pathJs, gulp.parallel("minjs_host"));
  gulp.watch(pathApp, gulp.parallel("app_host"));
  gulp.watch(index, gulp.parallel("app_index_host"));
  gulp.watch(pathAppModels, gulp.parallel("app_models_host"));
  gulp.watch(pathAppControllers, gulp.parallel("app_controllers_host"));
  gulp.watch(pathTemplates, gulp.parallel("templates_host"));
  gulp.watch(
    pathTemplatesComponents,
    gulp.parallel("templates_components_host")
  );
  gulp.watch(pathTemplatesLayouts, gulp.parallel("templates_layouts_host"));
});
