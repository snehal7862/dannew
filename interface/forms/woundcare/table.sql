--
-- Table structure for table `form_care_plan`
--

CREATE TABLE IF NOT EXISTS `form_woundcare` (
    `id` bigint(20) NOT NULL,
    `date` DATE DEFAULT NULL,
    `pid` bigint(20) DEFAULT NULL,
    `encounter` varchar(255) DEFAULT NULL,
    `user` varchar(255) DEFAULT NULL,
    `groupname` varchar(255) DEFAULT NULL,
    `authorized` tinyint(4) DEFAULT NULL,
    `activity` tinyint(4) DEFAULT NULL,
    `json_data` text
    ) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `form_woundcare_templates` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `template_name` text DEFAULT NULL,
    `template_hip` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `template_current_medication` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `template_medical_history` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `template_allergies_intolerance` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `template_surgical_history_hospitalization` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `template_social_history` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `template_family_history` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `template_ros` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `template_chief_complaint` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `form_woundcare_physical_exam` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `physical_exam_name` varchar(255) DEFAULT NULL,
    `physical_exam_general` text DEFAULT NULL,
    `physical_exam_head` varchar(255) DEFAULT NULL,
    `physical_exam_eyes` varchar(255) DEFAULT NULL,
    `physical_exam_nose` varchar(255) DEFAULT NULL,
    `physical_exam_throat` varchar(255) DEFAULT NULL,
    `physical_exam_ears` varchar(255) DEFAULT NULL,
    `physical_exam_oral_cavity` varchar(255) DEFAULT NULL,
    `physical_exam_neck` varchar(255) DEFAULT NULL,
    `physical_exam_skin` varchar(255) DEFAULT NULL,
    `physical_exam_lungs` varchar(255) DEFAULT NULL,
    `physical_exam_abdomen` varchar(255) DEFAULT NULL,
    `physical_exam_extremities` varchar(255) DEFAULT NULL,
    `physical_exam_heart` varchar(255) DEFAULT NULL,
    `physical_exam_back` varchar(255) DEFAULT NULL,
    `physical_exam_pelvic` varchar(255) DEFAULT NULL,
    `physical_exam_breast` varchar(255) DEFAULT NULL,
    `physical_exam_genitourinary` varchar(255) DEFAULT NULL,
    `physical_exam_neurologic` varchar(255) DEFAULT NULL,
    `physical_exam_musculoskeletal` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB;

--
-- Table structure for table `form_care_plan`
--

CREATE TABLE IF NOT EXISTS `form_wound_care` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `pid` bigint(20) NOT NULL DEFAULT 0,
    `groupname` varchar(255) DEFAULT NULL,
    `user` varchar(255) DEFAULT NULL,
    `authorized` tinyint(4) NOT NULL DEFAULT 0,
    `activity` tinyint(4) NOT NULL DEFAULT 0,
    `date` DATE DEFAULT NULL,
    `encounter` bigint(20) NOT NULL DEFAULT 0,
    `get_date` DATE DEFAULT NULL,
    `copy_date` DATE DEFAULT NULL,
    `wc_complaint` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `wc_hpi` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `wc_current_medication` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `medical_history` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `wc_allergies` varchar(255) DEFAULT NULL,
    `wc_surgical_history` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `wc_social` varchar(255) DEFAULT NULL,
    `wc_family` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `wc_ros` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `wc_vitals` varchar(255) DEFAULT NULL,
    `wc_t` varchar(255) DEFAULT NULL,
    `wc_p` varchar(255) DEFAULT NULL,
    `wc_hr` varchar(255) DEFAULT NULL,
    `wc_systolic` varchar(255) DEFAULT NULL,
    `wc_diastolic` varchar(255) DEFAULT NULL,
    `wc_bp` varchar(255) DEFAULT NULL,
    `wc_ht` varchar(255) DEFAULT NULL,
    `wc_wt` varchar(255) DEFAULT NULL,
    `wc_bmi` varchar(255) DEFAULT NULL,
    `wc_general` varchar(255) DEFAULT NULL,
    `wc_head` varchar(255) DEFAULT NULL,
    `wc_eyes` varchar(255) DEFAULT NULL,
    `wc_nose` varchar(255) DEFAULT NULL,
    `wc_throat` varchar(255) DEFAULT NULL,
    `wc_ears` varchar(255) DEFAULT NULL,
    `wc_oral` varchar(255) DEFAULT NULL,
    `wc_heart` varchar(255) DEFAULT NULL,
    `wc_neck` varchar(255) DEFAULT NULL,
    `wc_skin` varchar(255) DEFAULT NULL,
    `wc_lungs` varchar(255) DEFAULT NULL,
    `wc_abdomen` varchar(255) DEFAULT NULL,
    `wc_back` varchar(255) DEFAULT NULL,
    `wc_extremities` varchar(255) DEFAULT NULL,
    `wc_pelvic` varchar(255) DEFAULT NULL,
    `wc_breast` varchar(255) DEFAULT NULL,
    `wc_genitourinary` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `wc_neurologic` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `wc_musculoskeletal` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `location_get` varchar(255) DEFAULT NULL,
    `problem_get` varchar(255) DEFAULT NULL,
    `is_edit` INT DEFAULT 0,
    `edited_by` INT DEFAULT NULL,
    `medimedscribeNote` LONGTEXT DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `form_wound_problem` (
    `id` bigint(20) NOT NULL,
    `dr_description` varchar(255) DEFAULT NULL,
    `dr_location` varchar(255) DEFAULT NULL,
    `dr_plan` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
    `icd_10` varchar(255) DEFAULT NULL,
    `dr_medication` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB;

ALTER TABLE `form_wound_problem` ADD COLUMN IF NOT EXISTS `pid` INT DEFAULT NULL AFTER `id`;
ALTER TABLE `form_wound_problem` ADD COLUMN IF NOT EXISTS `groupname` VARCHAR(255) DEFAULT NULL AFTER `pid`;
ALTER TABLE `form_wound_problem` ADD COLUMN IF NOT EXISTS `user` VARCHAR(255) DEFAULT NULL AFTER `groupname`;
ALTER TABLE `form_wound_problem` ADD COLUMN IF NOT EXISTS `authorized` VARCHAR(255) DEFAULT NULL AFTER `user`;
ALTER TABLE `form_wound_problem` ADD COLUMN IF NOT EXISTS `activity` VARCHAR(255) DEFAULT NULL AFTER `authorized`;
ALTER TABLE `form_wound_problem` ADD COLUMN IF NOT EXISTS `date` DATE DEFAULT NULL AFTER `activity`;




CREATE TABLE IF NOT EXISTS `form_dermitology_treatment` (`id` bigint(20) NOT NULL, `dr_procdure_notes` LONGTEXT NULL DEFAULT NULL, `dr_additional_notes` LONGTEXT NULL DEFAULT NULL, `wc_cpt_code` varchar(255) DEFAULT NULL, `pid` INT DEFAULT NULL, `groupname` VARCHAR(255) DEFAULT NULL, `user` VARCHAR(255) DEFAULT NULL, `authorized` VARCHAR(255) DEFAULT NULL, `activity` VARCHAR(255) DEFAULT NULL, `date` DATE DEFAULT NULL, `wound_id` INT DEFAULT NULL, PRIMARY KEY (`id`));




CREATE TABLE IF NOT EXISTS `form_wound_treatment` (`id` bigint(20) NOT NULL, `wc_procdure_notes` LONGTEXT NULL DEFAULT NULL, `wc_additional_notes` LONGTEXT NULL DEFAULT NULL, `wc_cpt_code` varchar(255) DEFAULT NULL, `pid` INT DEFAULT NULL, `groupname` VARCHAR(255) DEFAULT NULL, `user` VARCHAR(255) DEFAULT NULL, `authorized` VARCHAR(255) DEFAULT NULL, `activity` VARCHAR(255) DEFAULT NULL, `date` DATE DEFAULT NULL, `wound_id` INT DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB;




CREATE TABLE IF NOT EXISTS `cpt_codes` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `cpt_code` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB;


--
-- Table structure for table `form_care_plan`
--

CREATE TABLE IF NOT EXISTS `form_wound_template` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `wound_template_name` varchar(255) DEFAULT NULL,
    `template_side` varchar(255) DEFAULT NULL,
    `template_anatomical_action` varchar(255) DEFAULT NULL,
    `template_location` varchar(255) DEFAULT NULL,
    `template_wound_type` varchar(255) DEFAULT NULL,
    `template_wound_thickness` varchar(255) DEFAULT NULL,
    `template_drainage_amount` varchar(255) DEFAULT NULL,
    `template_drainage_description` varchar(255) DEFAULT NULL,
    `template_debrided_surgically_created` varchar(255) DEFAULT NULL,
    `template_undermining` varchar(50) DEFAULT NULL,
    `template_tunneling` varchar(50) DEFAULT NULL,
    `template_ordo` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB;



--
-- Table structure for table `form_dermatology`
--


CREATE TABLE IF NOT EXISTS `form_dermatology` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `template_name` varchar(255) DEFAULT NULL,
    `description` LONGTEXT NULL DEFAULT NULL,
    `location` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS `assessment_template` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `assessment_name` varchar(255) DEFAULT NULL,
    `ICD_10` json DEFAULT NULL,
    `plan` text DEFAULT NULL,
    `medication` varchar(255) DEFAULT NULL,
    `assessment_type` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB;



-- form treatment notes ttable

CREATE TABLE IF NOT EXISTS `form_treatment_note` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `template` varchar(255) DEFAULT NULL,
    `treatment_procedure_note` LONGTEXT NULL DEFAULT NULL,
    `treatment_additional_note` LONGTEXT NULL DEFAULT NULL,
    `treatment_cpt_code` text DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB;



-- form woundcare location table 

CREATE TABLE IF NOT EXISTS `form_wound_location` (
    `id` bigint(20) NOT NULL,
    `wound_id` int(20) NOT NULL,
    `wc_side` varchar(20) DEFAULT NULL,
    `wc_anatomical` varchar(20) DEFAULT NULL,
    `wc_location` varchar(20) DEFAULT NULL,
    `wc_wound_type` varchar(20) DEFAULT NULL,
    `wc_thickness` varchar(20) DEFAULT NULL,
    `wc_drainage_amount` varchar(20) DEFAULT NULL,
    `wc_drainage_description` varchar(20) DEFAULT NULL,
    `wc_surgically` varchar(20) DEFAULT NULL,
    `wc_undermining` varchar(20) DEFAULT NULL,
    `wc_tunneling` varchar(20) DEFAULT NULL,
    `wc_ordo` varchar(20) DEFAULT NULL,
    `wc_signs1` varchar(20) DEFAULT NULL,
    `wc_signs2` varchar(20) DEFAULT NULL,
    `wc_surfacearea` varchar(20) DEFAULT NULL,
    `wc_volume` varchar(20) DEFAULT NULL,
    `wc_assessment_diagnosis1` varchar(20) DEFAULT NULL,
    `wc_plan` varchar(255) DEFAULT NULL,
    `wc_medication` LONGTEXT NULL DEFAULT NULL,
    `pid` INT DEFAULT NULL,
    `groupname` VARCHAR(255) DEFAULT NULL,
    `user` VARCHAR(255) DEFAULT NULL,
    `authorized` VARCHAR(255) DEFAULT NULL,
    `activity` VARCHAR(255) DEFAULT NULL,
    `date` DATE DEFAULT NULL,
    `wc_length` VARCHAR(255) DEFAULT NULL,
    `wc_width` VARCHAR(255) DEFAULT NULL,
    `wc_depth` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY(`id`)
    ) ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS `icd_codes` (
    `id` bigint(20) NOT NULL,
    `icd_code` LONGTEXT DEFAULT NULL,
    `icd_name` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB;

