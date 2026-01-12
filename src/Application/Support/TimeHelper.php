<?php

namespace Src\Application\Support;

class TimeHelper
{
    /**
     * Formata minutos decimais em formato legível "X minuto(s) Y segundo(s)"
     */
    public static function formatMinutesAndSeconds(float $minutes): string
    {
        // Calcula minutos e segundos
        $totalMinutes = (int) floor($minutes);
        $seconds = (int) round(($minutes - $totalMinutes) * 60);

        // Se os segundos chegarem a 60, adiciona 1 minuto
        if ($seconds >= 60) {
            $totalMinutes++;
            $seconds = 0;
        }

        // Monta a string formatada
        $result = [];
        
        if ($totalMinutes > 0) {
            $result[] = $totalMinutes . ' minuto' . ($totalMinutes > 1 ? 's' : '');
        }
        
        if ($seconds > 0) {
            $result[] = $seconds . ' segundo' . ($seconds > 1 ? 's' : '');
        }

        return implode(' e ', $result) ?: '0 segundos';
    }
}
