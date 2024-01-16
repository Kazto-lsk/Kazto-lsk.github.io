<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 체크박스 값 가져오기
    $checkboxValues = isset($_POST['checkboxes']) ? $_POST['checkboxes'] : [];

    // 인풋 값 가져오기
    $inputValue = isset($_POST['input']) ? $_POST['input'] : '';

    // 결과 생성
    $result = "<h2>결과</h2>";

    // 체크박스 값이 배열이므로 각각 처리
    if (!empty($checkboxValues)) {
        $result .= "<p>체크박스 값:</p>";
        $result .= "<ul>";
        foreach ($checkboxValues as $checkboxValue) {
            $result .= "<li>$checkboxValue</li>";
        }
        $result .= "</ul>";
    } else {
        $result .= "<p>체크박스가 선택되지 않았습니다.</p>";
    }

    // 인풋 값 출력
    $result .= "<p>인풋 값: $inputValue</p>";

    // 결과 반환
    echo $result;
} else {
    // POST 요청이 아닌 경우 에러 메시지 출력
    echo "잘못된 요청입니다.";
}
?>
