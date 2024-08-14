const DEFAULT_SELECT = '<option value="">Select</option>';
const ALL_SELECT = '<option value="">All</option>';
const DEFAULT_ERROR_MESSAGE = 'Sorry, Something went wrong!';

const STUDENT_STATUS_TYPES = Object.freeze({
  ACTIVE: 1,
  DROPPED: 2,
  TRANSFERRED: 3,
  ALUMNI: 4,
  OTHERS: 5,
});

const COURSE_TYPES = Object.freeze({
  YEAR: 'year',
  PRACTICAL: 'semester',
});

const YEAR_NUMBERS = Object.freeze({
  'First Year': 1,
  'Second Year': 2,
  'Third Year': 3,
  'Fourth Year': 4,
});

const SEMESTER_NUMBERS = Object.freeze({
  'First Semester': 1,
  'Second Semester': 2,
  'Third Semester': 3,
  'Fourth Semester': 4,
  'Fifth Semester': 5,
  'Sixth Semester': 6,
  'Seventh Semester': 7,
  'Eighth Semester': 8,
});

const SUBJECT_TYPES = Object.freeze({
  THEORY_PRACTICAL: 'has_theory_practical',
  THEORY: 'is_theory',
  PRACTICAL: 'is_practical',
});
