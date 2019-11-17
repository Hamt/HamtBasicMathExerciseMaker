<?php
/*///////////////////////
산수 학습문제 만들기 제작기

2019.9.22 함승목
///////////////////////*/


// 곱하기 문제 제작기
class Multiply {
	// 구구단 외운 단 수 => 아래 곱 숫자에 적용한다
	protected $dan = array(1, 2, 3, 4, 5, 6, 7, 8, 9);

	protected $top_num_count = array(
		'from' => 2,
		'to' => 2
	);

	// 아래 곱 숫자 개수
	protected $bottom_num_count = array(
		'from' => 1,
		'to' => 1
	);

	public function setDan($dan_array) {
		$this->dan = $dan_array;
	}
	public function setTopNumCount($from, $to) {
		$this->top_num_count['from'] = $from;
		$this->top_num_count['to'] = $to;
	}
	public function setBottomNumCount($from, $to) {
		$this->bottom_num_count['from'] = $from;
		$this->bottom_num_count['to'] = $to;
	}

	public function createQuiz($quiz_count) {
		$result = array();
		for($i = 0 ; $i < $quiz_count ; $i++) {
			$result[$i] = array(
				'top' => $this->getTopNumber(),
				'bottom' => $this->getBottomNumber(),
			);
			$result[$i]['answer'] = $result[$i]['top'] * $result[$i]['bottom'];
		}
		return $result;
	}

	protected function getTopNumber() {
		// 몇자리 숫자로 할지
		$num_count = rand($this->top_num_count['from'], $this->top_num_count['to']);
		$from = pow(10, $num_count-1); 	// $num_count == 3 이면 10^2 		==> 100
		$to = pow(10, $num_count)-1;	// $num_count == 3 이면 10^3 => 1000 -1 ==> 999
		return rand($from, $to);
	}
	protected function getBottomNumber() {
		// 몇자리 숫자로 할지
		$num_count = rand($this->bottom_num_count['from'], $this->bottom_num_count['to']);
		$dan = array_values($this->dan);
		$num_str = '';

		for($i == 0 ; $i < $num_count ; $i++) {

			$num_idx = rand(0, sizeof($dan)-1);
			$num = $dan[$num_idx];

			if($i == 0) {
				// 두번째 자리부터는 0이 추가도도 된다.
				$dan[] = 0;
			}
			if(sizeof($dan) > $num_count - $i) {
				unset($dan[$num_idx]);
			}
			$num_str .= intval($num);
		}

		return $num_str;
	}
}


class Plus extends Multiply {

	public function createQuiz($quiz_count) {
		$result = array();
		for($i = 0 ; $i < $quiz_count ; $i++) {
			$result[$i] = array(
				'top' => $this->getTopNumber(),
				'bottom' => $this->getBottomNumber(),
			);
			$result[$i]['answer'] = $result[$i]['top'] + $result[$i]['bottom'];
		}
		return $result;
	}


}


class Divide extends Multiply {

	public function createQuiz($quiz_count) {
		$result = array();
		for($i = 0 ; $i < $quiz_count ; $i++) {
			$result[$i] = array(
				'top' => $this->getTopNumber(),
				'bottom' => $this->getBottomNumber(),
			);
			$result[$i]['answer'] = intval($result[$i]['top'] / $result[$i]['bottom']);
			$result[$i]['answer'] .= '...';
			$result[$i]['answer'] .= $result[$i]['top'] % $result[$i]['bottom'];
		}
		return $result;
	}


}
