require "capistrano/php"
require "capistrano/ext/multistage"
require "railsless-deploy"

set :stage_dir,     "deploy"
set :application,   "wordpress-skeleton"
