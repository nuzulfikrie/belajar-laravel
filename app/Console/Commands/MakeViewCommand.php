<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
class MakeViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    //original code
    //protected $signature = 'command:name';
    protected $signature = 'make:view {view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new blade view template';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

   /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $Filesystem = new Filesystem;
        $view = $this->argument('view');

        $path = $this->viewPath($view);

        $this->createDir($path);

        if ($Filesystem->exists($path))
        {
            $this->error("File {$path} already exists!");
            return;
        }

        if($Filesystem->put($path, $path)){

        $this->info("File {$path} created.");
        } else {
            $this->error('File failed to create');
        }

    }

     /**
     * Get the view full path.
     *
     * @param string $view
     *
     * @return string
     */
    public function viewPath($view)
    {
        $view = str_replace('.', '/', $view) . '.blade.php';

        $path = "resources/views/{$view}";

        return $path;
    }

    /**
     * Create view directory if not exists.
     *
     * @param $path
     */
    public function createDir($path)
    {
        $dir = dirname($path);

        if (!file_exists($dir))
        {
            mkdir($dir, 0777, true);
        }
    }

    public function fileExists($path):bool
    {
        if(file_exists($path)){
            return true;
        } else{
            return false;
        }
    }
}
