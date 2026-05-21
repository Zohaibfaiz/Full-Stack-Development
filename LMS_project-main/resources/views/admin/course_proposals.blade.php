@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <p class="text-muted text-uppercase fw-semibold small mb-1">Course Management</p>
        <h3 class="mb-0">Teacher Course Proposals</h3>
        <p class="text-muted small mb-0">Review new course ideas from teachers and approve or reject them.</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back to dashboard</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Teacher</th>
                        <th>Status</th>
                        <th>Admin note</th>
                        <th>Linked course</th>
                        <th>Submitted</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proposals as $proposal)
                        <tr>
                            <td class="fw-semibold">{{ $proposal->title }}</td>
                            <td>{{ $proposal->teacher?->name ?? '—' }}</td>
                            <td>
                                <span class="badge @if($proposal->status === 'approved') bg-success-subtle text-success @elseif($proposal->status === 'rejected') bg-danger-subtle text-danger @else bg-warning-subtle text-dark @endif">
                                    {{ ucfirst($proposal->status) }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $proposal->admin_note ?? '—' }}</td>
                            <td class="text-muted small">
                                {{ $proposal->course?->name ?? 'Not created yet' }}
                            </td>
                            <td class="text-muted small">{{ $proposal->created_at?->format('M d, Y') }}</td>
                            <td class="text-end">
                                @if($proposal->status === 'pending')
                                    <form method="POST" action="{{ route('admin.course.proposals.approve', $proposal->id) }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="admin_note" value="">
                                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.course.proposals.reject', $proposal->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                    </form>
                                @else
                                    <span class="text-muted small">No actions</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No course proposals found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
