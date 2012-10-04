namespace :skeleton do
    task :install do
        pretty_print "Downloading Composer"
        run "cd #{latest_release} && test -f composer.phar && php composer.phar self-update || curl -s http://getcomposer.org/installer | php"
        puts_ok

        pretty_print "Installing WordPress Skeleton"
        run "cd #{latest_release} && php composer.phar install"
        puts_ok
    end
end
