<?php

Namespace Commands;

use Payday\YearPayday;
use Payday\MonthPayday;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * Represent CLI command that outputs staff paydays in a given .csv file
 * Class PaydayCommand
 * @package Commands
 */
class PaydayCommand extends Command
{

    /**
     * Set up command with its arguments
     */
    protected function configure()
    {
        $this->setName("dates:payday")
            ->setDescription("Create a .csv file with the paydays for sales staff for the remainder of the year")
            ->addArgument(
                'filename',
                InputArgument::REQUIRED,
                'Define the name of the outputted .csv file'
            );
    }

    /**
     * Execute the command if it's called
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Output file
        $outputFile = $input->getArgument('filename');

        // Check if user already added .csv extension
        if (strpos($outputFile, '.csv') === false) {
            $outputFile .= '.csv';
        }

        // Path of output folder
        try {
            $outputFolder = __DIR__ . '/../../output/';
        } catch (\Exception $e) {
            $output->writeln('<error>Could not open output folder</error>');
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return 1;
        }


        // Define headers for .csv
        $csvHeaders = array(
            array('Month', 'Salary Payday', 'Bonus Payday')
        );

        // Open file
        $csv = fopen($outputFolder . $outputFile, 'w');

        // Write headers to file
        foreach ($csvHeaders as $item) {
            fputcsv($csv, $item);
        }

        // Retrieve the remaining months for this year
        try {
            $year = new YearPayday();
            $remainingMonths = $year->getMonthsToNewYear();
        } catch (\Exception $e) {
            $output->writeln('<error>Could not determine remaining months in this year</error>');
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return 1;
        }

        // Write paydays for each of those months to file
        try {
            foreach ($remainingMonths as $month) {
                $monthPayday = new MonthPayday($month);

                $data = array(
                    array(
                        $monthPayday->getFormattedMonth(),
                        $monthPayday->getFormattedSalaryPayday(),
                        $monthPayday->getFormattedBonusPayday()
                    )
                );

                // Write to file
                foreach ($data as $item) {
                    fputcsv($csv, $item);
                }
            }
        } catch (\Exception $e) {
            $output->writeln('<error>Could not determine dates</error>');
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return 1;
        }


        // Close the file
        fclose($csv);

        // Let user know execution succeeded
        $output->writeln('<info>Successfully calculated paydays. All results in <comment>output/' . $outputFile . '</comment></info>');
        return 0;
    }
}