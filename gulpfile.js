var gulp = require('gulp');
var git = require('gulp-git');
var fs = require('fs');
var GulpSSH = require('gulp-ssh');
var cache = require('gulp-cache');
var gitmodified = require('gulp-gitmodified');
var runSequence = require('gulp-run-sequence');
var filter = require('gulp-filter');
var gulpif = require('gulp-if');
var files;
var config = {
  host: 'tatianafaberge.net',
  port: 22,
  username: 'tatianaf',
  privateKey: fs.readFileSync('id_rsa')
},
ftpGlob;
var all='./**/*';
    

var gulpSSH = new GulpSSH({
  ignoreErrors: false,
  sshConfig: config
})

 
gulp.task('deploy', function(cb) {
  runSequence( ['git', 'ftp'], cb);
});

gulp.task('git',['commit'],function(cb){
	runSequence( ['push', 'composer'], cb);
});

gulp.task('commit', function(){
	
  	git.commit('new commit', {args: '-a'});
});

gulp.task('push', function(){
  git.push('origin', 'master', function (err) {
    if (err) throw err;
  });
});

gulp.task('push-staging', function(){

  git.push('staging', 'master', function (err) {
    if (err) throw err;
  });
});
gulp.task('composer',['push-staging'], function() {
   var f = filter(['composer.json']);

    changed= files
        .pipe(f)
        if(changed){
        		gulpSSH
    .shell(['cd public_html/staging/', 'composer install'])
        }
});

gulp.task('ftp', function () {
  return gulp.src(ftpGlob)
  	.pipe(cache({
      key: makeHashKey   
    }))
    .pipe(gulpSSH.dest( '/public_html/staging/'))
})
  
function makeHashKey(file) {
  // Key off the file contents, jshint version and options
  return [file.contents.toString('utf8')].join('');
}