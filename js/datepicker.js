$( function() {

    $.datepicker.setDefaults({
        closeText: "닫기",
        prevText: "이전달",
        nextText: "다음달",
        currentText: "오늘",
        monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)','7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
        monthNamesShort: ['1월','2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        monthNames: ['1월','2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesShot: ['일', '월', '화', '수', '목', '금', '토'],
        //dayNames: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
        dayNames: ['일', '월', '화', '수', '목', '금', '토'],

        changeMonth: true, //  월 변경가능
        changeYear: true, //  년 변경가능
        showMonthAfterYear: true, //  년 뒤에 월 표시
        dateFormat: "yy-mm-dd",  //  년월일 표시방법  yy-mm-dd 또는 yymmdd
        firstDay: 1, //  0: 일요일 부터 시작, 1:월요일 부터 시작
        autoSize: true, //  default: false, input 사이즈를 자동으로 리사이즈.
        showAnim: "fold", //  default: show , fold

        showWeek: false, //  주차 = true : 보이기 / false : 숨기기
        weekHeader: "주차", //  default: Wk, 주차 헤드 부분의 명칭 설정

        showButtonPanel: true, //  하단에 Today, Done 버튼 Display
        gotoCurrent: false, //  default: false, true일 경우에는 Today버튼 클릭 시 현재 일자로 이동하지 못함

        // 달력버튼 관련
        showOn: "button",
        buttonText: "달력",
    });

    // 달력 하나씩 사용할때
    $( "#datepicker" ).datepicker({

    });

    // 시작날짜와 끝나는 날짜를 함께 선택해서 사용할때
    var dates = $( "#datepicker_from, #datepicker_to" ).datepicker({
        //defaultDate: "+1w",  // 기본선택일이 1 week 이후가 선택되는 옵션
        changeMonth: true,
        numberOfMonths: 2,  // 한눈에 보이는 월달력수
        onSelect: function( selectedDate ) {
            var option = this.id == "datepicker_from" ? "minDate" : "maxDate",
                instance = $( this ).data( "datepicker" ),
                date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });

} );