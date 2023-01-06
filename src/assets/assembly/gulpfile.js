const gulp = require("gulp");
const { src, dest } = require("gulp");
const concat = require("gulp-concat");
const scss = require("gulp-sass")(require("sass"));

const paths = {
	src: {
		css: "../styles",
	},
	watch: {
		css: "../styles/**/*.scss",
	},
	build: {
		css: "../",
	},
};


const css = () => {
	return src(paths.watch.css)
		.pipe(concat("style.css"))
		.pipe(
			scss({
				outputStyle: "expanded",
			}).on("error", scss.logError)
		)
		.pipe(dest(paths.build.css))

};

const watchFiles = () => {
	gulp.watch([paths.watch.css], css);
};

const build = gulp.parallel(css);
const watch = gulp.parallel(build, watchFiles);

exports.css = css;
exports.build = build;
exports.watch = watch;
exports.default = watch;
