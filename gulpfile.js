// Assets
var PUBLIC_ASSETS_PATH = '/bundles/boshurikadmin';

var assets = {
    scripts: [
        {
            output: {
                filename: 'app.js',
                path:     'Resources/public/js'
            },
            paths: [
                'bower_components/jquery/dist/jquery.js',
                'bower_components/jquery-ui/ui/core.js',
                'bower_components/jquery-ui/ui/datepicker.js',

                'bower_components/select2/select2.js',
                'bower_components/select2/select2_locale_ru.js',
                'bower_components/jquery-cookie/jquery.cookie.js',
                'bower_components/fancybox/source/jquery.fancybox.js',
                'bower_components/history/scripts/bundled-uncompressed/html4+html5/jquery.history.js',
                'bower_components/jquery.inputmask/dist/inputmask/jquery.inputmask.js',
                'bower_components/jquery.inputmask/dist/inputmask/jquery.inputmask.date.extensions.js',
                'bower_components/jquery.inputmask/dist/inputmask/jquery.inputmask.extensions.js',
                'bower_components/jquery.inputmask/dist/inputmask/jquery.inputmask.numeric.extensions.js',
                'bower_components/noty/js/noty/jquery.noty.js',
                'bower_components/noty/js/noty/layouts/bottomRight.js',
                'bower_components/noty/js/noty/themes/bootstrap.js',
                'bower_components/jquery-form/jquery.form.js',

                'bower_components/Chart.js/Chart.js',
                'bower_components/Chart.Scatter.js/Chart.Scatter.js',

                'bower_components/admin-lte/bootstrap/js/bootstrap.js',
                'bower_components/iCheck/icheck.js',
                'bower_components/moment/moment.js',
                'bower_components/moment/locale/ru.js',
                'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'bower_components/slimScroll/jquery.slimscroll.js',
                'bower_components/admin-lte/dist/js/app.js',

                'Resources/scripts/vendor/datetimepicker.js',
                'Resources/scripts/vendor/icheck.js',
                'Resources/scripts/vendor/noty.js',
                'Resources/scripts/vendor/select2.js',

                'Resources/scripts/delete.js',
                'Resources/scripts/pagination.js'
            ]
        }
    ],
    styles: [
        {
            output: {
                filename: 'app.css',
                path:     'Resources/public/styles'
            },
            paths: [
                'bower_components/select2/select2.css',
                'bower_components/fancybox/source/jquery.fancybox.css',
                'bower_components/jquery-ui/themes/smoothness/jquery-ui.css',
                'bower_components/jquery-ui/themes/smoothness/theme.css',

                'bower_components/components-font-awesome/css/font-awesome.css',
                'bower_components/ionicons/css/ionicons.css',

                'bower_components/admin-lte/bootstrap/css/bootstrap.css',
                'bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'bower_components/admin-lte/dist/css/AdminLTE.css',
                'bower_components/admin-lte/dist/css/skins/skin-blue.css',
                'bower_components/iCheck/skins/square/blue.css'
            ]
        }
    ]
};

// Dependencies
var gulp = require('gulp');
var $    = require('gulp-load-plugins')();

// Dependency options
var options = {
    autoprefixer: {
        browsers: [ 'last 2 versions' ],
        cascade:  false
    },
    cssBase64: {
        maxWeightResource: 100000
    }
};

// Functions
var scriptsMap = function(callback) {
    for (var i = 0; i < assets.scripts.length; i++) {
        callback(assets.scripts[i]);
    }
};

var stylesMap = function(callback) {
    for (var i = 0; i < assets.styles.length; i++) {
        callback(assets.styles[i]);
    }
};

// Tasks
gulp.task('styles-clean', function () {
    var paths = [];
    stylesMap(function (styles) {
        paths.push(styles.output.path);
    });

    return gulp.src(paths, {read: false}).pipe($.rimraf());
});


gulp.task('scripts-clean', function () {
    var paths = [];
    scriptsMap(function (scripts) {
        paths.push(scripts.output.path);
    });

    return gulp.src(paths, {read: false}).pipe($.rimraf());
});

gulp.task('scripts', function() {
    scriptsMap(function(scripts) {
        gulp.src(scripts.paths)
            .pipe($.expectFile(scripts.paths))
            .pipe($.concat(scripts.output.filename))
            .pipe(gulp.dest(scripts.output.path));
    });
});

gulp.task('styles', function() {
    stylesMap(function(styles) {
        gulp.src(styles.paths)
            .pipe($.expectFile(styles.paths))
            .pipe($.replace('../public/images/', '../..' + PUBLIC_ASSETS_PATH + '/images/'))
            .pipe($.cssBase64(options.cssBase64))
            .pipe($.concat(styles.output.filename))
            //.pipe(autoprefixer(options.autoprefixer))
            .pipe(gulp.dest(styles.output.path));
    });
});

gulp.task('scripts-build', ['scripts-clean'], function() {
    scriptsMap(function(scripts) {
        gulp.src(scripts.paths)
            .pipe($.expectFile(scripts.paths))
            .pipe($.concat(scripts.output.filename))
            .pipe($.uglify())
            .pipe(gulp.dest(scripts.output.path));
    });
});

gulp.task('styles-build', ['styles-clean'], function() {
    stylesMap(function(styles) {
        gulp.src(styles.paths)
            .pipe($.expectFile(styles.paths))
            .pipe($.replace('../public/images/', '../..' + PUBLIC_ASSETS_PATH + '/images/'))
            .pipe($.cssBase64(options.cssBase64))
            .pipe($.concat(styles.output.filename))
            //.pipe(autoprefixer(options.autoprefixer))
            .pipe($.csso())
            .pipe(gulp.dest(styles.output.path));
    });
});

// Default task
gulp.task('default', ['scripts', 'styles']);

// Build task
gulp.task('build', ['scripts-build', 'styles-build']);

// Watch task
gulp.task('watch', function() {
    var scriptPaths = [];
    scriptsMap(function(scripts) {
        scriptPaths = scriptPaths.concat(scripts.paths);
    });
    gulp.watch(scriptPaths, ['scripts']);

    var stylePaths = [];
    stylesMap(function(styles) {
        stylePaths = stylePaths.concat(styles.paths);
    });
    gulp.watch(stylePaths, ['styles']);
});