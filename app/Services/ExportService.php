<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;

class ExportService
{
    protected $privacyFields = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes'
    ];
    
    public function export($modelClass, $format = 'csv', $fields = [], $filters = [], $options = [])
    {
        $query = $modelClass::query();
        
        // Appliquer les filtres
        foreach ($filters as $field => $value) {
            if ($value !== null) {
                $query->where($field, $value);
            }
        }
        
        // Récupérer les données
        $data = $query->get();
        
        // Filtrer les champs si spécifiés
        if (!empty($fields)) {
            $data = $data->map(function ($item) use ($fields) {
                return collect($item->toArray())->only($fields)->all();
            });
        }
        
        // Supprimer les champs sensibles
        $data = $this->removePrivacyFields($data);
        
        // Anonymiser si demandé
        if ($options['anonymize'] ?? false) {
            $data = $this->anonymizeData($data);
        }
        
        // Exporter selon le format
        switch ($format) {
            case 'pdf':
                return $this->exportPdf($data, $modelClass);
            case 'excel':
                return $this->exportExcel($data, $modelClass);
            case 'csv':
            default:
                return $this->exportCsv($data, $modelClass);
        }
    }
    
    protected function removePrivacyFields($data)
    {
        return $data->map(function ($item) {
            return collect($item)->except($this->privacyFields)->all();
        });
    }
    
    protected function anonymizeData($data)
    {
        return $data->map(function ($item, $index) {
            $item = collect($item);
            
            // Anonymiser les champs sensibles
            if ($item->has('email')) {
                $item['email'] = 'user' . ($index + 1) . '@example.com';
            }
            
            if ($item->has('telephone')) {
                $item['telephone'] = '***-***-' . substr($item['telephone'], -4);
            }
            
            if ($item->has('nom')) {
                $item['nom'] = 'Membre ' . ($index + 1);
            }
            
            if ($item->has('prenom')) {
                $item['prenom'] = 'Anonyme';
            }
            
            if ($item->has('adresse')) {
                $item['adresse'] = '*** Rue Anonyme';
            }
            
            return $item->all();
        });
    }
    
    protected function exportPdf($data, $modelClass)
    {
        $modelName = class_basename($modelClass);
        $timestamp = now()->format('Y-m-d_H-i-s');
        
        $pdf = PDF::loadView('exports.pdf', [
            'data' => $data,
            'title' => "Export {$modelName}",
            'date' => now()->format('d/m/Y H:i'),
            'fields' => $data->first() ? array_keys($data->first()) : []
        ]);
        
        return $pdf->download("export_{$modelName}_{$timestamp}.pdf");
    }
    
    protected function exportExcel($data, $modelClass)
    {
        $modelName = class_basename($modelClass);
        $timestamp = now()->format('Y-m-d_H-i-s');
        
        return Excel::download(
            new GenericExport($data),
            "export_{$modelName}_{$timestamp}.xlsx"
        );
    }
    
    protected function exportCsv($data, $modelClass)
    {
        $modelName = class_basename($modelClass);
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "export_{$modelName}_{$timestamp}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            
            // En-têtes
            if ($data->isNotEmpty()) {
                fputcsv($file, array_keys($data->first()));
            }
            
            // Données
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
