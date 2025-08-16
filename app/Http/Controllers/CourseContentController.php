<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Chapter;
use App\Models\QuizQuestion;

class CourseContentController extends Controller
{
    /**
     * Get course content by slug for frontend consumption
     */
    public function getCourseContent($slug)
    {
        $course = Course::where('slug', $slug)->first();
        
        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        $chapters = $course->activeChapters()->with(['quizQuestions' => function($query) {
            $query->where('is_active', true)->orderBy('order_index');
        }])->get();

        $courseContent = $chapters->map(function($chapter) {
            return [
                'title' => $chapter->title,
                'videoId' => $chapter->video_id,
                'summary' => $chapter->summary ?? [],
                'quizByDifficulty' => [
                    'easy' => $this->formatQuizQuestions($chapter->getQuizByDifficulty('easy')),
                    'medium' => $this->formatQuizQuestions($chapter->getQuizByDifficulty('medium')),
                    'hard' => $this->formatQuizQuestions($chapter->getQuizByDifficulty('hard'))
                ],
                // Fallback quiz format for compatibility
                'quiz' => $this->formatQuizQuestions($chapter->quizQuestions)
            ];
        });

        return response()->json($courseContent);
    }

    /**
     * Format quiz questions for frontend consumption
     */
    private function formatQuizQuestions($questions)
    {
        return $questions->map(function($question) {
            return [
                'q' => $question->question,
                'options' => $question->options,
                'ans' => $question->correct_answer_index
            ];
        })->toArray();
    }

    /**
     * Get all available courses with their slugs
     */
    public function getAvailableCourses()
    {
        $courses = Course::whereHas('activeChapters')
            ->select('id', 'title', 'slug', 'description')
            ->get();

        return response()->json($courses);
    }
}
