<html>
	<head>
		<title>Hamt - 덧셈 연습문제 제작기</title>
		<script src="https://unpkg.com/vue@2.6.6/dist/vue.js"></script>
		<script src="http://code.jquery.com/jquery-3.0.0.min.js"></script>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
		<meta name="apple-mobile-web-app-capable" content="no" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		<meta name="format-detection" content="telephone=no" />
		<style>
			h1 { text-align:center; color:black; text-decoration:underline; }
			ul li.quiz-item {
				float:left;
				width:10%;
				margin:10px 4%;
				list-style-type:none;
			}
			p.number { font-family:arial; font-size:1em; font-weight:bold; text-align:right; }
			p.number.bottom{ border-bottom:2px solid black; background: url(/quiz_assets/plus.png) no-repeat left 2px;background-size:14px; padding:0px 0px 10px 0px;}
			p.answer{ color:red; }
			p.answer.hide{ color:white; }
			input.num { width:50px; }

			@media print {
			#setting-wrap { display:none; }
			}
		</style>
	</head>
	<body>
		<a href='/plus.php'><h1>여러자리 덧셈 연습</h1></a>
		<hr />
		<div id='setting-wrap'>
		<?php
		$dan = array(1, 2, 3, 4, 5, 6, 7, 8, 9);

		$top_from = 1;
		$top_to = 2;

		$bottom_from = 1;
		$bottom_to = 1;

		$save_path = dirname(__FILE__).'/save_quizes';
		$pagekey = 'plus_'.md5(date('YmdHis').rand(100000, 999999));

		// 저장된 페이지는 불러와 보여준다.
		if(isset($_GET['pagekey']) && is_file($save_path.'/'.$_GET['pagekey'])) {
			$pagekey = $_GET['pagekey'];
			$_GET = unserialize(file_get_contents($save_path.'/'.$_GET['pagekey']));
			$_GET['pagekey'] = $pagekry;
		} 


		if( ! isset($_GET['quizes'])) {
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

			include './lib/QuizCreator.php';
			$multi = new Plus;
			$multi->setDan($dan);
			$multi->setTopNumCount($top_from, $top_to);
			$multi->setBottomNumCount($bottom_from, $bottom_to);
			$quizes = $multi->createQuiz(30);

			if(isset($_GET['save_file']) && $_GET['save_file'] == 'Y') {
				$_GET['quizes'] = $quizes;
				file_put_contents($save_path.'/'.$pagekey, serialize($_GET));
			}
		} else {
			$quizes = $_GET['quizes'];
		}
		?>
		<center>
			<input type='button' value='설정 보이기/숨기기' onclick="$('#setting').toggle('slow');" />
			<input type='button' value='답안' onclick="$('.answer').toggleClass('hide');" />
			<input type='button' value='인쇄하기' onclick="window.print()" />
		<div id='setting' style='text-align:center;'>
			<h5>[보이기/숨기기] 클릭시 답안이 감춰집니다. '숨기기' 후 캡쳐, 출력하세요.</h3>
			<h5>[답안지 저장하기] 체크 후 [문제 만들기] 시 나타나는 주소(URL)는 본인 카톡으로 보내 놓는 등 개별 저장 해 주세요.</h3>

			<?php if(isset($_GET['save_file']) && $_GET['save_file'] == 'Y') : ?> 
				답안지 페이지 : http://hamt.kr/plus.php?pagekey=<?=urlencode($pagekey)?>
				<br />
				(본인 카톡으로 보내놓는 등 저장 해 두세요!)
				<br />
			<?php else : ?>

			<form style='line-height:160%;'>
				위 숫자 자리수 : 
				<input type='number' name='top_from' class='num' maxlength='1' value="<?=$top_from?>" />
				~ <input type='number' name='top_to' class='num' maxlength='1' value="<?=$top_to?>" />
				<br />

				아래 숫자 자리수 : 
				<input type='number' name='bottom_from' class='num'  maxlength='1' value="<?=$bottom_from?>" />
				~ <input type='number' name='bottom_to' class='num'  maxlength='1' value="<?=$bottom_to?>" />
				<br />

				아랫자리 구성 숫자 : 
				<?php foreach(array(1, 2, 3, 4, 5, 6, 7, 8, 9) as $k => $v) : ?>
				<input type='checkbox' name='dan[<?=$k?>]' value='<?=$v?>' <?=(in_array($v, $dan)) ? 'checked' : ''?> /> <?=$v?>
				<?php endforeach; ?>
				<br /><br />
				<input type='checkbox' name='save_file' value='Y' />  답안지 저장하기
				<br /><br />
				<input type='submit' value='문제 만들기' />
			</form>
			<?php endif; ?>
		</div>
		</center>
		</div>
		<ul id="app-loop">
			<li class='quiz-item' v-for="quiz in quizes">
				<span>
				<p class='number'>{{quiz.top}}</p>
				<p class='number bottom'>{{quiz.bottom}}</p>
				<p class='number answer'>{{quiz.answer}}</p>
				</span>
			</li>
		</ul>

		<script>
		var app_loop = new Vue({
			el: '#app-loop',
			data : {
				quizes: <?=json_encode($quizes)?>
			}
		});
		</script>
	</body>
</html>
