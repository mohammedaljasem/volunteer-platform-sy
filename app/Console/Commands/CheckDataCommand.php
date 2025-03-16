<?php

namespace App\Console\Commands;

use App\Models\Ad;
use App\Models\Company;
use Illuminate\Console\Command;

class CheckDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar los datos de compañías y campañas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando datos...');

        // Verificar compañías
        $companies = Company::all();
        $this->info('Compañías encontradas: ' . $companies->count());
        
        foreach ($companies as $company) {
            $this->line("ID: {$company->id}, Nombre: {$company->name}, Verificada: " . ($company->verified ? 'Sí' : 'No'));
        }

        $this->newLine();

        // Verificar campañas
        $ads = Ad::all();
        $this->info('Campañas encontradas: ' . $ads->count());
        
        foreach ($ads as $ad) {
            $this->line("ID: {$ad->id}, Título: {$ad->title}, Estado: {$ad->status}, Compañía: {$ad->company_id}");
        }

        return Command::SUCCESS;
    }
}
