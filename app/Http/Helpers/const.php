<?php

const BachelorSemesters = [
    'First Semester', 'Second Semester', 'Third Semester', 'Fourth Semester', 'Fifth Semester', 'Sixth Semester', 'Seventh Semester', 'Eighth Semester',
];
const BachelorYears = [
    'First Year', 'Second Year', 'Third Year', 'Fourth Year',
];

const MasterSemester = [
    'First Semester', 'Second Semester', 'Third Semester', 'Fourth Semester',
];
const MasterYears = [
    'First Year', 'Second Year',
];

const MONTHNAMES = [
    'Baishakh', 'Jestha', 'Ashadh', 'Shrawan', 'Bhadau', 'Asoj', 'Kartik', 'Mangsir', 'Poush', 'Magh', 'Falgun', 'Chaitra',
];

const MARITAL_STATUS_TYPES = ['Unmarried', 'Married', 'Separated', 'Widowed', 'Not specified'];
const ETHNICITY_TYPES = ['EDJ', 'Brahmin', 'Chhetri', 'Janajati', 'Dalit', 'Madhesi', 'Others'];
const BLOOD_GROUPS_TYPES = ['A+', 'A-', 'B+', 'B-', 'O+', 'AB+'];
const STAFF_SERVICE_TYPES = ['Permanent', 'Temporary', 'Contract', 'Part Timer'];
const GENDER_TYPES = ['Male', 'Female', 'Other'];

const GRIEVANCE_INFORM_TO = [
    'superadmin' => 'Charmain/Campus Chief'
];

const ACCOUNT_TYPES = [
    'Assets',
    'Liabilities',
    'Income',
    'Expenses'
];

const DEBIT_ACCOUNT_TYPES = ['Assets', 'Expenses'];
const CREDIT_ACCOUNT_TYPES = ['Liabilities', 'Equity', 'Income'];

const SKILL_GAP_MESSAGE_TO = [
    'superadmin' => 'Charmain/Campus Chief'
];

const VOUCHER_TYPES = [
    'Journal',
    'Payment',
    'Receipt',
];

// changing payment_method to enum requires update in migration as well
const PAYMENT_METHODS = [
    'Cash',
    'Bank',
];

const APPROVAL_STATUS = [
    1 => 'Approved',
    2 => 'Disapproved',
    3 => 'Pending'
];

const EXAM_ATTEMPTS = [
    0 => 'Regular',
    1 => 'Second Attempt',
    2 => 'Third Attempt',
    3 => 'Fourth Attempt',
];

const PAID_STATUS = [
    0 => 'Unpaid',
    1 => 'Paid',
    2 => 'Partially Paid'
];
