<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\CourseRequest;
use App\Models\LearningResource;
use App\Models\Mark;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class StudentController
 *
 * Handles all pages and actions specific to students. Each method returns
 * a view with the appropriate data. The routes for these actions are
 * protected by the role middleware so that only students can access them.
 */
class StudentController extends Controller
{
    /**
     * Show the student dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        // Load counts for quick stats
        $coursesCount = $user->courses()->count();
        $assignmentsCount = Assignment::whereIn('course_id', $user->courses()->pluck('courses.id'))->count();
        $quizzesCount = Quiz::whereIn('course_id', $user->courses()->pluck('courses.id'))->count();
        return view('student.dashboard', compact('user', 'coursesCount', 'assignmentsCount', 'quizzesCount'));
    }

    /**
     * Display the student's enrolled courses and allow adding new courses.
     */
    public function courses()
    {
        $user = Auth::user();
        $courses = $user->courses()->with('teacher')->get();
        $allCourses = Course::with('teacher')->get();
        $selectedCourseId = $this->currentCourseId($user, $courses);

        return view('student.courses', compact('user', 'courses', 'allCourses', 'selectedCourseId'));
    }

    /**
     * Send a course enrollment request.
     */
    public function requestCourse(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
        ]);
        $user = Auth::user();
        $courseId = $request->course_id;

        // Avoid duplicate requests or enrollments
        if ($user->courses()->where('course_id', $courseId)->exists()) {
            return back()->with('message', 'You are already enrolled in this course.');
        }
        if (CourseRequest::where('user_id', $user->id)->where('course_id', $courseId)->where('status', 'pending')->exists()) {
            return back()->with('message', 'You have already requested this course.');
        }

        CourseRequest::create([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        return back()->with('message', 'Course request sent successfully.');
    }

    /**
     * Show attendance records for the student.
     */
    public function attendance()
    {
        $user = Auth::user();
        [$selectedCourse, $redirect] = $this->requireSelectedCourse($user);
        if ($redirect) {
            return $redirect;
        }

        $attendances = Attendance::where('user_id', $user->id)
            ->where('course_id', $selectedCourse->id)
            ->with('course')
            ->orderByDesc('date')
            ->get();

        return view('student.attendance', compact('user', 'attendances', 'selectedCourse'));
    }

    /**
     * Show marks summary for the student.
     */
    public function marks()
    {
        $user = Auth::user();
        [$selectedCourse, $redirect] = $this->requireSelectedCourse($user);
        if ($redirect) {
            return $redirect;
        }

        $marks = Mark::where('user_id', $user->id)
            ->where('course_id', $selectedCourse->id)
            ->with('course')
            ->get();

        return view('student.marks', compact('user', 'marks', 'selectedCourse'));
    }

    /**
     * Show downloadable learning resources for the student's courses.
     */
    public function resources()
    {
        $user = Auth::user();
        [$selectedCourse, $redirect] = $this->requireSelectedCourse($user);
        if ($redirect) {
            return $redirect;
        }

        $resources = LearningResource::where('course_id', $selectedCourse->id)
            ->with('course', 'uploader')
            ->get();

        return view('student.resources', compact('user', 'resources', 'selectedCourse'));
    }

    /**
     * Show assignments for the student's courses and allow submission.
     */
    public function assignments()
    {
        $user = Auth::user();
        [$selectedCourse, $redirect] = $this->requireSelectedCourse($user);
        if ($redirect) {
            return $redirect;
        }

        $assignments = Assignment::where('course_id', $selectedCourse->id)
            ->with(['course', 'submissions' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->orderByDesc('due_date')
            ->get();

        return view('student.assignments', compact('user', 'assignments', 'selectedCourse'));
    }

    /**
     * Submit an assignment file.
     */
    public function submitAssignment(Request $request, Assignment $assignment): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file'],
        ]);
        $user = Auth::user();
        if ($assignment->submissions()->where('user_id', $user->id)->exists()) {
            return back()->with('message', 'You already submitted this assignment.');
        }
        // Save file to storage
        $path = $request->file('file')->store('submissions', 'public');
        // Create submission record
        \App\Models\Submission::create([
            'user_id' => $user->id,
            'assignment_id' => $assignment->id,
            'file_path' => $path,
            'submitted_at' => now(),
        ]);
        return back()->with('message', 'Assignment submitted successfully.');
    }

    /**
     * Submit a quiz file.
     */
    public function submitQuiz(Request $request, Quiz $quiz): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file'],
        ]);
        $user = Auth::user();
        if ($quiz->submissions()->where('user_id', $user->id)->exists()) {
            return back()->with('message', 'You already submitted this quiz.');
        }
        $path = $request->file('file')->store('submissions', 'public');
        \App\Models\Submission::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'file_path' => $path,
            'submitted_at' => now(),
        ]);
        return back()->with('message', 'Quiz submitted successfully.');
    }

    /**
     * Show quizzes for the student's courses and allow submission.
     */
    public function quizzes()
    {
        $user = Auth::user();
        [$selectedCourse, $redirect] = $this->requireSelectedCourse($user);
        if ($redirect) {
            return $redirect;
        }

        $quizzes = Quiz::where('course_id', $selectedCourse->id)
            ->with(['course', 'submissions' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->orderByDesc('due_date')
            ->get();

        return view('student.quizzes', compact('user', 'quizzes', 'selectedCourse'));
    }

    /**
     * Show the student's profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('student.profile', compact('user'));
    }

    /**
     * Set the active course the student wants to view.
     */
    public function selectCourse(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'course_id' => ['required', 'integer'],
        ]);

        $user = Auth::user();
        $course = $user->courses()->where('courses.id', $request->course_id)->first();

        if (! $course) {
            return back()->with('message', 'You can only select a course you are enrolled in.');
        }

        session(['selected_course_id' => $course->id]);

        return back()->with('message', 'Active course set to ' . $course->name . '.');
    }

    /**
     * Resolve the current course id from the session, ensuring it belongs to the student.
     */
    private function currentCourseId($user, $courses = null): ?int
    {
        $courses ??= $user->courses()->get();
        $selectedCourseId = session('selected_course_id');

        if ($selectedCourseId && $courses->contains('id', (int) $selectedCourseId)) {
            return (int) $selectedCourseId;
        }

        // Auto-pick when there is exactly one enrolled course
        if ($courses->count() === 1) {
            $firstCourseId = $courses->first()->id;
            session(['selected_course_id' => $firstCourseId]);
            return $firstCourseId;
        }

        return null;
    }

    /**
     * Require that a course is selected when the student has multiple courses.
     * Returns an array of [$courseModel|null, $redirectResponse|null]
     * so callers can bail out early.
     */
    private function requireSelectedCourse($user): array
    {
        $courses = $user->courses()->get();
        $courseId = $this->currentCourseId($user, $courses);

        if (! $courses->count()) {
            return [null, redirect()->route('student.courses')->with('message', 'You are not enrolled in any courses yet.')];
        }

        if (! $courseId) {
            return [null, redirect()->route('student.courses')->with('message', 'Please select a course to continue.')];
        }

        $course = $courses->firstWhere('id', $courseId);

        return [$course, null];
    }
}
