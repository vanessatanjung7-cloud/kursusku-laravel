<div class="row g-3">
    <div class="col-md-6">
        <label for="code" class="form-label">Kode kursus</label>
        <input id="code" name="code" maxlength="20" required value="{{ old('code', $course->code ?? '') }}" class="form-control @error('code') is-invalid @enderror">
        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="name" class="form-label">Nama kursus</label>
        <input id="name" name="name" maxlength="120" required value="{{ old('name', $course->name ?? '') }}" class="form-control @error('name') is-invalid @enderror">
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea id="description" name="description" rows="4" maxlength="2000" class="form-control @error('description') is-invalid @enderror">{{ old('description', $course->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="fee" class="form-label">Biaya (Rp)</label>
        <input id="fee" type="number" min="0" step="1" name="fee" required value="{{ old('fee', $course->fee ?? '') }}" class="form-control @error('fee') is-invalid @enderror">
        @error('fee')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="quota" class="form-label">Kuota</label>
        <input id="quota" type="number" min="1" max="500" step="1" name="quota" required value="{{ old('quota', $course->quota ?? '') }}" class="form-control @error('quota') is-invalid @enderror">
        @error('quota')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="start_date" class="form-label">Tanggal mulai</label>
        <input id="start_date" type="date" name="start_date" required value="{{ old('start_date', isset($course) ? $course->start_date?->format('Y-m-d') : '') }}" class="form-control @error('start_date') is-invalid @enderror">
        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" required class="form-select @error('status') is-invalid @enderror">
            <option value="">Pilih status</option>
            @foreach (['draft' => 'Draft', 'open' => 'Dibuka', 'closed' => 'Ditutup'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $course->status ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
