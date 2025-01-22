<?php

namespace Spatie\LaravelPackageTools\Concerns\InstallCommand;

trait AskToStarRepoOnGitHub
{
    protected ?string $starRepo = null;

    public function askToStarRepoOnGitHub($vendorSlashRepoName): self
    {
        $this->starRepo = $vendorSlashRepoName;

        return $this;
    }

    protected function processStarRepo(): self
    {
        if ($this->starRepo) {
            if ($this->confirm('Would you like to star our repo on GitHub?')) {
                $repoUrl = "https://github.com/{$this->starRepo}";

                if (PHP_OS_FAMILY == 'Darwin') {
                    exec("open {$repoUrl}");
                } elseif (PHP_OS_FAMILY == 'Windows') {
                    exec("start {$repoUrl}");
                } elseif (PHP_OS_FAMILY == 'Linux') {
                    exec("xdg-open {$repoUrl}");
                }
            }
        }

        return $this;
    }
}
