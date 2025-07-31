// Global course content registry
// Keyed by slug generated in courses page (lowercase, non-alnum → -)
// Each course has an array of chapter objects: { title, videoId, quiz: [{q,options,ans}], summary: [string] }

window.COURSE_CONTENT = {
  // Class 8 Maths – CBSE
  'class-8-maths-cbse': [
    {
      title: 'Rational Numbers',
      videoId: 'n2lJZg9gJJo',
      quiz: [
        { q: 'Additive identity of rational numbers is …', options: ['1', '0', '-1'], ans: 1 },
        { q: 'Reciprocal of 5/3 is …', options: ['3/5', '5/3', '-5/3'], ans: 0 },
        { q: 'Property (a/b)+(c/d)=(c/d)+(a/b) is …', options: ['Associative', 'Commutative', 'Distributive'], ans: 1 }
      ],
      summary: [
        'Definition of rational numbers',
        'Closure, commutative & associative properties',
        'Additive and multiplicative identities'
      ]
    },
    {
      title: 'Linear Equations in One Variable',
      videoId: 'x0a3KxBD8J4',
      quiz: [
        { q: 'Solution of 4x + 3 = 15 is …', options: ['x=3', 'x=5', 'x=12'], ans: 0 },
        { q: 'Transposing a term means …', options: ['Changing its sign', 'Squaring it', 'Eliminating it'], ans: 0 },
        { q: 'Equation 2(x-4)=0 gives …', options: ['x=4', 'x=-4', 'x=0'], ans: 0 }
      ],
      summary: [
        'Standard form of a linear equation',
        'Solving by transposition and balancing',
        'Applications in word problems'
      ]
    },
    {
      title: 'Understanding Quadrilaterals',
      videoId: 'GpYFVK8vLJo',
      quiz: [
        { q: 'Sum of interior angles of a quadrilateral?', options: ['180°', '360°', '270°'], ans: 1 },
        { q: 'A square is a …', options: ['Rhombus', 'Rectangle', 'Both A & B'], ans: 2 },
        { q: 'Diagonals of a rectangle are …', options: ['Equal', 'Unequal', 'Perpendicular'], ans: 0 }
      ],
      summary: [
        'Types of quadrilaterals',
        'Angle-sum property',
        'Special quadrilaterals characteristics'
      ]
    }
  ],

  // Class 8 Maths – ICSE
  'class-8-maths-icse': [
    {
      title: 'Rational Numbers',
      videoId: 'n2lJZg9gJJo',
      quiz: [
        { q: 'Which is a rational number?', options: ['√2', '3/4', 'π'], ans: 1 },
        { q: 'Additive inverse of -5/7 is?', options: ['5/7', '-7/5', '7/5'], ans: 0 }
      ],
      summary: [
        { text: 'Properties of rational numbers', img: '/images/classroom.jpg' },
        { text: 'Operations on rational numbers', img: '' },
        { text: 'Representation on number line', img: '' }
      ]
    },
    {
      title: 'Linear Equations',
      videoId: 'x0a3KxBD8J4',
      quiz: [
        { q: 'Solution of 3x + 7 = 22 is?', options: ['x=5', 'x=3', 'x=7'], ans: 0 },
        { q: 'Which is a linear equation?', options: ['x² + 2 = 0', '3x + 5 = 0', 'x³ = 8'], ans: 1 }
      ],
      summary: [
        { text: 'Standard form of linear equations', img: '' },
        { text: 'Solving linear equations', img: '' },
        { text: 'Word problems involving linear equations', img: '' }
      ]
    }
  ],

  // Class 8 Science – CBSE
  'class-8-science-cbse': [
    {
      title: 'Crop Production and Management',
      videoId: 'dQw4w9WgXcQ',
      quiz: [
        { q: 'Which is a Kharif crop?', options: ['Wheat', 'Rice', 'Mustard'], ans: 1 },
        { q: 'Process of loosening soil is called?', options: ['Tilling', 'Sowing', 'Harvesting'], ans: 0 }
      ],
      summary: [
        'Types of crops - Kharif and Rabi',
        'Agricultural practices and tools',
        'Modern farming methods'
      ]
    },
    {
      title: 'Microorganisms',
      videoId: 'abc123def45',
      quiz: [
        { q: 'Which microorganism causes malaria?', options: ['Bacteria', 'Virus', 'Protozoa'], ans: 2 },
        { q: 'Yeast is used in making?', options: ['Bread', 'Curd', 'Cheese'], ans: 0 }
      ],
      summary: [
        'Types of microorganisms',
        'Beneficial and harmful microorganisms',
        'Food preservation methods'
      ]
    }
  ],

  // Class 9 Maths – CBSE
  'class-9-maths-cbse': [
    {
      title: 'Number Systems',
      videoId: 'xyz789abc12',
      quiz: [
        { q: 'Which is an irrational number?', options: ['√4', '√9', '√2'], ans: 2 },
        { q: 'Decimal expansion of 1/3 is?', options: ['Terminating', 'Non-terminating repeating', 'Non-terminating non-repeating'], ans: 1 }
      ],
      summary: [
        'Rational and irrational numbers',
        'Real numbers and their properties',
        'Operations on real numbers'
      ]
    },
    {
      title: 'Polynomials',
      videoId: 'pol123nom45',
      quiz: [
        { q: 'Degree of polynomial 3x² + 2x + 1 is?', options: ['1', '2', '3'], ans: 1 },
        { q: 'Zero of polynomial x - 5 is?', options: ['5', '-5', '0'], ans: 0 }
      ],
      summary: [
        'Definition and types of polynomials',
        'Zeros of polynomials',
        'Remainder theorem and factor theorem'
      ]
    }
  ],

  // Class 9 Science – ICSE
  'class-9-science-icse': [
    {
      title: 'Matter in Our Surroundings',
      videoId: 'mat123ter45',
      quiz: [
        { q: 'At what temperature does water boil?', options: ['90°C', '100°C', '110°C'], ans: 1 },
        { q: 'Which state of matter has definite shape?', options: ['Solid', 'Liquid', 'Gas'], ans: 0 }
      ],
      summary: [
        'States of matter and their properties',
        'Change of state and temperature',
        'Evaporation and factors affecting it'
      ]
    },
    {
      title: 'Is Matter Around Us Pure',
      videoId: 'pur123mat45',
      quiz: [
        { q: 'Which is a pure substance?', options: ['Air', 'Water', 'Milk'], ans: 1 },
        { q: 'Salt can be separated from water by?', options: ['Filtration', 'Evaporation', 'Decantation'], ans: 1 }
      ],
      summary: [
        'Pure substances and mixtures',
        'Types of mixtures - homogeneous and heterogeneous',
        'Methods of separation of mixtures'
      ]
    }
  ],

  // Year 8 Maths – AQA (UK)
  'year-8-maths-aqa': [
    {
      title: 'Algebra Basics',
      videoId: 'alg123bra45',
      quiz: [
        { q: 'Simplify 3x + 2x', options: ['5x', '6x', '5x²'], ans: 0 },
        { q: 'What is x if 2x = 10?', options: ['5', '20', '12'], ans: 0 }
      ],
      summary: [
        'Introduction to algebraic expressions',
        'Simplifying expressions',
        'Solving simple equations'
      ]
    }
  ],

  // Grade 8 Maths – Common Core (US)
  'grade-8-maths-common-core': [
    {
      title: 'Linear Functions',
      videoId: 'lin123fun45',
      quiz: [
        { q: 'What is the slope of y = 2x + 3?', options: ['2', '3', '5'], ans: 0 },
        { q: 'Which represents a linear function?', options: ['y = x²', 'y = 3x + 1', 'y = 1/x'], ans: 1 }
      ],
      summary: [
        'Understanding linear functions',
        'Slope and y-intercept',
        'Graphing linear equations'
      ]
    }
  ]
};
