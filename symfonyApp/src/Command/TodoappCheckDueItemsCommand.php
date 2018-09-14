<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Todo;

class TodoappCheckDueItemsCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'todoapp:check-due-items';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $em = $this->getContainer()->get('doctrine')->getManager();

        $todos = $em->getRepository(Todo::class)->findBy(array('notificationSent' => false));
        $output->writeln("List of todos");
        $today = new \DateTime();
        foreach ($todos as $t)
        {
            $output->writeln("Description: " . $t->getDescription() . ", due: " . $t->getDueDate()->format('d.m.Y'));

            if($t->getDueDate() < $today)
            {
                $email = new \SendGrid\Mail\Mail();

                $output->writeln("to: " . $t->getOwner()->getEmail());

                $email->setFrom("lasse.haverinen@gmail.com", "Todo app reminder");
                $email->setSubject("Todo reminder email");
                $email->addTo($t->getOwner()->getEmail(), "Test User");
                $email->addContent("text/plain", "Plain text content of the email");

                $content = $this->getContainer()->get('twig')->render('emails/notification.html.twig', array('description' => $t->getDescription(), 'dueDate' => $t->getDueDate()->format('d.m.Y')));
                $email->addContent("text/html", $content);

                $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
                try {
                    $response = $sendgrid->send($email);
                    if($response->statusCode() != 202) //202 Accepted
                    {
                        $output->writeln("status " . $response->statusCode());
                        $output->writeln($response->headers());
                        $output->writeln($response->body());
                    }
                } catch (Exception $e) {
                    $output->writeln("Exception");
                    $output->writeln('Caught exception: '. $e->getMessage());
                }
            }
        }
    }
}
