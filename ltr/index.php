<?php
    // 현재 시간을 'HH:II' 형식으로 가져오기
    $current_time = date('H:i');

    // 15분 뒤의 시간 계산
    $future_time = date('H:i', strtotime($current_time) + (15 * 60));


?>

<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSS HS -->
        <link rel="stylesheet" href="../main.min.css" />
        <link rel="stylesheet" as="style" crossorigin href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable-dynamic-subset.min.css" />

        <style>
            * {
                font-family: "Pretendard Variable", Pretendard, -apple-system, BlinkMacSystemFont, system-ui, Roboto, "Helvetica Neue", "Segoe UI", "Apple SD Gothic Neo", "Noto Sans KR", "Malgun Gothic", "Apple Color Emoji",
                    "Segoe UI Emoji", "Segoe UI Symbol", sans-serif;
            }
        </style>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <title>분당 예약소 자동화 서비스</title>
    </head>

<body class="container mx-auto p-4">

    <!-- Announcement Banner -->
    <div class="bg-gradient-to-r from-red-500 via-purple-400 to-blue-500">
        <div class="max-w-[85rem] px-4 py-4 sm:px-6 lg:px-8 mx-auto">
            <!-- Grid -->
            <div class="grid justify-center md:grid-cols-2 md:justify-between md:items-center gap-2">
                <div class="text-center md:text-start">
                    <p class="mt-1 text-white font-medium">
                    분당예약소 세차/이동간 자동화 툴
                    </p>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Grid -->
        </div>
    </div>
    <!-- End Announcement Banner -->



<form id="myForm" class="pt-8 pb-8" autocomplete="off">
    <div class="bg-gray rounded-md">
        이동 시간의 경우 시간 초기화를 누르면 버튼을 누른 시간으로 출발 시간이 설정되며, 도착시간은 출발 시간 으로부터 15분 후로 자동 입력됩니다.
    </div>
    
    <br><br>

    <!-- 체크박스들 -->
    <input type="checkbox" id="checkbox1" name="checkbox[]" checked value="주유이동">
    <label for="checkbox1">주유이동</label>
    

    <input type="checkbox" id="checkbox2" name="checkbox[]" checked value="세차 이동(내/외부)">
    <label for="checkbox2">세차 이동 (내/외부)</label>
    
    <input type="checkbox" id="checkbox3" name="checkbox[]" value="정비이동">
    <label for="checkbox3">정비이동</label>
    
    <input type="checkbox" id="checkbox4" name="checkbox[]" value="딜리버리 이동">
    <label for="checkbox4">딜리버리</label>
    

    <br><br>

    <!-- 입력 폼 -->
    <label for="car_number">차량번호</label>
    <input class="w-28" type="text" id="car_number" name="car_number" required="required" autocomplete='false' autocomplete='off' >
    <input type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" value="초기화" onClick="window.location.reload()">
    <br><br>

    <label for="move_1">출발</label>
    <input class="w-20" type="text" id="move_1" name="move_1" value="<?php echo $current_time; ?>" required="required" autocomplete='false' autocomplete='off'>

    <label for="move_2">도착</label>
    <input class="w-20" type="text" id="move_2" name="move_2" value="<?php echo $future_time; ?>" required="required" autocomplete='false' autocomplete='off' >
    <input type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" value="시간 초기화" onclick="updateInput()">
    <br><br>

    <label for="move_km1">출발 km</label>
    <input class="w-20" type="text" id="move_km1" name="move_km1" required="required" autocomplete='false' autocomplete='off'>

    <label for="move_km2">도착 km</label>
    <input class="w-20" type="text" id="move_km2" name="move_km2" required="required" autocomplete='false' autocomplete='off'>

    <br><br>

    <label for="move_location">이동경로 (미입력시 분당 GS 분당)</label>
    <input class="w-20" type="text" id="move_location" name="move_location" required="required" autocomplete='false' autocomplete='off'>

    <br><br>

    <label for="oil_price">주유금액(미입력시 미출력)</label>
    <input class="w-20" type="text" id="oil_price" name="oil_price" required="required" autocomplete='false' autocomplete='off'>

    <br><br>

    <!-- 제출 버튼 -->
    <input type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" value="확인" onclick="submitForm()">
    <input type='button' class='py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600' value='클립보드 복사' onclick='copyToClipboard()'>
</form>



<div id="result-container"></div>
<script>
    function submitForm() {
        // 폼 데이터 가져오기
        var formData = {
            checkboxes: $('input[name="checkbox[]"]:checked').map(function(){
                return $(this).val();
            }).get(),
            car_number: $('#car_number').val(),
            move_1: $('#move_1').val(),
            move_2: $('#move_2').val(),
            move_km1: $('#move_km1').val(),
            move_km2: $('#move_km2').val(),
            move_location: $('#move_location').val(),
            oil_price: $('#oil_price').val()
        };

        // AJAX 요청
        $.ajax({
            type: 'POST',
            url: 'process_reservation.php', 
            data: formData,
            success: function(response) {
                // 결과를 출력할 컨테이너에 내용 업데이트
                $('#result-container').html(response);
            }
        });
    }
</script>


<script>
function copyToClipboard() {
    // 특정 div의 텍스트 가져오기
    var textToCopy = document.getElementById('clip_board').innerText;

    // 새로운 textarea 엘리먼트 생성
    var textarea = document.createElement('textarea');
    textarea.value = textToCopy;

    // textarea를 문서에 추가
    document.body.appendChild(textarea);

    // textarea 내용을 선택하고 복사
    textarea.select();
    document.execCommand('copy');

    // textarea 제거
    document.body.removeChild(textarea);

    alert('텍스트가 클립보드에 복사되었습니다.');
}
</script>


<script>
// 현재 시간을 가져오고 'HH:ii' 형식으로 변환하는 함수
function getCurrentTime() {
    var now = new Date();
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    return hours + ':' + minutes;
}

// 15분 후의 시간을 계산하는 함수
function calculateTimeAfter15Minutes() {
    var now = new Date();
    now.setMinutes(now.getMinutes() + 15);
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    return hours + ':' + minutes;
}

// 현재 시간으로 input 업데이트하는 함수
function updateInput() {
    var currentTime = getCurrentTime();
    var next_time = calculateTimeAfter15Minutes();
    document.getElementById('move_1').value = currentTime;
    document.getElementById('move_2').value = next_time;
}

// 초기화면에 현재 시간 표시
//document.getElementById('currentTime').innerText = getCurrentTime();
</script>


<footer class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <!-- Grid -->
    <div class="text-center">
        <div>
            <a class="flex-none text-xl font-semibold text-black dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/" aria-label="Brand">ICETEA</a>
        </div>
        <!-- End Col -->

        <div class="mt-3">
            <p class="text-gray-500">본 서비스는 <a class="font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400" href="#">분당예약소</a> 의 고유 서비스입니다.</p>
            <p class="text-gray-500">© ICETEA. All rights reserved.</p>
        </div>

    </div>
    <!-- End Grid -->
</footer>


</body>
</html>
