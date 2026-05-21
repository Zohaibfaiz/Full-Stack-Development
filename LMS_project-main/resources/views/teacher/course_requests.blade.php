@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <p class="text-muted text-uppercase fw-semibold small mb-1">Courses</p>
        <h3 class="mb-0">Course Requests</h3>
        <p class="text-muted small mb-0">Propose a new course and track its approval status.</p>
    </div>
    <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back to dashboard</a>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Submit a new course request</h5>
                <form method="POST" action="{{ route('teacher.course-requests.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Course title</label>
                        <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
                        @error('title')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" placeholder="What will this course cover?">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send to admin</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0">Your requests</h5>
                    <span class="badge bg-secondary-subtle text-secondary">{{ $proposals->count() }} total</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Admin note</th>
                                <th>Linked course</th>
                                <th>Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proposals as $proposal)
                                <tr>
                                    <td class="fw-semibold">{{ $proposal->title }}</td>
                                    <td>
                                        <span class="badge @if($proposal->status === 'approved') bg-success-subtle text-success @elseif($proposal->status === 'rejected') bg-danger-subtle text-danger @else bg-warning-subtle text-dark @endif">
                                            {{ ucfirst($proposal->status) }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $proposal->admin_note ?? '—' }}</td>
                                    <td class="text-muted small">
                                        {{ $proposal->course?->name ?? 'Pending' }}
                                    </td>
                                    <td class="text-muted small">{{ $proposal->created_at?->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted text-center">No course requests yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
