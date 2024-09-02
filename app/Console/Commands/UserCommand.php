<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'app:user-command';

    protected static $defaultName = 'user:manage';

    protected function configure()
    {
        $this->setDescription('Manage users')
            ->addArgument('action', InputArgument::REQUIRED,
                'Action to perform(list, add, delete)')
            ->addArgument('id', InputArgument::OPTIONAL,
                'User ID (required for delete)');
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $action = $input->getArgument('action');

        switch ($action) {
            case 'list':
                $this->listUsers($output);
                break;
            case 'add':
                $this->addUser($output);
                break;
            case 'delete':
                $this->deleteUser($input->getArgument('id'), $output);
                break;

            default:
                $output->writeln('Unknown command.');

        }
        return 0;
    }


    private function listUsers(OutputInterface $output): void
    {
        $path = public_path('users.json');

        $users = json_decode(file_get_contents($path), true);
//        dd($users);

        if (!$users) {
            $output->writeln('No users found.');
            return;
        }

        $table = new Table($output);

        foreach ($users as $user) {
            dd($user['name']);
            $table->setHeaders(['ID', 'Name', 'Email']);
            $output->write($user['id'].' '. $user['name']. ' '. $user['email']);

        }

    }

    private function addUser(OutputInterface $output)
    {
        $path = public_path('users.json');
        $users = json_decode(file_get_contents($path), true);

        $id = sizeof($users) + 1;
        $name = Str::random(10);
        $email = Str::random(8) . 'example.com';

        $users[] = [
            'id' => $id,
            'name' => $name,
            'email' => $email
        ];
        file_put_contents($path, json_encode($users));

        $output->writeln('User was added successfully.');
        $output->writeln(json_encode([
            'id' => $id,
            'name' => $name,
            'email' => $email
        ]));
    }

    private function deleteUser($id, OutputInterface $output)
    {

    }


}
