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

        $this->checkSuperAdminRole($roleModel);

        $this->checkForSuperUser($userModel, $roleModel);

        $this->showMainMenu();
    }

    private function checkSuperAdminRole($model)
    {
        $roles = $model->where('name', 'SuperAdmin')->get();

        if(count($roles) == 0)
        {
            $this->warn('There is no SuperAdmin role defined');
            $this->info('Creating now..');

            $model::create([
               'name' => 'SuperAdmin',
            ]);
        }
    }

    private function checkForSuperUser($userModel, $roleModel)
    {
        $users = $userModel->all();

        foreach($users as $user)
        {
            if($user->hasRole('SuperAdmin'))
            {
                $this->info('SuperAdmin Exists.');
                return true;
            }
        }

        $this->warn('No SuperAdmin exists.');
    }

    public function superUser()
    {

    }

    public function showMainMenu()
    {
        $options = [
            'Exit',
            'Show SuperAdmins',
            'Create SuperAdmin',
            'Remove SuperAdmin',
            'Alter SuperAdmin',
            'Disable 2Factor Auth',
        ];

        $choice = null;

        while(!is_numeric($choice) && !$choice > 0 && !$choice <= count($choice) || is_null($choice))
        {
            $choice = $this->choice('Please choose an option: ', $options);
        }

        if ($choice == 'Exit')
        {
            die();
        }
        else {
            $choice = str_replace(' ', '', $choice);
            $method = "option{$choice}";
            $this->$method();
        }

        $this->proceed();
    }

    private function proceed()
    {
        $options = [
            'Exit',
            'Continue',
        ];

        $choice = $this->choice('Exit or Continue: ', $options);

        if ($choice == 'Continue')
        {
            system('clear');
            $this->showMainMenu();
        }
        else {
            die();
        }
    }

    private function optionShowSuperAdmins()
    {
        $userModel = $this->getInstance('models.user');

        $users = $userModel->role('SuperAdmin');

        if(empty($users))
        {
            $this->info('No Super Admins Exist');
            $this->proceed();
        }
        else {
            foreach($users as $user)
            {
                $this->info("{$user->name} {$user->email}");
            }
        }
    }

    private function optionCreateSuperAdmin()
    {
        $userModel = $this->getInstance('models.user');

        $users = $userModel->all();

        $userNames = [];

        foreach($users as $user)
        {
            if(!$user->hasRole('SuperAdmin'))
            {
                $userNames[] = "{$user->name}-{$user->email}";
            }

        }

        $choice = $this->choice('Choose User to make SuperAdmin: ', $userNames);

        $userEmail = explode('-', $choice)[1];

        $user = $users->where('email', $userEmail)->first();

        if($user->assignRole('SuperAdmin'))
        {
            $this->info('User has been made SuperAdmin');
        }
        else {
            $this->warn('Was unable to make user SuperAdmin');
        }
    }

    private function optionRemoveSuperAdmin()
    {
        $userModel = $this->getInstance('models.user');

        $users = $userModel->hasRole('SuperAdmin');

        if(empty($users))
        {
            $this->info('No Super Admins Exist');
            $this->proceed();
        }
        else {
            $supers = [];

            foreach($users as $user)
            {
                $supers[$user->id] = "{$user->name} {$user->email}";
            }
        }

        $choice = $this->choice('Choose super user to remove: ', $supers);

        $confirm = $this->confirm('Are you sure?');

        if($confirm)
        {
            var_dump('User Chosen');
        }
    }

    private function optionAlterSuperAdmin()
    {
        var_dump('Alter Super Admin Called');
    }

    private function optionDisable2FactorAuth()
    {
        var_dump('Disable 2 Factor Auth Called');
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
