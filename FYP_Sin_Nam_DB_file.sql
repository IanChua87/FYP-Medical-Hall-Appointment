-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema fyp_sin_nam
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema fyp_sin_nam
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `fyp_sin_nam` DEFAULT CHARACTER SET utf8mb3 ;
USE `fyp_sin_nam` ;

-- -----------------------------------------------------
-- Table `fyp_sin_nam`.`patient`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fyp_sin_nam`.`patient` (
  `patient_id` INT NOT NULL AUTO_INCREMENT,
  `patient_name` VARCHAR(255) NOT NULL,
  `patient_dob` DATE NOT NULL,
  `patient_phoneNo` INT NOT NULL,
  `patient_email` VARCHAR(255) NOT NULL,
  `patient_password` VARCHAR(255) NOT NULL,
  `patient_status` VARCHAR(45) NOT NULL DEFAULT 'NEW',
  `last_updated_by` VARCHAR(45) NOT NULL,
  `last_updated_datetime` DATETIME NOT NULL,
  `payment_status` VARCHAR(45) NOT NULL DEFAULT '50.00',
  `amount_payable` FLOAT NOT NULL DEFAULT '50',
  `is_verified` TINYINT NOT NULL DEFAULT '0',
  PRIMARY KEY (`patient_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 22
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `fyp_sin_nam`.`appointment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fyp_sin_nam`.`appointment` (
  `appointment_id` INT NOT NULL AUTO_INCREMENT,
  `appointment_date` DATE NOT NULL,
  `appointment_start_time` TIME NOT NULL,
  `appointment_end_time` TIME NOT NULL,
  `appointment_status` VARCHAR(45) NOT NULL DEFAULT 'UPCOMING',
  `booked_by` VARCHAR(255) NOT NULL,
  `booked_datetime` DATETIME NOT NULL,
  `queue_no` INT NOT NULL,
  `appointment_remarks` VARCHAR(255) NULL DEFAULT NULL,
  `patient_id` INT NOT NULL,
  PRIMARY KEY (`appointment_id`),
  INDEX `fk_appointment_patient1_idx` (`patient_id` ASC) VISIBLE,
  CONSTRAINT `fk_appointment_patient1`
    FOREIGN KEY (`patient_id`)
    REFERENCES `fyp_sin_nam`.`patient` (`patient_id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 66
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `fyp_sin_nam`.`contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fyp_sin_nam`.`contact` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `message` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `fyp_sin_nam`.`holiday`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fyp_sin_nam`.`holiday` (
  `holiday_id` INT NOT NULL AUTO_INCREMENT,
  `holiday_name` VARCHAR(255) NOT NULL,
  `holiday_date` DATE NOT NULL,
  PRIMARY KEY (`holiday_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `fyp_sin_nam`.`relation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fyp_sin_nam`.`relation` (
  `relation_id` INT NOT NULL AUTO_INCREMENT,
  `relation_name` VARCHAR(255) NOT NULL,
  `appointment_id` INT NOT NULL,
  PRIMARY KEY (`relation_id`),
  INDEX `fk_relation_appointment1_idx` (`appointment_id` ASC) VISIBLE,
  CONSTRAINT `fk_relation_appointment1`
    FOREIGN KEY (`appointment_id`)
    REFERENCES `fyp_sin_nam`.`appointment` (`appointment_id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `fyp_sin_nam`.`settings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fyp_sin_nam`.`settings` (
  `settings_id` INT NOT NULL AUTO_INCREMENT,
  `settings_key` VARCHAR(255) NOT NULL,
  `settings_value` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`settings_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `fyp_sin_nam`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fyp_sin_nam`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(255) NOT NULL,
  `user_email` VARCHAR(255) NOT NULL,
  `user_password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8mb3;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
