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
            'Nilai Agama dan Budi Pekerti' => [
                'bg' => 'warning', 'icon' => 'bi-star-fill', 'text' => '#f59e0b',
                'icon_bg' => 'linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(245, 158, 11, 0.05) 100%)',
                'card_bg' => 'rgba(245, 158, 11, 0.05)'
            ],
            'Jati Diri' => [
                'bg' => 'success', 'icon' => 'bi-person-heart', 'text' => '#10b981',
                'icon_bg' => 'linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0.05) 100%)',
                'card_bg' => 'rgba(16, 185, 129, 0.05)'
            ],
            'Dasar dasar Literasi, Matematika, sains teknologi, rekayasa dan seni' => [
                'bg' => 'primary', 'icon' => 'bi-book-heart', 'text' => '#6366f1',
                'icon_bg' => 'linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0.05) 100%)',
                'card_bg' => 'rgba(99, 102, 241, 0.05)'
            ],
        ];
    }

    /**
     * Mendapatkan label standar untuk skor penilaian 1-4 (BB, MB, BSH, BSB).
     */
    protected function getSkorLabels(): array
    {
        return [
            'BM' => ['short' => 'BM', 'full' => 'Belum Muncul', 'points' => 0, 'color' => '#ef4444'],
            'KM' => ['short' => 'KM', 'full' => 'Mulai Muncul', 'points' => 25, 'color' => '#f59e0b'],
            'M' => ['short' => 'M', 'full' => 'Muncul', 'points' => 75, 'color' => '#10b981'],
            'K' => ['short' => 'K', 'full' => 'Berkembang', 'points' => 100, 'color' => '#6366f1'],
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

    /**
     * Mendapatkan target berdasarkan usia anak.
     */
    protected function getTargetByAge(string $tanggalLahir): array
    {
        $usia = \Carbon\Carbon::parse($tanggalLahir)->age;
        
        if ($usia == 4) {
            return ['bulanan' => 65, 'semester' => 80];
        } elseif ($usia == 5) {
            return ['bulanan' => 75, 'semester' => 90];
        } elseif ($usia == 6) {
            return ['bulanan' => 85, 'semester' => 95];
        }
        
        return ['bulanan' => 65, 'semester' => 80];
    }

    /**
     * Mendapatkan keterangan naratif berdasarkan skor.
     */
    protected function getNarrativeDescription(string $skor): string
    {
        $descriptions = [
            'BM' => 'Masih membutuhkan bimbingan, baru mulai berkembang',
            'KM' => 'Masih membutuhkan bimbingan, baru mulai berkembang',
            'M' => 'Sudah berkembang sesuai harapan',
            'K' => 'Berkembang sangat baik, sudah mandiri dan lancar',
        ];
        
        return $descriptions[$skor] ?? 'Belum ada keterangan';
    }

    /**
     * Mendapatkan warna status berdasarkan persentase dan target.
     */
    protected function getStatusColor(float $persentase, float $target): array
    {
        if ($persentase < $target) {
            return ['label' => 'Belum Tercapai', 'color' => '#ef4444', 'bg' => 'bg-danger'];
        } elseif ($persentase < $target + 10) {
            return ['label' => 'Sedang Berkembang', 'color' => '#f59e0b', 'bg' => 'bg-warning'];
        }
        
        return ['label' => 'Sudah Tercapai', 'color' => '#10b981', 'bg' => 'bg-success'];
    }
}
