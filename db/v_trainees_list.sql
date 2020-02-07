SELECT a.trainee_code,
       FormatTraineeId(a.trainee_code,c.dealer_abbrev) trainee_id,
       FormatLastNameFirst(a.first_name,a.middle_name,a.last_name,b.suffix) trainee_name,
       c.dealer_name,
       a.picture,
       d.job_description
FROM trainees_masterfile a LEFT JOIN name_suffix b 
	ON a.name_suffix_id = b.id
     LEFT JOIN dealers_master c 
        ON c.id = a.dealer_id
     LEFT JOIN job_position d
        ON d.job_id = a.job_position_id
WHERE a.date_deleted IS NULL
ORDER BY a.last_name, a.first_name ASC