<?php

namespace Skeleton\Generator;

use Skeleton\Skeleton;

class Generator
{
    private $skeleton;

    private $source;

    private $destination;

    private $expression ='/{{{?([\w.]+)}}}?/';

    public function __construct(Skeleton $skeleton, $source, $destination)
    {
        $this->skeleton     = $skeleton;
        $this->source       = $source;
        $this->destination  = $destination;
    }

    /**
     * Generates a template to a destination with a given scope
     *
     * @param string Source template name
     * @param string Path to destination
     * @param array Template scope variables
     */
    public function generateSkeleton()
    {
        $files      = new \RecursiveDirectoryIterator($this->source, \RecursiveDirectoryIterator::SKIP_DOTS | \RecursiveDirectoryIterator::FOLLOW_SYMLINKS);
        $iterator   = new \RecursiveIteratorIterator($files);
        $generated  = array();

        foreach ($iterator as $path => $file) {
            if ($file->getBasename() === '.git') {
                return false;
            }

            $contents = $this->getParsedTemplate($file);

            try {
                $target     = $this->getParsedTemplatePath($file);
                $parentDir  = dirname($target);

                if (!is_dir($parentDir) && !mkdir($parentDir, 0775, true)) {
                    throw new \Exception('Unable to create directory '.$parentDir);
                }

                if (!file_put_contents($target, $contents)) {
                    throw new \Exception('Unable to write to '.$target);
                }

                $generated[] = $target;
            } catch (\InvalidArgumentException $e) {
                // Path is invalid, likely because a config value isn't set
            }
        }

        return $generated;
    }

    public function getParsedTemplate(\SplFileInfo $file)
    {
        $contents = file_get_contents($file->getRealPath());

        if ($file->getExtension() === 'mustache') {
            $skeleton = $this->skeleton;

            $contents = preg_replace_callback($this->expression, function($matches) use ($skeleton) {
                return $skeleton->get($matches[1]);
            }, $contents);
        }

        return $contents;
    }

    public function getParsedTemplatePath(\SplFileInfo $file)
    {
        $path = $file->getRealPath();

        // Remove skeleton path
        $path = str_replace($this->source.'/', null, $path);

        // Remove mustache extension
        $path = str_replace('.mustache', null, $path);

        // Prepend destination directory
        $path = sprintf('%s/%s', $this->destination, $path);

        if (preg_match($this->expression, $path)) {
            $skeleton = $this->skeleton;

            $path = preg_replace_callback($this->expression, function($matches) use ($skeleton) {
                $value = $skeleton->get($matches[1]);

                if (null === $value) {
                    throw new \InvalidArgumentException('No value exists for '.$matches[0]);
                }

                return $value;
            }, $path);
        }

        return $path;
    }
}
