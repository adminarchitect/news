<?php

namespace Terranet\News\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Composer;

class NewsTableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'news:tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the news database tables';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Illuminate\Foundation\Composer
     */
    protected $composer;

    /**
     * Create a new session table command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     * @param  \Illuminate\Foundation\Composer $composer
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $fullPath = $this->createBaseMigration();

        $this->files->put(
            $fullPath,
            $this->files->get(__DIR__ . '/stubs/news.stub')
        );

        $this->info('News tables created successfully!');

        $this->composer->dumpAutoloads();
    }

    /**
     * Create a base migration file for the session.
     *
     * @return string
     */
    protected function createBaseMigration()
    {
        $name = 'create_news_tables';

        $path = $this->laravel->databasePath() . '/migrations';

        return $this->laravel['migration.creator']->create($name, $path);
    }
}
