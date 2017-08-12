<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeComponent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vue:component {file_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a basic vue component file';

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
        $file_name = $this->argument('file_name');
        $full_path = "resources/assets/js/components/".$file_name. ".vue";

        if(file_exists($full_path)){
            $this->error("Component already exists!");
        }else{
            $this->line("Creating a new component ". $file_name );
            $component = fopen( $full_path, "w+");
            fwrite($component, $this->content());
            $this->info("A new component file created!");
        }
    }

    private function content(){
        return \Illuminate\Support\Facades\Storage::get('Component.stub');
    }
}
