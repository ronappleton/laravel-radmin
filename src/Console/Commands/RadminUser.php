<?php

namespace RonAppleton\Radmin\Console\Commands;

use Illuminate\Console\Command;

class RadminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'radmin:superuser {--h|help}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Radmin super user tool.';

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
        $userModel = radmin('userModel');

        if($this->hasArgument('help'))
        {
            $this->showHelper();
        }

        //if(!empty())
    }

    public function superUser()
    {

    }

    public function showHelper()
    {

    }
}
