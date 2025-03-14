<?php

namespace App\Exports;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use App\Models\Presenca;

class PresencasExport
{
    protected $eventoId;

    public function __construct($eventoId)
    {
        $this->eventoId = $eventoId;
    }

    public function export()
    {
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser('presencas_' . str_replace(' ', '_', Presenca::where('evento_id', $this->eventoId)->first()->evento->nome) . '.xlsx');

        // Cabeçalhos
        $headers = [
            'ID', 'Nome', 'E-mail', 'Número de Contato', 'Forma de Pagamento',
            'Status do Pagamento', 'Status de Presença', 'Dias de Presença', 'Confirmado', 'Data de Confirmação'
        ];
        $writer->addRow(WriterEntityFactory::createRowFromArray($headers));

        // Dados
        $presencas = Presenca::where('evento_id', $this->eventoId)->get();
        foreach ($presencas as $presenca) {
            $row = [
                $presenca->id,
                $presenca->nome,
                $presenca->email,
                $presenca->contact_number ?? 'Não informado',
                $presenca->payment_method ? ucfirst($presenca->payment_method) : 'Não informado',
                $presenca->payment_status ? ucfirst($presenca->payment_status) : 'Não informado',
                $presenca->attendance_status ? ucfirst($presenca->attendance_status) : 'Não informado',
                $this->formatAttendanceDays($presenca->attendance_days, $presenca->evento),
                $presenca->confirmado ? 'Sim' : 'Não',
                $presenca->created_at ? $presenca->created_at->format('d/m/Y H:i') : 'Não informado',
            ];
            $writer->addRow(WriterEntityFactory::createRowFromArray($row));
        }

        $writer->close();
        exit;
    }

    private function formatAttendanceDays($attendanceDays, $evento)
    {
        if (!$attendanceDays) {
            return 'Não informado';
        }

        $days = [];
        foreach ($attendanceDays as $dayId) {
            $day = $evento->dias->where('id', $dayId)->first();
            if ($day) {
                $days[] = $day->data->format('d/m/Y') . ' - ' . $day->hora_inicio . ' às ' . $day->hora_fim;
            }
        }
        return implode('; ', $days);
    }
}