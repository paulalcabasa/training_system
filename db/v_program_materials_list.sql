SELECT  a.id,
	a.program_code,
	a.filename,
	a.file_dest,
	a.create_user,
	a.date_created,
	FormatEmployeeName(b.first_name,b.middle_name,b.last_name) uploaded_by
FROM program_materials a LEFT JOIN ipc_central.personal_information_tab b
	ON a.create_user = b.employee_id