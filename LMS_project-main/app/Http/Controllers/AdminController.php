<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseProposal;
use App\Models\CourseRequest;
use App\Models\Mark;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class AdminController
 *
 * Provides administrative functions such as viewing statistics, managing users
 * and courses, and handling course requests. Only accessible by admins.
 */
class AdminController extends Controller
{
    /**
     * Show the admin dashboard with summary statistics.
     */
    public function dashboard()
    {
        $studentsCount = User::where('role', 'student')->count();
        $teachersCount = User::where('role', 'teacher')->count();
        $coursesCount = Course::count();
        // Calculate average mark percentage for quick insight
        $averageMark = Mark::avg('marks');
        return view('admin.dashboard', compact('studentsCount', 'teachersCount', 'coursesCount', 'averageMark'));
    }

    /**
     * List all users and allow deletion.
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Delete a user (student or teacher).
     */
    public function deleteUser($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        // Prevent deletion of admin account
        if ($user->role === 'admin') {
            return back()->with('message', 'Cannot delete an admin account.');
        }
        $user->delete();
        return back()->with('message', 'User deleted successfully.');
    }

    /**
     * List all courses and allow deletion.
     */
    public function courses()
    {
        $courses = Course::with('teacher')->get();
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.courses', compact('courses', 'teachers'));
    }

    /**
     * Create or update a course.
     */
    public function saveCourse(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'teacher_id' => ['required', 'exists:users,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
        ]);
        if ($validated['course_id']) {
            // Update existing course
            $course = Course::findOrFail($validated['course_id']);
            $course->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'teacher_id' => $validated['teacher_id'],
            ]);
            $message = 'Course updated successfully.';
        } else {
            // Create new course
            Course::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'teacher_id' => $validated['teacher_id'],
            ]);
            $message = 'Course created successfully.';
        }
        return redirect()->route('admin.courses')->with('message', $message);
    }

    /**
     * Delete a course.
     */
    public function deleteCourse($id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return back()->with('message', 'Course deleted successfully.');
    }

    /**
     * Display course enrollment requests for approval or rejection.
     */
    public function courseRequests()
    {
        $requests = CourseRequest::with('student', 'course')->orderBy('status')->get();
        return view('admin.course_requests', compact('requests'));
    }

    /**
     * Approve a course request.
     */
    public function approveRequest($id): RedirectResponse
    {
        $request = CourseRequest::findOrFail($id);
        $request->update(['status' => 'approved']);
        // Enroll student in the course
        $request->student->courses()->attach($request->course_id, ['status' => 'approved']);
        return back()->with('message', 'Course request approved.');
    }

    /**
     * Reject a course request.
     */
    public function rejectRequest($id): RedirectResponse
    {
        $request = CourseRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);
        return back()->with('message', 'Course request rejected.');
    }

    /**
     * Show teacher course proposals for admin approval.
     */
    public function courseProposals()
    {
        $proposals = CourseProposal::with('teacher', 'course')->latest()->get();
        return view('admin.course_proposals', compact('proposals'));
    }

    /**
     * Approve a course proposal and create the course.
     */
    public function approveCourseProposal($id, Request $request): RedirectResponse
    {
        $proposal = CourseProposal::findOrFail($id);
        if ($proposal->status === 'approved') {
            return back()->with('message', 'This proposal is already approved.');
        }

        $validated = $request->validate([
            'admin_note' => ['nullable', 'string'],
        ]);

        // Create a course if it does not exist yet and link it.
        $course = $proposal->course ?: Course::create([
            'name' => $proposal->title,
            'description' => $proposal->description,
            'teacher_id' => $proposal->teacher_id,
        ]);

        $proposal->update([
            'status' => 'approved',
            'admin_note' => $validated['admin_note'] ?? null,
            'course_id' => $course->id,
        ]);

        return back()->with('message', 'Course proposal approved and course created.');
    }

    /**
     * Reject a course proposal.
     */
    public function rejectCourseProposal($id, Request $request): RedirectResponse
    {
        $proposal = CourseProposal::findOrFail($id);
        $validated = $request->validate([
            'admin_note' => ['nullable', 'string'],
        ]);

        $proposal->update([
            'status' => 'rejected',
            'admin_note' => $validated['admin_note'] ?? null,
        ]);

        return back()->with('message', 'Course proposal rejected.');
    }
}
