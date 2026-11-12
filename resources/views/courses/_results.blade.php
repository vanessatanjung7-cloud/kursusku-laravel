@forelse ($courses as $course)
    <tr>
        <td><span class="text-secondary small">{{ $course->code }}</span><br><strong>{{ $course->name }}</strong></td>
        <td>Rp {{ number_format($course->fee, 0, ',', '.') }}</td>
        <td>{{ $course->quota }}</td>
        <td>{{ $course->start_date->format('d M Y') }}</td>
        <td><span class="badge text-bg-{{ $course->status === 'open' ? 'success' : ($course->status === 'closed' ? 'secondary' : 'warning') }}">{{ ucfirst($course->status) }}</span></td>
        <td class="text-end">
            <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-primary">Detail</a>
            <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline-success">Edit</a>
        </td>
    </tr>
@empty
    <tr><td colspan="6" class="text-center text-secondary py-5">Tidak ada kursus yang cocok dengan pencarian.</td></tr>
@endforelse
