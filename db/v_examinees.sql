SELECT a.id,
       b.trainee_code,
       FormatTraineeId(b.trainee_code,e.dealer_abbrev) trainee_id,
       FormatLastNameFirst(b.first_name,b.middle_name,b.last_name,d.suffix)  AS trainee_name,
       a.exam_id
FROM sys_training.trainee_exam_taken a
   LEFT JOIN sys_training.trainees_masterfile b
       ON b.trainee_code = a.trainee_id
   LEFT JOIN sys_training.tp_exam c
      ON c.exam_id = a.exam_id
   LEFT JOIN sys_training.name_suffix d
     ON d.id = b.name_suffix_id
   LEFT JOIN sys_training.dealers_master e
     ON e.id = b.dealer_id
    