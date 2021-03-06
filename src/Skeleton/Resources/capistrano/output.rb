require 'colored'

STDOUT.sync
$error = false
$pretty_errors_defined = false

logger.level = Logger::IMPORTANT if logger.level > 1

def pretty_print(msg)
  if logger.level == Logger::IMPORTANT
    pretty_errors

    msg << '.' * (55 - msg.size)
    print msg
  else
    puts msg.green
  end
end

def puts_ok
  if logger.level == Logger::IMPORTANT && !$error
    puts '✔'.green
  end

  $error = false
end

def pretty_errors
  if !$pretty_errors_defined and logger.level < 1
    $pretty_errors_defined = true

    class << $stderr
      @@firstLine = true
      alias _write write

      def write(s)
        if @@firstLine
          s = '✘' << "\n" << s
          @@firstLine = false
        end

        _write(s.red)
        $error = true
      end
    end
  end
end
