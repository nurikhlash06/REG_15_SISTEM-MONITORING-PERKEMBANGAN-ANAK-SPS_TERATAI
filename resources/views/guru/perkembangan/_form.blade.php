<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Murid</label>
        <select name="murid_id" class="form-select @error('murid_id') is-invalid @enderror" required>
            <option value="">- pilih murid -</option>
            @foreach($murid as $m)
                <option value="{{ $m->id }}"
                    @selected(old('murid_id', $selectedMuridId ?? (($perkembangan ?? null)?->murid_id ?? '')) == $m->id)
                >
                    {{ $m->nama_lengkap }}
                </option>
            @endforeach
        </select>
        @error('murid_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Tanggal</label>
        <input
            type="date"
            name="tanggal"
            value="{{ old('tanggal', ($perkembangan ?? null)?->tanggal?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
            class="form-control @error('tanggal') is-invalid @enderror"
            required
        >
        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Aspek</label>
        <select name="aspek" class="form-select @error('aspek') is-invalid @enderror" required>
            <option value="">- pilih aspek -</option>
            @foreach($aspekOptions as $opt)
                <option value="{{ $opt }}" @selected(old('aspek', ($perkembangan ?? null)?->aspek ?? ($selectedAspek ?? '')) === $opt)>
                    {{ $opt }}
                </option>
            @endforeach
        </select>
        @error('aspek') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Penilaian (Skor)</label>
        <select name="skor" class="form-select @error('skor') is-invalid @enderror" required>
            <option value="1" @selected(old('skor', ($perkembangan ?? null)?->skor ?? '') == 1)>BB (Belum Berkembang)</option>
            <option value="2" @selected(old('skor', ($perkembangan ?? null)?->skor ?? '') == 2)>MB (Mulai Berkembang)</option>
            <option value="3" @selected(old('skor', ($perkembangan ?? null)?->skor ?? '') == 3)>BSH (Berkembang Sesuai Harapan)</option>
            <option value="4" @selected(old('skor', ($perkembangan ?? null)?->skor ?? '') == 4)>BSB (Berkembang Sangat Baik)</option>
        </select>
        @error('skor') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Catatan</label>
        <textarea
            name="catatan"
            rows="5"
            class="form-control @error('catatan') is-invalid @enderror"
            required
        >{{ old('catatan', ($perkembangan ?? null)?->catatan ?? '') }}</textarea>
        @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
