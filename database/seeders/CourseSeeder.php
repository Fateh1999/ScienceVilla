<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Physics Course
        $physics = Course::create([
            'title' => 'Advanced Physics',
            'description' => 'Master the fundamentals of physics with interactive lessons and practical examples.',
            'slug' => 'advanced-physics',
            'image_url' => '/images/physics-course.jpg',
            'level' => 'intermediate',
            'duration_hours' => 40,
            'price' => 99.99,
            'countries' => ['in', 'uk', 'us', 'ca', 'au'],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Physics Lessons
        $physicsLessons = [
            [
                'title' => 'Introduction to Mechanics',
                'description' => 'Learn the basic principles of motion and forces.',
                'slug' => 'introduction-to-mechanics',
                'content' => '<h2>Introduction to Mechanics</h2><p>Mechanics is the branch of physics that deals with motion and forces...</p>',
                'duration_minutes' => 45,
                'sort_order' => 1,
            ],
            [
                'title' => 'Newton\'s Laws of Motion',
                'description' => 'Understanding the three fundamental laws of motion.',
                'slug' => 'newtons-laws-of-motion',
                'content' => '<h2>Newton\'s Laws of Motion</h2><p>Sir Isaac Newton formulated three laws that describe the relationship between forces and motion...</p>',
                'duration_minutes' => 60,
                'sort_order' => 2,
            ],
            [
                'title' => 'Energy and Work',
                'description' => 'Explore the concepts of kinetic and potential energy.',
                'slug' => 'energy-and-work',
                'content' => '<h2>Energy and Work</h2><p>Energy is the capacity to do work. In this lesson, we\'ll explore different forms of energy...</p>',
                'duration_minutes' => 50,
                'sort_order' => 3,
            ],
        ];

        foreach ($physicsLessons as $lessonData) {
            $lesson = $physics->lessons()->create($lessonData);
            
            // Add a quiz for each lesson
            Quiz::create([
                'lesson_id' => $lesson->id,
                'title' => $lesson->title . ' Quiz',
                'description' => 'Test your understanding of ' . $lesson->title,
                'questions' => [
                    [
                        'question' => 'What is the first law of motion?',
                        'options' => [
                            'An object at rest stays at rest',
                            'Force equals mass times acceleration',
                            'For every action there is an equal and opposite reaction',
                            'Energy cannot be created or destroyed'
                        ],
                        'correct_answer' => 0
                    ],
                    [
                        'question' => 'What is the unit of force?',
                        'options' => ['Joule', 'Newton', 'Watt', 'Pascal'],
                        'correct_answer' => 1
                    ]
                ],
                'passing_score' => 70,
                'time_limit_minutes' => 10,
            ]);
        }

        // Chemistry Course
        $chemistry = Course::create([
            'title' => 'Organic Chemistry Fundamentals',
            'description' => 'Dive deep into the world of organic compounds and reactions.',
            'slug' => 'organic-chemistry-fundamentals',
            'image_url' => '/images/chemistry-course.jpg',
            'level' => 'advanced',
            'duration_hours' => 35,
            'price' => 89.99,
            'countries' => ['in', 'uk', 'us', 'ca', 'au'],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // Chemistry Lessons
        $chemistryLessons = [
            [
                'title' => 'Introduction to Organic Chemistry',
                'description' => 'Basic concepts and terminology in organic chemistry.',
                'slug' => 'introduction-to-organic-chemistry',
                'content' => '<h2>Introduction to Organic Chemistry</h2><p>Organic chemistry is the study of carbon-containing compounds...</p>',
                'duration_minutes' => 40,
                'sort_order' => 1,
            ],
            [
                'title' => 'Hydrocarbons and Functional Groups',
                'description' => 'Understanding different types of organic compounds.',
                'slug' => 'hydrocarbons-and-functional-groups',
                'content' => '<h2>Hydrocarbons and Functional Groups</h2><p>Hydrocarbons are compounds containing only carbon and hydrogen...</p>',
                'duration_minutes' => 55,
                'sort_order' => 2,
            ],
        ];

        foreach ($chemistryLessons as $lessonData) {
            $lesson = $chemistry->lessons()->create($lessonData);
            
            Quiz::create([
                'lesson_id' => $lesson->id,
                'title' => $lesson->title . ' Quiz',
                'description' => 'Test your understanding of ' . $lesson->title,
                'questions' => [
                    [
                        'question' => 'What element is the basis of organic chemistry?',
                        'options' => ['Hydrogen', 'Oxygen', 'Carbon', 'Nitrogen'],
                        'correct_answer' => 2
                    ]
                ],
                'passing_score' => 70,
                'time_limit_minutes' => 5,
            ]);
        }

        // Mathematics Course
        $math = Course::create([
            'title' => 'Calculus Mastery',
            'description' => 'Master differential and integral calculus with step-by-step guidance.',
            'slug' => 'calculus-mastery',
            'image_url' => '/images/math-course.jpg',
            'level' => 'advanced',
            'duration_hours' => 50,
            'price' => 79.99,
            'countries' => ['in', 'uk', 'us', 'ca', 'au'],
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // Math Lessons
        $mathLessons = [
            [
                'title' => 'Limits and Continuity',
                'description' => 'Understanding the foundation of calculus.',
                'slug' => 'limits-and-continuity',
                'content' => '<h2>Limits and Continuity</h2><p>The concept of limits is fundamental to calculus...</p>',
                'duration_minutes' => 65,
                'sort_order' => 1,
            ],
            [
                'title' => 'Derivatives',
                'description' => 'Learn how to find rates of change.',
                'slug' => 'derivatives',
                'content' => '<h2>Derivatives</h2><p>A derivative represents the rate of change of a function...</p>',
                'duration_minutes' => 70,
                'sort_order' => 2,
            ],
        ];

        foreach ($mathLessons as $lessonData) {
            $lesson = $math->lessons()->create($lessonData);
            
            Quiz::create([
                'lesson_id' => $lesson->id,
                'title' => $lesson->title . ' Quiz',
                'description' => 'Test your understanding of ' . $lesson->title,
                'questions' => [
                    [
                        'question' => 'What does a derivative measure?',
                        'options' => ['Area under curve', 'Rate of change', 'Maximum value', 'Average value'],
                        'correct_answer' => 1
                    ]
                ],
                'passing_score' => 70,
                'time_limit_minutes' => 8,
            ]);
        }
    }
}
