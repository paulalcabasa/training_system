SELECT tei.item_id,
       tei.exam_id,
       tei.question,
       tec.choice,
       tei.choice_id 
FROM tp_exam_items tei INNER JOIN tp_exam_choices tec 
	ON tei.choice_id = tec.choice_id 
ORDER BY date_created ASC