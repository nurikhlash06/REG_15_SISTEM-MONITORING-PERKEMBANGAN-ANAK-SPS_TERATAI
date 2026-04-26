<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasAspekStyles
{
    /**
     * Mendapatkan pemetaan warna dan ikon untuk aspek perkembangan.
     *
     * @return array
     */
    protected function getColorMap(): array
    {
        return [
            'Nilai Agama/Moral' => [
                'bg' => 'warning', 'icon' => 'bi-star-fill', 'text' => '#f59e0b',
                'icon_bg' => 'linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(245, 158, 11, 0.05) 100%)',
                'card_bg' => 'rgba(245, 158, 11, 0.05)'
            ],
            'Fisik-Motorik' => [
                'bg' => 'success', 'icon' => 'bi-bicycle', 'text' => '#10b981',
                'icon_bg' => 'linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0.05) 100%)',
                'card_bg' => 'rgba(16, 185, 129, 0.05)'
            ],
            'Kognitif' => [
                'bg' => 'info', 'icon' => 'bi-lightbulb-fill', 'text' => '#0ea5e9',
                'icon_bg' => 'linear-gradient(135deg, rgba(14, 165, 233, 0.2) 0%, rgba(14, 165, 233, 0.05) 100%)',
                'card_bg' => 'rgba(14, 165, 233, 0.05)'
            ],
            'Bahasa' => [
                'bg' => 'primary', 'icon' => 'bi-chat-left-text-fill', 'text' => '#6366f1',
                'icon_bg' => 'linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0.05) 100%)',
                'card_bg' => 'rgba(99, 102, 241, 0.05)'
            ],
            'Sosial-Emosional' => [
                'bg' => 'danger', 'icon' => 'bi-people-fill', 'text' => '#ef4444',
                'icon_bg' => 'linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(239, 68, 68, 0.05) 100%)',
                'card_bg' => 'rgba(239, 68, 68, 0.05)'
            ],
            'Seni' => [
                'bg' => 'pink', 'icon' => 'bi-palette-fill', 'text' => '#d946ef',
                'icon_bg' => 'linear-gradient(135deg, rgba(217, 70, 239, 0.2) 0%, rgba(217, 70, 239, 0.05) 100%)',
                'card_bg' => 'rgba(217, 70, 239, 0.05)'
            ],
        ];
    }

    /**
     * Mendapatkan label standar untuk skor penilaian 1-4 (BB, MB, BSH, BSB).
     */
    protected function getSkorLabels(): array
    {
        return [
            1 => ['short' => 'BB', 'full' => 'Belum Berkembang', 'color' => '#ef4444'],
            2 => ['short' => 'MB', 'full' => 'Mulai Berkembang', 'color' => '#f59e0b'],
            3 => ['short' => 'BSH', 'full' => 'Berkembang Sesuai Harapan', 'color' => '#10b981'],
            4 => ['short' => 'BSB', 'full' => 'Berkembang Sangat Baik', 'color' => '#6366f1'],
        ];
    }

    /**
     * Mendapatkan label status dan warna berdasarkan persentase capaian.
     */
    protected function getStatusInfo(int $percent): array
    {
        if ($percent == 0) return ['label' => 'Belum Ada', 'color' => '#94a3b8', 'bg' => 'bg-secondary'];
        if ($percent < 50) return ['label' => 'Perlu Perhatian', 'color' => '#ef4444', 'bg' => 'bg-danger'];
        if ($percent <= 69) return ['label' => 'Perlu Stimulasi', 'color' => '#f59e0b', 'bg' => 'bg-warning'];
        if ($percent <= 89) return ['label' => 'Baik', 'color' => '#10b981', 'bg' => 'bg-success'];
        return ['label' => 'Sangat Baik', 'color' => '#6366f1', 'bg' => 'bg-primary'];
    }

    /**
     * Menghasilkan gaya CSS dinamis untuk tampilan ikon dan kartu aspek.
     *
     * @param array $aspekOptions
     * @param string $prefix
     * @return string
     */
    protected function generateDynamicStyles(array $aspekOptions, string $prefix = 'aspek'): string
    {
        $colorMap = $this->getColorMap();
        $dynamicStyles = '';
        
        foreach ($aspekOptions as $opt) {
            $styles = $colorMap[$opt] ?? [
                'bg' => 'secondary', 'icon' => 'bi-circle', 'text' => '#64748b',
                'icon_bg' => '#f1f5f9', 'card_bg' => '#f8fafc'
            ];
            
            $slug = Str::slug($opt);
            $dynamicStyles .= ".{$prefix}-icon-{$slug} { background: {$styles['icon_bg']} !important; color: {$styles['text']} !important; }";
            $dynamicStyles .= ".{$prefix}-card-{$slug} { background-color: {$styles['card_bg']} !important; }";
        }
        
        return $dynamicStyles;
    }
}
