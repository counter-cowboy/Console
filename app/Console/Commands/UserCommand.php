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
    protected $description='User managing: add, list, delete {id}';

    protected function configure()
    {
        $this->setDescription('Manage users')
            ->addArgument('action', InputArgument::REQUIRED,
                'Action to perform (list, add, delete)')
            ->addArgument('id', InputArgument::OPTIONAL,
                'User ID (required for delete)');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
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

        if (!$users) {
            $output->writeln('No users found.');
            return;
        }

        $table = new Table($output);

        $table->setHeaders(['ID', 'Name', 'Email'])
            ->setRows($users);
        $table->render();
    }

    private function addUser(OutputInterface $output): void
    {
        $path = public_path('users.json');
        $users = json_decode(file_get_contents($path), true);

        $id = end($users)['id'] + 1;
        $name = fake('ru')->name();
        $email = fake('ru')->email();

        $users[] = $newUser = [
            'id' => $id,
            'name' => $name,
            'email' => $email
        ];

        file_put_contents($path, json_encode($users));

        $output->writeln('User was added successfully.');
        $output->writeln(json_encode($newUser));
    }

    private function deleteUser($id, OutputInterface $output): void
    {
        $path = public_path('users.json');

        $users = json_decode(file_get_contents($path), true);

        foreach ($users as $subKey => $subArray) {

            if ($subArray['id'] == $id) {
                unset($users[$subKey]);
            }
        }
        $users = array_values($users);

        file_put_contents($path, json_encode($users));
    }
}
