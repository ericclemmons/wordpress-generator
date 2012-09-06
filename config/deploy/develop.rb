role :server,       "wordpress-skeleton.dev"

set :copy_strategy, :export
set :copy_exclude,  [".git"]

set :deploy_to,     "/var/www/#{application}"
set :deploy_via,    :copy

set :repository,    File.expand_path(File.dirname(__FILE__) + "/../../")

set :scm,           :none
set :use_sudo,      true

set :user,          "vagrant"
set :password,      "vagrant"

default_run_options[:pty] = true

after "deploy:update", "deploy:theme"

namespace :deploy do
    task :symlink do
        try_sudo "rm -f #{current_path}"
        try_sudo "ln -s /vagrant #{current_path}"
    end

    task :theme do
        run "ln -s #{current_path}/src #{current_path}/vendor/wordpress/wordpress/wp-content/themes/#{application}"
    end

    task :update_code do
        logger.important "`deploy:update_code` skipped because folder is mounted"
    end
end
