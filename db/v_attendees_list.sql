SELECT a.id,
       a.training_program_id,
       b.trainee_code,
       FormatTraineeId(b.trainee_code,b.dealer_id,b.dealer_category) trainee_id,
       FormatFirstNameFirst(b.first_name,b.middle_name,b.last_name,c.suffix) trainee_name,
       GetDealerName(b.dealer_id,b.dealer_category) dealer_name,
       d.job_description
FROM training_program_attendees a LEFT JOIN trainees_masterfile b
      ON a.trainee_id = b.trainee_code
     LEFT JOIN name_suffix c ON c.id = b.name_suffix_id
     LEFT JOIN job_position d ON d.job_id = b.job_position
WHERE b.isDeleted IS NULL