-- 2023-08-11
alter table `homework` drop `report`;

-- 2023-08-12
alter table `homework_submissions` drop `file`;

-- 2023-08-24
alter table `school_settings` add `calendar_type` enum('en', 'np') not null default 'np', add `date_format` varchar(20) not null default 'YYYY-mm-dd';
alter table `school_settings` drop `logo`;

-- 2023-08-25
create table `academic_calendars` (`id` bigint unsigned not null auto_increment primary key, `title` varchar(255) not null, `date` date not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- 2023-09-07
alter table `exams` drop foreign key `exams_session_id_foreign`;
alter table `exams` drop `session_id`;

-- 2023-10-01 (fix:service types text variations)
UPDATE `staff_directories` SET `service_type`='Permanent' WHERE `service_type`='permanent' or `service_type`='Full Time';
UPDATE `staff_directories` SET `service_type`='Temporary' WHERE `service_type`='temporary';
UPDATE `staff_directories` SET `service_type`='Contract' WHERE `service_type`='contract';
UPDATE `staff_directories` SET `service_type`='Part Timer' WHERE `service_type`='Part Time' or `service_type`='Part-Timer' or `service_type`='part-timer' or `service_type`='part-time';

-- 2023-10-02 (fix:ethnicity types text variations)
UPDATE `students` SET `ethnicity`='Chhetri' WHERE `ethnicity`='Chhetri ';
UPDATE `staff_directories` SET `ethnicity`='Janajati' WHERE `ethnicity`='Janjati';
UPDATE `staff_directories` SET `ethnicity`='Others' WHERE `ethnicity`='Other';

-- 2023-10-10
ALTER TABLE non_credits CHANGE tole tole VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ward ward VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`