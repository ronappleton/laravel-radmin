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
        $userModel = $this->getInstance('models.user');
        $roleModel = $this->getInstance('models.role');

        dd($userModel);


        if ($this->hasArgument('help')) {
            $this->showHelper();
        }

        $this->showMainmenu();
    }

    public function superUser()
    {

    }

    public function showHelper()
    {

    }

    public function showMainMenu()
    {
        $options = [
            'Show SuperUsers',
            'Create SuperUser',
            'Remove SuperUser',
            'Alter SuperUser',
            'Disable 2Factor Auth',
            'Help',
        ];

        $index = 0;

        for($i = 0; $i <= count($options); $i++)
        {
            $this->info("[{$i}] {$options[$i]}");
        }

        $choice = null;

        while(!is_numeric($choice) && !$choice > 0 && !$choice <= count($choice))
        {
            $this->choice('Please choose an option: ');
        }


    }

    private function getUserModel($userModel)
    {

    }

    private function getClass($name)
    {
        $class = radmin("classes.{$name}");

        if (empty($class)) {
            $this->info("Unable to get class from classes.{$name} in radmin.php config file.");
            die();
        }
        return $class;
    }

    private function getInstance($name)
    {
        $class = $this->getClass($name);

        if (!class_exists($class)) {
            $this->info("Unable to create class {$class} as the class could not be found.");
            die();
        }

        return new $class;
    }
}
