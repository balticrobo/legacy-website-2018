import gulp from 'gulp';
import plugins from 'gulp-load-plugins';
import browser from 'browser-sync';
import rimraf from 'rimraf';
import panini from 'panini';
import yargs from 'yargs';
import lazypipe from 'lazypipe';
import inky from 'inky';
import fs from 'fs';
import siphon from 'siphon-media-query';
import beep from 'beepbeep';
import ext_replace from 'gulp-ext-replace';

const $ = plugins();
const PRODUCTION = !!(yargs.argv.production);
let CONFIG;

gulp.task('default',
  gulp.series(clean, pages, sass, images, inline));
gulp.task('watch',
  gulp.series('default', server, watch));
gulp.task('mail',
  gulp.series('default', readconf, mail));
gulp.task('build',
  gulp.series('default', copyHTMLToProd, copyTXTToProd));

function clean(done) {
  rimraf('./dist', done);
  rimraf('../public/email', done);
}

function pages() {
  let pagesSrc = ['src/pages/**/*.html'];
  if(PRODUCTION) {
    pagesSrc.push('src/pages/**/*.txt');
    pagesSrc.push('!src/pages/foundation/**/*.html');
    pagesSrc.push('!src/pages/**/index.html');
  }

  return gulp.src(pagesSrc)
    .pipe(panini({
      root: 'src/pages',
      layouts: 'src/layouts',
      partials: 'src/partials',
      helpers: 'src/helpers',
      data: 'src/data',
    }))
    .pipe(inky())
    .pipe(gulp.dest('dist'));
}

function resetPages(done) {
  panini.refresh();
  done();
}

function sass() {
  return gulp.src('src/assets/scss/app.scss')
    .pipe($.if(!PRODUCTION, $.sourcemaps.init()))
    .pipe($.sass({
      includePaths: ['node_modules/foundation-emails/scss']
    }).on('error', $.sass.logError))
    .pipe($.if(PRODUCTION, $.uncss(
      {
        html: ['dist/**/*.html']
      })))
    .pipe($.if(!PRODUCTION, $.sourcemaps.write()))
    .pipe(gulp.dest('dist/css'));
}

function images() {
  let imagesSrc = ['src/assets/img/**/*'];

  return gulp.src(imagesSrc)
    .pipe($.imagemin())
    .pipe(gulp.dest('../public/email'));
}

function inline() {
  return gulp.src('dist/**/*.html')
    .pipe($.if(PRODUCTION, inliner('dist/css/app.css')))
    .pipe(gulp.dest('dist'));
}

function server(done) {
  browser.init({
    server: 'dist',
    open: false
  });
  done();
}

function watch() {
  gulp.watch('src/pages/**/*.html').on('all', gulp.series(pages, inline, browser.reload));
  gulp.watch(['src/layouts/**/*', 'src/partials/**/*']).on('all', gulp.series(resetPages, pages, inline, browser.reload));
  gulp.watch(['../scss/**/*.scss', 'src/assets/scss/**/*.scss']).on('all', gulp.series(resetPages, sass, pages, inline, browser.reload));
  gulp.watch('src/assets/img/**/*').on('all', gulp.series(images, browser.reload));
}

function inliner(css) {
  let mqCss = siphon(fs.readFileSync(css).toString());
  let pipe = lazypipe()
    .pipe($.inlineCss, {
      applyStyleTags: false,
      removeStyleTags: true,
      preserveMediaQueries: true,
      removeLinkTags: false
    })
    .pipe($.replace, '<!-- <style> -->', `<style>${mqCss}</style>`)
    .pipe($.htmlmin, {
      collapseWhitespace: true,
      minifyCSS: true
    });
  return pipe();
}

function readconf(done) {
  const configPath = './config.json';
  try {
    CONFIG = JSON.parse(fs.readFileSync(configPath));
  }
  catch (e) {
    beep();
    console.log('Sorry, there was an issue locating your config.json.');
    process.exit();
  }
  done();
}

function mail() {
  return gulp.src('dist/**/*.html')
    .pipe($.mail(CONFIG.mail))
    .pipe(gulp.dest('dist'));
}

function copyHTMLToProd() {
  return gulp.src('dist/**/*.html')
    .pipe(ext_replace('.html.twig'))
    .pipe(gulp.dest('../templates/_mail'));
}

function copyTXTToProd() {
  return gulp.src('dist/**/*.txt')
    .pipe(ext_replace('.txt.twig'))
    .pipe(gulp.dest('../templates/_mail'));
}
