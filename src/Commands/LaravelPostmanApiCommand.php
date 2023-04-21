<?php

namespace Halimzidoune\LaravelPostmanApi\Commands;

use Halimzidoune\LaravelPostmanApi\Classes\Folder;
use Halimzidoune\LaravelPostmanApi\FileBuilder\PostmanCollectionBuilder;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Storage;

class LaravelPostmanApiCommand extends Command
{
    public $signature = 'routes:export
    {name : The name of the collection you want to generate}
    ';

    public $description = 'Generate a collection json file can be imported from postman';

    protected $config;

    public function __construct(Repository $config)
    {
        parent::__construct();

        $this->config = $config;
    }

    public function handle(PostmanCollectionBuilder $builder): int
    {
        $routes = \Illuminate\Support\Facades\Route::getRoutes();

        $root = new Folder('root');

        foreach ($routes as $route) {
            if(is_array($route->action['middleware'])){
                if (in_array('api', $route->action['middleware'])) {
                    $root->addRoute($route, $route->uri);
                }
            }elseif ($route->action['middleware'] == "api"){
                $root->addRoute($route, $route->uri);
            }
        }

        $structure = $builder->initPostmanStructure($this->argument('name'));

        $structure['item'] = $builder->build($root)['item'];

        $exportFolder = config('postman-api.export_folder') ?? 'postman';
        $exportFile = $exportFolder.'/'.date('Y_m_d_His_').$this->argument('name').'.json';

        Storage::disk($this->config['disk'])->put($exportFile, json_encode($structure, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->info('Collection generated successfully: '.storage_path('app/'.$exportFile));

        return self::SUCCESS;
    }
}
