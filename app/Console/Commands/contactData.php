<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contact;

class contactData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:contact';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user contact to database';

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
        //contact.csv
        $CSVFile = public_path('contact.csv');
        if(!file_exists($CSVFile) || !is_readable($CSVFile))
            return false;

        $header = null;
        $data = array();

        if (($handle = fopen($CSVFile,'r')) !== false){
            while (($row = fgetcsv($handle, 1000, ',')) !==false){
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        $dataCount = count($data);
        for ($i = 0; $i < $dataCount; $i ++){
            Contact::firstOrCreate($data[$i]);
        }
        echo "Contacts added successfully"."\n";
    }
}
