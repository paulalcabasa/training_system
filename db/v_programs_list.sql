SELECT a.program_code,
       a.program_category_id,
       a.title,
       b.category_name
FROM program a LEFT JOIN program_category b
ON a.program_category_id = b.program_category_id 
WHERE a.delete_user IS NULL