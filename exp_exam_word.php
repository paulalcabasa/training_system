<?php
//require_once("initialize.php");
require_once("classes/class.encryption.php");
require_once("classes/class.exam.php");
require_once("classes/class.database.php");
require_once '../../../libs/phpword/src/PhpWord/Autoloader.php';
$get = (object)$_GET;
\PhpOffice\PhpWord\Autoloader::register();
$encryption = new Encryption();
$exam = new Exam();
// Creating the new document...
$exam_id = $encryption->decrypt($get->d);
$phpWord = new \PhpOffice\PhpWord\PhpWord();

$exam_details = $exam->getExamDetails($exam_id);
/* Note: any element you append to a document must reside inside of a Section. */

// Adding an empty Section to the document...
/*$section = $phpWord->addSection();
$html = $program->generateExamForWord(1);
\PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);*/

$sectionStyle = array('marginTop' => 560);
$phpWord->addFontStyle('pageFontStyle', array('name' => 'Calibri', 'size' => '10'));
$phpWord->addFontStyle('rStyle', array('bold' => true,'italic' => true, 'name' => 'Calibri', 'size' => '10'));
$phpWord->addFontStyle('subStyle', array('italic' => true, 'name' => 'Calibri', 'size' => '10'));
$phpWord->addParagraphStyle('pStyle', array('alignment' => 'center', 'spaceAfter' => 25 , 'spaceBefore' => 25));
$phpWord->addParagraphStyle('list_space_style', array('spaceAfter' => 0 , 'spaceBefore' => 0));
$phpWord->addParagraphStyle('question_style', array('spaceAfter' => 100 , 'spaceBefore' => 100));
$phpWord->addParagraphStyle('page_ins_style', array('spaceAfter' => 25 , 'spaceBefore' => 25, 'alignment' => 'left'));
$phpWord->addFontStyle('name_style', array('bold' => true, 'name' => 'Calibri', 'size' => '11'));
$phpWord->addFontStyle('ins_style', array('name' => 'Calibri', 'size' => '11'));
$phpWord->addNumberingStyle(
    'multilevel',
    array(
        'type'   => 'multilevel',
        'levels' => array(
            array('format' => 'decimal', 'text' => '%1)', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
            array('format' => 'lowerLetter', 'text' => '%2.', 'left' => 1080, 'hanging' => 360, 'tabPos' => 720),
        )
    )
);



// Begin code


$section = $phpWord->addSection($sectionStyle);
$section->addText(htmlspecialchars($exam_details->exam, ENT_COMPAT, 'UTF-8'), 'rStyle', 'pStyle');
$section->addText(htmlspecialchars('Isuzu Philippines Corporation', ENT_COMPAT, 'UTF-8'), 'subStyle', 'pStyle');
$section->addText(htmlspecialchars('Product Knowledge Exam', ENT_COMPAT, 'UTF-8'), 'subStyle', 'pStyle');
$section->addTextBreak(1);
$section->addText(htmlspecialchars('Name: ______________________________			Date: ______________', ENT_COMPAT, 'UTF-8'), 'name_style', 'page_ins_style');
$section->addText(htmlspecialchars('Department/Section: __________________			Score: ______________', ENT_COMPAT, 'UTF-8'), 'name_style', 'page_ins_style');
$section->addText(htmlspecialchars('Multiple Choice: Encircle the letter of the correct answer.', ENT_COMPAT, 'UTF-8'), 'ins_style', 'page_ins_style');
// Style definition

$questions_list = $exam->getExamQuestionsList($exam_id);
foreach($questions_list as $question){
	$question = (object)$question;
	$item_id = $question->item_id;
	$section->addListItem(
		htmlspecialchars($question->question, ENT_COMPAT, 'UTF-8'), 
		0, 
		'pageFontStyle', 
		'multilevel',
		'question_style'
	);
	$choice_list = $exam->getQuestionChoicesList($question->item_id);
	foreach($choice_list as $choice){
		$choice = (object)$choice;
		$choice_name = $choice->choice;
		$section->addListItem(
			htmlspecialchars($choice_name, ENT_COMPAT, 'UTF-8'), 
			1, 
			'pageFontStyle', 
			'multilevel',
			'list_space_style'
		);
	
	}
}

// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

$filename = "Exam-". time() . "". $exam_id . ".docx";

$objWriter->save($filename);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($filename));
flush();
readfile($filename);
unlink($filename); // deletes the temporary file
exit;

/*// Saving the document as ODF file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
$objWriter->save('helloWorld.odt');

// Saving the document as HTML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
$objWriter->save('helloWorld.html');*/

/* Note: we skip RTF, because it's not XML-based and requires a different example. */
/* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */