<?php

declare(strict_types=1);

namespace Deployer;

set('default_stage', 'test');

require 'recipe/symfony4.php';

// Project name
set('application', 'Sample app');

// Project repository
set('repository', 'git@github.com:jeroendk/symfony-build-and-deploy.git');

// Set composer options
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-scripts');

// shared files & folders
add('shared_files', ['.env.local']);
add('shared_dirs', ['public/upload']);

// Hosts
host('test')
    ->hostname('localhost')
    ->user('jeroen')
    ->port(22)
    ->stage('test')
    ->set('branch', 'develop')
    ->set('deploy_path', '~/deploy-folder')
;

// Tasks
task('pwd', function (): void {
    $result = run('pwd');
    writeln("Current dir: {$result}");
});

// [Optional]  Migrate database before symlink new release.
// before('deploy:symlink', 'database:migrate');

// Build yarn locally
task('deploy:build:assets', function (): void {
    run('yarn install');
    run('yarn encore production');
})->local()->desc('Install front-end assets');

before('deploy:symlink', 'deploy:build:assets');

// Upload assets
task('upload:assets', function (): void {
    upload(__DIR__.'/public/build/', '{{release_path}}/public/build');
});

after('deploy:build:assets', 'upload:assets');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
