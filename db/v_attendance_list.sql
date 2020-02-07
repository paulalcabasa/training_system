SELECT a.id,
       a.tp_id,
       a.tpm_module_id,
       FormatTraineeId(b.trainee_code,d.dealer_abbrev) trainee_id,
       FormatLastNameFirst(b.first_name,b.middle_name,b.last_name,c.suffix) trainee_name,
       d.dealer_name,
       a.time_in
FROM tp_trainee_attendance a LEFT JOIN trainees_masterfile b
	ON a.trainee_id = b.trainee_code 
     LEFT JOIN name_suffix c
	ON c.id = b.name_suffix_id
     LEFT JOIN dealers_master d
	ON d.id = b.dealer_id