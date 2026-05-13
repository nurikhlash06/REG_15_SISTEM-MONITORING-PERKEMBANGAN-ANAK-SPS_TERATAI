<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Nama Lengkap</label>
        <input
            type="text"
            name="nama_lengkap"
            value="{{ old('nama_lengkap', $murid->nama_lengkap ?? '') }}"
            class="form-control @error('nama_lengkap') is-invalid @enderror"
            required
        >
        @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
            <option value="">- pilih -</option>
            <option value="L" @selected(old('jenis_kelamin', $murid->jenis_kelamin ?? '') === 'L')>L</option>
            <option value="P" @selected(old('jenis_kelamin', $murid->jenis_kelamin ?? '') === 'P')>P</option>
        </select>
        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Tanggal Lahir</label>
        <input
            type="date"
            name="tanggal_lahir"
            value="{{ old('tanggal_lahir', isset($murid?->tanggal_lahir) ? $murid->tanggal_lahir->format('Y-m-d') : '') }}"
            class="form-control @error('tanggal_lahir') is-invalid @enderror"
        >
        @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">NIK (16 Digit)</label>
        <input
            type="text"
            name="nik"
            value="{{ old('nik', $murid->nik ?? '') }}"
            class="form-control @error('nik') is-invalid @enderror"
            placeholder="Masukkan 16 digit NIK"
            maxlength="16"
        >
        @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">NISN (10 Digit)</label>
        <input
            type="text"
            name="nisn"
            value="{{ old('nisn', $murid->nisn ?? '') }}"
            class="form-control @error('nisn') is-invalid @enderror"
            placeholder="Masukkan 10 digit NISN"
            maxlength="10"
        >
        @error('nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Kelas</label>
        <select name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
            <option value="">- pilih kelas -</option>
            @foreach($kelas as $k)
                <option value="{{ $k->id }}" @selected(old('kelas_id', $murid->kelas_id ?? '') == $k->id)>
                    {{ $k->nama_kelas }} ({{ $k->kode_kelas }})
                </option>
            @endforeach
        </select>
        @error('kelas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Data Fisik Murid -->
    <div class="col-md-4">
        <label class="form-label">Berat Badan (kg)</label>
        <div class="input-group">
            <input
                type="number"
                step="0.1"
                name="berat_badan"
                value="{{ old('berat_badan', $murid->berat_badan ?? '') }}"
                class="form-control @error('berat_badan') is-invalid @enderror"
                placeholder="0.0"
            >
            <span class="input-group-text">kg</span>
            @error('berat_badan') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">Tinggi Badan (cm)</label>
        <div class="input-group">
            <input
                type="number"
                step="0.1"
                name="tinggi_badan"
                value="{{ old('tinggi_badan', $murid->tinggi_badan ?? '') }}"
                class="form-control @error('tinggi_badan') is-invalid @enderror"
                placeholder="0.0"
            >
            <span class="input-group-text">cm</span>
            @error('tinggi_badan') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">Lingkar Kepala (cm)</label>
        <div class="input-group">
            <input
                type="number"
                step="0.1"
                name="lingkar_kepala"
                value="{{ old('lingkar_kepala', $murid->lingkar_kepala ?? '') }}"
                class="form-control @error('lingkar_kepala') is-invalid @enderror"
                placeholder="0.0"
            >
            <span class="input-group-text">cm</span>
            @error('lingkar_kepala') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Nama Orang Tua / Wali</label>
        <input
            type="text"
            name="nama_orang_tua"
            value="{{ old('nama_orang_tua', $murid->nama_orang_tua ?? '') }}"
            class="form-control @error('nama_orang_tua') is-invalid @enderror"
            placeholder="Nama ayah atau ibu"
            required
        >
        @error('nama_orang_tua') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Email Orang Tua (untuk login)</label>
        <input
            type="email"
            name="email_orang_tua"
            value="{{ old('email_orang_tua', $murid->email_orang_tua ?? '') }}"
            class="form-control @error('email_orang_tua') is-invalid @enderror"
            placeholder="contoh@email.com"
        >
        @error('email_orang_tua') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Alamat</label>
        <textarea
            name="alamat"
            rows="2"
            class="form-control @error('alamat') is-invalid @enderror"
            placeholder="Alamat lengkap tempat tinggal"
        >{{ old('alamat', $murid->alamat ?? '') }}</textarea>
        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Foto Murid (opsional)</label>
        <input
            type="file"
            name="foto"
            accept="image/*"
            class="form-control @error('foto') is-invalid @enderror"
        >
        @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @isset($murid->foto)
            <div class="mt-2">
                <img src="{{ asset('storage/'.$murid->foto) }}" alt="Foto {{ $murid->nama_lengkap }}" class="img-thumbnail shadow-sm" style="max-height: 120px;">
            </div>
        @endisset
    </div>
</div>
