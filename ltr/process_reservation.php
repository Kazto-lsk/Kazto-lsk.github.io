<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 폼 데이터 가져오기
    $checkboxValues = isset($_POST['checkboxes']) ? $_POST['checkboxes'] : [];
    $carNumber = isset($_POST['car_number']) ? $_POST['car_number'] : '';
    $move1 = isset($_POST['move_1']) ? $_POST['move_1'] : '';
    $move2 = isset($_POST['move_2']) ? $_POST['move_2'] : '';
    $moveKm1 = isset($_POST['move_km1']) ? $_POST['move_km1'] : '';
    $moveKm2 = isset($_POST['move_km2']) ? $_POST['move_km2'] : '';

    $moveKm1 = number_format($moveKm1);
    $moveKm2 = number_format($moveKm2);


    $moveLocation = isset($_POST['move_location']) ? $_POST['move_location'] : '';
    if($moveLocation === ''){
        //값이 없을때 기본 값으로
        $moveLocation = "분당->GS->분당";
    }
    $oilPrice = isset($_POST['oil_price']) ? $_POST['oil_price'] : '';
    if($oilPrice != ''){
        $oilPrice = number_format($oilPrice);
    }

    

    // 여기에서 필요한 처리를 수행하고 결과 생성
    $result = "<h2 class='mb-4 font-semibold text-gray-800 text-2xl lg:text-5xl dark:text-gray-200'>분당예약소 세차/이동간 자동화 결과</h2>";
    $result = "<div id='clip_board'>";
    $result .= "<p>" . implode(', ', $checkboxValues) . "<br>";
    $result .= "$carNumber<br>";
    $result .= "$move1 -> $move2<br>";
    $result .= "$moveKm1 -> $moveKm2<br>";
    $result .= "8 -> 8<br>";
    $result .= "$moveLocation<br>";
    if($oilPrice === ''){
        //기름 값이 없는 경우 빈 값
    }else{
        $result .= "$oilPrice 원<br></p>";
    }
    $result .= "</div>";
    //$result .= "<input type='button' class='py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600' value='클립보드 복사' onclick='copyToClipboard()'>";
    //$result .= "<button onclick='shareKakao()'>카카오톡으로 공유하기</button>";
    

    // 결과 반환
    echo $result;
} else {
    // POST 요청이 아닌 경우 에러 메시지 출력
    echo "잘못된 요청입니다.";
}
?>
