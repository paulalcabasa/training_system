<?php
	
	require_once('../../../libs/tcpdf/tcpdf_include.php');
	require_once("initialize.php");
	$exam = new Exam();
	$encryption = new Encryption();
	$exam_id = $encryption->decrypt($get->d);
	$exam_details = $exam->getExamDetails($exam_id);
	$questions_list = $exam->getExamQuestionsList($exam_id);
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
		//$image_file = K_PATH_IMAGES.'../ss.jpg';
		//$this->Image($image_file, 10, 10, 0, '', 'JPG', '', 'T', false, 0, '', false, false, 0, false, false, false);
		//$style = array('width' => 0.7, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
		//$this->Line(10, 22, 200, 22, $style);
		
	//	$this->writeHTMLCell($w = 0, $h = 0, $x = 10, $y = 17, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
		//$html = "<span style='font-weight:normal;'>Your Responsible Partner</span>";
		//$this->writeHTMLCell($w = 0, $h = 0, $x = 160, $y = 17, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
    }

    // Page footer
    public function Footer() {
		
		//  // Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', '', 6);
		// Page number
		
		$style = array('width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
		//$this->Line(10, $this->GetPageHeight()-12, 200, $this->getPageHeight()-12, $style);
		$this->Cell(0, 10, " ", 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
    
}


// create new PDF document
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Paul Alcabasa');
$pdf->SetTitle('Item Analysis');
$pdf->SetSubject('Exam Item Analysis');
$pdf->SetKeywords('item');

// set default header data
$pdf->SetheaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setFooterData(array(0,0,0), array(0,0,0));

// set header and footer fonts
$pdf->setheaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
$pdf->SetheaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
//$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// tdis metdod has several options, check tde source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'deptd_w'=>0.2, 'deptd_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
$tagvs = array('ul' => array(0 => array('h' => '', 'n' => 0), 1 => array('h'=> '', 'n' => 0)), 'ol' => array(0 => array('h' => '', 'n' => 0), 1 => array('h' =>'', 'n' => 0)));
$pdf->setHtmlVSpace($tagvs);
$html = '<em style="text-align:center;font-size:10px;font-family:Calibri, Tahoma, Arial;font-weight:bold;">'.$exam_details->exam.'</em><br/>';
$html .= '<em style="text-align:center;font-size:10px;font-family:Calibri, Tahoma, Arial;font-weight:normal;">Isuzu Philippines Corporation</em><br/>';
$html .= '<em style="text-align:center;font-size:10px;font-family:Calibri, Tahoma, Arial;font-weight:normal;">Item Analysis</em><br/>';


$item_analysis_html = '<table style="font-size:10px;">'; 
$question_no = 1;
foreach($questions_list as $question){
    $question = (object)$question;
    $choice_list = $exam->getQuestionChoicesList($question->item_id);
    $correct_ctr = 0;
	$incorrect_ctr = 0;
    $item_analysis_html .= '<tr nobr="true"><td>
        <p>'.$question_no . ". " . $question->question.'</p>
        <ol type="a">';
    foreach($choice_list as $choice){
        $choice = (object)$choice;
        $isCorrectAns = $question->choice_id == $choice->choice_id ? "correct_answer_flag" : "";
        $trainee_answered_list = $exam->getTraineeWhoAnsweredPerItem($question->item_id,$choice->choice_id);
		$ctr_trainee_answered = count($trainee_answered_list);
		if($question->choice_id == $choice->choice_id){ // if answer is correct
			$correct_ctr += $ctr_trainee_answered;
		}
		else { // if answer is incorrect
			$incorrect_ctr += $ctr_trainee_answered;
		}

	    $item_analysis_html .= '<li >
				<span >
					'.$choice->choice . " - " . $ctr_trainee_answered.'
				</span>
	    </li>';
    }
        $item_analysis_html .= '</ol><br/>
       	<p style="line-height:-0.5;">Correct : '. $correct_ctr .'</p>
		<p style="line-height:-5px;">Incorrect : '. $incorrect_ctr .'</p></td></tr>';
    $question_no++;
}
$item_analysis_html .= '</table>';
$html .= $item_analysis_html;
 //echo $html;   
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// Close and output PDF document
// tdis metdod has several options, check tde source code documentation for more information.
$pdf->Output('Item-Analysis-' . date('Y-m-dHis') .'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

