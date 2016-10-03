# config valid only for current version of Capistrano
lock '3.4.0'

set :application, 'restful'
set :repo_url, 'git@github.com:foohey/restful.git'

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, '/srv/www/restful'

# Default value for :scm is :git
set :scm, :git

# Default value for :format is :pretty
set :format, :pretty

# Default value for :log_level is :debug
set :log_level, :debug

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
set :linked_files, fetch(:linked_files, []).push(
  '.env'
)

# Default value for linked_dirs is []
set :linked_dirs, fetch(:linked_dirs, []).push(
  'tmp'
)

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
set :keep_releases, 2

namespace :deploy do
end

namespace :server do
  desc "Start server"
  task :start do
    on roles( :app ) do
      within current_path do
        execute :bundle, "exec rackup -o 0.0.0.0 -P tmp/restful.pid -D"
      end
    end
  end

  desc "Stop server"
  task :stop do
    on roles( :app ) do
      within current_path do
        execute "if [ -f #{current_path}/tmp/restful.pid ] && [ -e /proc/$(cat #{current_path}/tmp/restful.pid) ]; then kill -9 `cat #{current_path}/tmp/restful.pid`; fi"
      end
    end
  end

  desc "Restart server"
  task :restart do
    on roles( :app ) do
      invoke 'server:stop'
      invoke 'server:start'
    end
  end
end

after 'deploy:finished', 'server:restart'
