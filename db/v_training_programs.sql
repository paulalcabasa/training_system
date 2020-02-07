SELECT a.training_program_id,
       FormatTrainingProgramId(a.training_program_id,a.date_created) tp_id,
       b.title,
       FormatFirstNameFirst(c.first_name,c.middle_name,c.last_name,d.suffix) trainor_name,
       a.venue,
       a.start_date,
       a.end_date
FROM training_programs a 
     LEFT JOIN program b
        ON a.program_id = b.program_code
     LEFT JOIN trainor c 
        ON c.trainor_id = a.trainor_id
     LEFT JOIN name_suffix d
        ON d.id = c.name_extension
ORDER BY a.date_created