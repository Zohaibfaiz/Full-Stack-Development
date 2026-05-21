<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\CourseProposal;
use App\Models\LearningResource;
use App\Models\Mark;
use App\Models\Quiz;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Class TeacherController
 *
 * Provides pages and actions for teachers to manage courses, assignments,
 * quizzes, resources, attendance and marks. Protected by role middleware.
 */
class TeacherController extends Controller
{
    /**
     * Show the teacher's dashboard with quick stats.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $courses = $user->taughtCourses()->withCount(['assignments', 'quizzes', 'resources'])->get();
        return view('teacher.dashboard', compact('user', 'courses'));
    }

    /**
     * Display courses taught by the teacher.
     */
    public function courses()
    {
        $user = Auth::user();
        $courses = $user->taughtCourses()->with('students')->get();
        return view('teacher.courses', compact('user', 'courses'));
    }

    /**
     * Show existing course proposals and allow the teacher to submit a new one.
     */
    public function courseRequests()
    {
        $proposals = Auth::user()->courseProposals()->latest()->get();
        return view('teacher.course_requests', compact('proposals'));
    }

    /**
     * Submit a course proposal for admin approval.
     */
    public function storeCourseRequest(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        CourseProposal::create([
            'teacher_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        return redirect()->route('teacher.course-requests')->with('message', 'Course request sent to admin for approval.');
    }

    /**
     * Show form for uploading a learning resource.
     */
    public function createResource()
    {
        $courses = Auth::user()->taughtCourses()->get();
        return view('teacher.create_resource', compact('courses'));
    }

    /**
     * Store a new learning resource.
     */
    public function storeResource(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file' => ['required', 'file'],
        ]);
        $path = $request->file('file')->store('resources', 'public');

        LearningResource::create([
            'course_id' => $validated['course_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $path,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('teacher.resources')->with('message', 'Resource uploaded successfully.');
    }

    /**
     * List learning resources uploaded for the teacher's courses.
     */
    public function resources()
    {
        $user = Auth::user();
        $resources = LearningResource::whereIn('course_id', $user->taughtCourses()->pluck('id'))
            ->with('course')
            ->get();
        return view('teacher.resources', compact('user', 'resources'));
    }

    /**
     * Show form to create an assignment.
     */
    public function createAssignment()
    {
        $courses = Auth::user()->taughtCourses()->get();
        return view('teacher.create_assignment', compact('courses'));
    }

    /**
     * Store a new assignment.
     */
    public function storeAssignment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file'],
            'due_date' => ['nullable', 'date'],
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('assignments', 'public');
        }

        Assignment::create([
            'course_id' => $validated['course_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $path,
            'due_date' => $validated['due_date'],
        ]);

        return redirect()->route('teacher.assignments')->with('message', 'Assignment created successfully.');
    }

    /**
     * List assignments for the teacher's courses.
     */
    public function assignments()
    {
        $user = Auth::user();
        $assignments = Assignment::whereIn('course_id', $user->taughtCourses()->pluck('id'))
            ->with('course')
            ->orderByDesc('created_at')
            ->get();
        return view('teacher.assignments', compact('user', 'assignments'));
    }

    /**
     * Show form to create a quiz.
     */
    public function createQuiz()
    {
        $courses = Auth::user()->taughtCourses()->get();
        return view('teacher.create_quiz', compact('courses'));
    }

    /**
     * Store a new quiz.
     */
    public function storeQuiz(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file'],
            'due_date' => ['nullable', 'date'],
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('quizzes', 'public');
        }

        Quiz::create([
            'course_id' => $validated['course_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $path,
            'due_date' => $validated['due_date'],
        ]);

        return redirect()->route('teacher.quizzes')->with('message', 'Quiz created successfully.');
    }

    /**
     * List quizzes for the teacher's courses.
     */
    public function quizzes()
    {
        $user = Auth::user();
        $quizzes = Quiz::whereIn('course_id', $user->taughtCourses()->pluck('id'))
            ->with('course')
            ->orderByDesc('created_at')
            ->get();
        return view('teacher.quizzes', compact('user', 'quizzes'));
    }

    /**
     * Display student submissions for assignments and quizzes.
     */
    public function submissions()
    {
        $user = Auth::user();
        $submissions = Submission::whereHas('assignment', function ($query) use ($user) {
            $query->whereIn('course_id', $user->taughtCourses()->pluck('id'));
        })->orWhereHas('quiz', function ($query) use ($user) {
            $query->whereIn('course_id', $user->taughtCourses()->pluck('id'));
        })->with(['student', 'assignment.course', 'quiz.course'])->get();
        return view('teacher.submissions', compact('user', 'submissions'));
    }

    /**
     * Show and record attendance for courses.
     */
    public function attendance(Request $request)
    {
        $user = Auth::user();
        $courses = $user->taughtCourses()->with('students')->get();

        // Save attendance if POST
        if ($request->isMethod('post')) {
            $request->validate([
                'course_id' => ['required', 'exists:courses,id'],
                'date' => ['required', 'date'],
                'attendance' => ['required', 'array'],
            ]);
            foreach ($request->attendance as $studentId => $status) {
                Attendance::updateOrCreate(
                    [
                        'user_id' => $studentId,
                        'course_id' => $request->course_id,
                        'date' => $request->date,
                    ],
                    ['status' => $status]
                );
            }
            return redirect()->back()->with('message', 'Attendance recorded successfully.');
        }

        return view('teacher.attendance', compact('courses'));
    }

    /**
     * Display and assign marks to students.
     */
    public function marks(Request $request)
    {
        $user = Auth::user();
        $courses = $user->taughtCourses()->with('students')->get();
        if ($request->isMethod('post')) {
            $request->validate([
                'course_id' => ['required', 'exists:courses,id'],
                'marks' => ['required', 'array'],
            ]);
            foreach ($request->marks as $studentId => $mark) {
                Mark::updateOrCreate(
                    [
                        'user_id' => $studentId,
                        'course_id' => $request->course_id,
                    ],
                    [
                        'marks' => $mark,
                    ]
                );
            }
            return redirect()->back()->with('message', 'Marks updated successfully.');
        }
        return view('teacher.marks', compact('courses'));
    }
}
