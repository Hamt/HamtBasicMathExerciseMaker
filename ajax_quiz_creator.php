<?php
/*
params : $_GET = array(
	'top_from' => int,
	'top_to' => int,
	'bottom_from' => int,
	'bottom_to' => int,
	'dan' => array( 0 < num < 10 list)
);
*/

include './lib/QuizCreator.php';

// 문제 타입 파라메터
$allow_types = array(
	'plus',
	'pinus',
	'pultiply',
	'minus',
	'divide',
);

$type = 'plus';
if( !empty($_GET['type']) && in_array($_GET['type'], $allow_types)) {
	$type = $_GET['type'];
}
$type = ucfirst($type);


// 위 숫자 자릿수 범위. 만약 10자리 ~ 100자리 로 구성하려면 top_from=2, top_to=3
$top_from = 2;
$top_to = 3;

// 아래 숫자 자릿수 범위. 만약 10자리 ~ 100자리 로 구성하려면 bottom_from=2, bottom_to=3
$bottom_from = 2;
$bottom_to = 3;

// 곱셈을 예로, 아래 숫자들은 구구단을 외운 단으로 구성된 숫자만 나와야 풀 수 있다. 아래 구성될 숫자 구성 선택.
$dan = array(1, 2, 3, 4, 5, 6, 7, 8, 9);

// 기본값 파라메터로 편집
foreach($_GET as $k => $v) {
	if(in_array($k, array(
					'top_from', 
					'top_to', 
					'bottom_from', 
					'bottom_to', 
					'dan'
			     ))) {
		${$k} = $v;
	}
}

$quizObj = new $type;
$quizObj->setDan($dan);
$quizObj->setTopNumCount($top_from, $top_to);
$quizObj->setBottomNumCount($bottom_from, $bottom_to);
$quizes = $quizObj->createQuiz(30);

echo json_encode($quizes);
